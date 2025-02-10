<?php
include '../database/db.php';
include './layout/header.php';
?>

<?php
$errors = [];
$success = [];
?>

<?php
if (isset($_POST['plan'])) {
    $plan_name = $_POST['plan_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];

    if (empty($plan_name)) {
        $errors[] = 'Plan name is required';
    }
    if (empty($description)) {
        $errors[] = 'Description is required';
    }
    if (empty($price) ) {
        $errors[] = 'Valid price is required';
    }
    if (empty($duration)) {
        $errors[] = 'Duration is required';
    }

    if (empty($errors)) {
        $sql = "INSERT INTO membership_plans (plan_name, description,price,duration) VALUES (:name, :description,:price,:duration)";
        $result = $pdo->prepare($sql);
        $result->bindParam(':name', $plan_name, PDO::PARAM_STR);
        $result->bindParam(':description', $description, PDO::PARAM_STR);
        $result->bindParam(':price', $price, PDO::PARAM_INT);
        $result->bindParam(':duration', $duration, PDO::PARAM_INT);
        $result->execute();

        if ($result) {
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
                        <h1 class="text-center fw-bold mb-4">Create Member</h1>

                        <form action="create_member.php" method="post">
                            <!-- Plan ID -->
                          
                            <div class="form-group">
                                <label for="plan_name">Plan Name</label>
                                <select class="form-control" name="plan_name">
                                    <option value="basic">Basic</option>
                                    <option value="standard">Standard</option>
                                    <option value="premium">Premium</option>
                                </select>
                            </div>


                            <!-- Description -->
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" rows="3" name="description" placeholder="Enter plan description" required></textarea>
                            </div>

                            <!-- Price -->
                            <div class="form-group">
                                <label for="price">Price ($)</label>
                                <input type="number" class="form-control" name="price" placeholder="Enter price" required>
                            </div>

                            <!-- Duration -->
                            <div class="form-group">
                                <label for="duration" name="duration">Duration</label>
                                <select class="form-control" name="duration">
                                   
                                    <option value="3">3 Months</option>
                                    <option value="6">6 Months</option>
                                    <option value="12">12 Months</option>
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" name="plan" class="btn btn-primary btn-block">Create Plan</button>
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