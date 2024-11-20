<?php
include("./database/db.php");
include("./layout/header.php");
?>
<?php
$errors = [];
$success = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['register'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $specialization = $_POST['special'];
        $registerdate = $_POST['registerdate'];

        empty($name) ? $errors[] = "Name Required" : "";
        empty($email) ? $errors[] = "Email Required" : "";
        empty($phone) ? $errors[] = "Phone Required" : "";
        empty($specialization) ? $errors[] = "Specialization Required" : "";
        empty($registerdate) ? $errors[] = "Register Date Required" : "";

        !filter_var($email, FILTER_VALIDATE_EMAIL) ? $errors[] = "Invalid Email Format" : "";
        if (count($errors) == 0) {

            $sql = "INSERT INTO technicians (name, email, phone, specialization, registerdate) VALUES (:name, :email, :phone, :specialization, :registerdate)";

            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
            $stmt->bindParam(':specialization', $specialization, PDO::PARAM_STR);
            $stmt->bindParam(':registerdate', $registerdate, PDO::PARAM_STR);
            // $stmt->execute();
            if ($stmt->execute()) {
                $success[] = "Success";
            } else {
                $error[] = "Error message ";
            }
        }
    }
}

include "errors.php";
include "success.php";
?>

<section class="contact_section layout_padding" id="contact">
    <div class="container">
        <div class="heading_container">
            <h2>Register Form</h2>
        </div>
        <div class="row">
            <div class="col-md-6 px-4 py-4 shadow rounded-lg bg-light">
                <!-- <h3 class="text-center mb-4">Register</h3> -->
                <form action="register.php" method="post">
                    <div class="mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Name" required />
                    </div>
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email" required />
                    </div>
                    <div class="mb-3">
                        <input type="text" name="phone" class="form-control" placeholder="Phone Number" required />
                    </div>
                    <div class="mb-3">
                        <input type="text" name="special" class="form-control" placeholder="Specialization" required />
                    </div>
                    <div class="mb-3">
                        <input type="date" name="registerdate" class="form-control" required />
                    </div>
                    <div class="d-grid">
                        <button type="submit" name="register" class="btn btn-primary">Register</button>
                        <a href="login.php">Back</a>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <div class="map_container">
                    <div class="map">
                        <div id="googleMap" style="width:100%;height:100%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<br><br><br><br><br>

<?php include("./layout/footer.php") ?>;