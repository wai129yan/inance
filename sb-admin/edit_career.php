<?php
include '../database/db.php';
include './layout/header.php';

$errors = [];
$success = [];

if (isset($_GET['career_id'])) {
    $career_id = $_GET['career_id'];


    $sql = "SELECT * FROM careeries WHERE career_id = :career_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':career_id', $career_id, PDO::PARAM_INT);
    $stmt->execute();
    $career = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$career) {
        $errors[] = "Career not found!";
    }
} else {
    $errors[] = "Invalid career ID!";
}

if (isset($_POST['update_career'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];

    if (empty($name)) {
        $errors[] = "Career name is required!";
    }
    if (empty($description)) {
        $errors[] = "Description is required!";
    }

    if (count($errors) == 0) {

        $sql = "UPDATE careeries SET name = :name, description = :description WHERE career_id = :career_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':career_id', $career_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $success[] = "Career updated successfully!";
        } else {
            $errors[] = "Failed to update career!";
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
                        <!-- Display errors and success messages -->
                        <?php
                        include '../errors.php';
                        include '../success.php';
                        ?>
                        <!-- Form starts here -->
                        <h1 class="text-center fw-bold mb-4">Edit Career</h1>

                        <!-- Edit Career Form -->
                        <form action="" class="row" method="post">

                            <input type="hidden" name="id" value="<?= $career['career_id']; ?>">


                            <div class="col-12">
                                <label for="name" class="form-label">Career Name</label>
                                <input type="text" class="form-control" value="<?= $career['name']; ?>" name="name" required>
                            </div>


                            <div class="col-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="3" required><?= $career['description']; ?></textarea>
                            </div>


                            <div class="col-12 text-center mt-3">
                                <input type="submit" name="update_career" value="Update Career" class="btn btn-success">
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
        </div>
    </div>
</div>

