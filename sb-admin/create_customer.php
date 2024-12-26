<?php
include '../database/db.php';
include './layout/header.php';
?>

<?php
$errors = [];
$success = [];
?>

<?php
if (isset($_POST['create_customer'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    empty($name) ? $errors[] = "Name Required" : "";
    empty($email) ? $errors[] = "Email Required" : "";
    empty($password) ? $errors[] = "Password Required" : "";
    empty($phone) ? $errors[] = "Phone Required" : "";
    empty($address) ? $errors[] = "Address Required" : "";
    if (count($errors) == 0) {
        $sqlEmail = "SELECT COUNT(*) FROM customers WHERE email = :email";
        $stmt = $pdo->prepare($sqlEmail);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count) {
            $errors[] = "Email Already Exists";
        } else {
            $sql = "INSERT INTO customers (name,email,password,phone,address) VALUES (:name,:email,:password,:phone,:address)";
            $result = $pdo->prepare($sql);
            $result->bindParam(':name', $name, PDO::PARAM_STR);
            $result->bindParam(':email', $email, PDO::PARAM_STR);
            $result->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
            $result->bindParam(':phone', $phone, PDO::PARAM_STR);
            $result->bindParam(':address', $address, PDO::PARAM_STR);
            $result->execute();
            if ($result) {
                $success[] = "Created Successfully";
            } else {
                $errors[] = "Failed to create the record.";
            }
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
                        <h1 class="text-center fw-bold mb-4">Create Customer</h1>

                        <form action="create_customer.php" class="row" method="post">
                            <!-- Name Field -->
                            <div class="col-12">
                                <label for="name" class="form-label">Customer Name</label>
                                <input type="text" class="form-control" name="name" value="" required>
                            </div>

                            <!-- Description Field -->
                            <div class="col-12">
                                <label for="description" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" value="" required>
                            </div>
                            <div class="col-12">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" value="" required>
                            </div>

                            <div class="col-12">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="tel" class="form-control" name="phone" id="phone" required>
                            </div>


                            <div class="col-12">
                                <label for="address" class="form-label">Address</label>
                                <textarea name="address" class="form-control"></textarea>
                            </div>
                            <!-- Submit Button -->
                            <div class="col-12 text-center mt-3">
                                <input type="submit" name="create_customer" value="Create Customer" class="btn btn-success">
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