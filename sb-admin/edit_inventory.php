<?php
include '../database/db.php';
include './layout/header.php';
?>

<?php
$errors = [];
$success = [];
?>

<?php
if (isset($_GET['ItemID'])) {
    $ItemID = $_GET['ItemID'];
    $sql = "SELECT * FROM inventory WHERE ItemID = :ItemID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':ItemID', $ItemID, PDO::PARAM_INT);
    $stmt->execute();
    $inventory = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$inventory) {
        $errors[] = "Inventory not found!";
    }
} else {
    $errors[] = "Invalid Inventory ID!";
}
if (isset($_POST['edit_inventory'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $unitprice = $_POST['unitprice'];
    $reorderlevel = $_POST['reorderlevel'];
    if (empty($name)) {
        $errors[] = "Name is required!";
    }
    if (empty($description)) {
        $errors[] = "Description is required!";
    }
    if (empty($quantity)) {
        $errors[] = "Quantity is required!";
    }
    if (empty($unitprice)) {
        $errors[] = "UnitPrice is required!";
    }
    if (empty($reorderlevel)) {
        $errors[] = "ReorderLevel is required!";
    }
    if (count($errors) == 0) {
        $sql = "UPDATE inventory SET itemName = :name, description = :description, quantity = :quantity, unitprice = :unitprice, reorderlevel = :reorderlevel WHERE ItemID = :ItemID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $itemName, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':unitprice', $unitprice, PDO::PARAM_STR);
        $stmt->bindParam(':reorderlevel', $reorderlevel, PDO::PARAM_INT);
        $stmt->bindParam(':ItemID', $ItemID, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $success[] = "Inventory updated successfully!";
        } else {
            $errors[] = "Failed to update Inventory!";
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
                        <h1 class="text-center fw-bold mb-4">Edit Inventory</h1>

                        <form action="" class="row" method="post">
                            <!-- Name Field -->
                            <input type="hidden" name="id" value="<?= $career['ItemID']; ?>">

                            <div class="col-12">
                                <label for="name" class="form-label"> Item Name</label>
                                <input type="text" class="form-control" value="<?= $inventory['itemName']; ?>" name="name" required>
                            </div>

                            <!-- Description Field -->
                            <div class="col-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="3" required><?= $inventory['description']; ?></textarea>
                            </div>

                            <div class="col-12">
                                <label for="name" class="form-label"> Quantity </label>
                                <input type="number" class="form-control" value="<?= $inventory['quantity']; ?>" name="quantity"  required>
                            </div>
                            <div class="col-12">
                                <label for="name" class="form-label"> UnitPrice</label>
                                <input type="text" class="form-control" value="<?= $inventory['unitPrice']; ?>" name="unitprice"  required>
                            </div>

                            <div class="col-12">
                                <label for="name" class="form-label">ReorderLevel</label>
                                <input type="number" class="form-control" value="<?= $inventory['reorderLevel']; ?>" name="reorderlevel"  required>
                            </div>
                            <!-- Submit Button -->
                            <div class="col-12 text-center mt-3">
                                <input type="submit" name="edit_inventory" value="Edit Inventory" class="btn btn-success">
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