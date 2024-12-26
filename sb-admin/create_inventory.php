<?php
include '../database/db.php';
include './layout/header.php';
?>

<?php
$errors = [];
$success = [];
?>

<?php
if (isset($_POST['create_inventory'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $unitprice = $_POST['unitprice'];
    $reorderlevel = $_POST['reorderlevel'];
    $errors = []; 

    
    empty($name) ? $errors[] = "Name Required" : "";
    empty($description) ? $errors[] = "Description Required" : "";
    empty($quantity) ? $errors[] = "Quantity Required" : "";
    empty($unitprice) ? $errors[] = "UnitPrice Required" : "";
    empty($reorderlevel) ? $errors[] = "ReorderLevel Required" : "";

    
    // Ensure unit price is a valid number and not empty
    if (!is_numeric($unitprice) || $unitprice <= 0) {
        $errors[] = "Invalid UnitPrice";
    }

    // Continue if there are no errors
    if (count($errors) == 0) {
        // Insert query
        $sql = "INSERT INTO inventory (itemName, description, quantity, unitPrice, reorderLevel) 
                VALUES (:name, :description, :quantity, :unitPrice, :reorderLevel)";
        $result = $pdo->prepare($sql);

        // Bind parameters
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':description', $description, PDO::PARAM_STR);
        $result->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $result->bindParam(':unitPrice', $unitprice, PDO::PARAM_STR); // Ensure correct data type
        $result->bindParam(':reorderLevel', $reorderlevel, PDO::PARAM_INT);

        // Execute the query and check the result
        if ($result->execute()) {
            $success[] = "Created Successfully";
        } else {
            $errors[] = "Failed to create the record.";
        }
    }
}
?>


<!-- Page Wrapper -->
<div id="wrapper">
    <!-- Sidebar -->
    <?php
    include './layout/sidebar.php';
    ?>
    <!-- End of Sidebar -->
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Topbar -->
            <?php
            include './layout/topbar.php';
            ?>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container mt-5">
                <!-- Page Heading -->
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <?php
                        include '../errors.php';
                        include '../success.php';
                        ?>
                        <!-- Form starts here -->
                        <h1 class="text-center fw-bold mb-4">Create Inventory</h1>

                        <form action="create_inventory.php" class="row" method="post">
                            <!-- Name Field -->
                            <div class="col-12">
                                <label for="name" class="form-label"> Item Name</label>
                                <input type="text" class="form-control" name="name" value="" required>
                            </div>

                            <!-- Description Field -->
                            <div class="col-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="3" required></textarea>
                            </div>

                            <div class="col-12">
                                <label for="name" class="form-label"> Quantity </label>
                                <input type="number" class="form-control" name="quantity" value="" required>
                            </div>
                            <div class="col-12">
                                <label for="name" class="form-label"> UnitPrice</label>
                                <input type="text" class="form-control" name="unitprice" value="" required>
                            </div>

                            <div class="col-12">
                                <label for="name" class="form-label">ReorderLevel</label>
                                <input type="number" class="form-control" name="reorderlevel" value="" required>
                            </div>
                            <!-- Submit Button -->
                            <div class="col-12 text-center mt-3">
                                <input type="submit" name="create_inventory" value="Create Inventory" class="btn btn-success">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            <!-- Footer (Make sure this is inside the container) -->
            <?php
            include './layout/footer.php';
            ?>
            <!-- /.container -->