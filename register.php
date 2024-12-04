<?php
include("./database/db.php");
include ("helper/helperfunction.php");

$t = isset($_GET['t']);
?>
<?php
$errors = [];
$success = [];
$now = new DateTime('now');
$now = $now->format('Y-m-d H:i:s');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['tech_register'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password = password_hash($password, PASSWORD_DEFAULT);
        $phone = $_POST['Phone'];
        $career_id = $_POST['career_id'];
        $address = $_POST['Address'];
        $specialization = $_POST['Specialization'];
        $techCode = generateTechnicianID($name);
        // echo $techCode;
        // die();
        // $registerdate = $_POST['registerdate'];

        empty($name) ? $errors[] = "Name Required" : "";
        empty($email) ? $errors[] = "Email Required" : "";
        empty($phone) ? $errors[] = "Phone Required" : "";
        empty($career_id) ? $errors[] = "Career Required" : "";
        // empty($registerdate) ? $errors[] = "Register Date Required" : "";

        !filter_var($email, FILTER_VALIDATE_EMAIL) ? $errors[] = "Invalid Email Format" : "";
        if (count($errors) == 0) {
            $exitUser = "SELECT * FROM technicians WHERE email = :email";
            $stmt = $pdo->prepare($exitUser);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $exitUser = $stmt->fetch(PDO::FETCH_ASSOC);

            if($exitUser){
                $errors[] = "Email Already Exists";
            }else{
            $sql = "INSERT INTO technicians (name, email, password, Phone, career_id, Address, Specialization, techCode, RegistrationDate) VALUES (:name, :email, :password, :phone, :career_id, :address, :specialization, :techCode, :registerdate)";

            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR); 
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
            $stmt->bindParam(':career_id', $career_id, PDO::PARAM_STR);
            $stmt->bindParam(':address', $address, PDO::PARAM_STR);
            $stmt->bindParam(':specialization', $specialization, PDO::PARAM_STR);
            $stmt->bindParam(':techCode', $techCode, PDO::PARAM_STR);
            $stmt->bindParam(':registerdate', $now, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $success[] = "Success";
                header("Location:login.php?t=tech");
            } else {
                $errors[] = "Error message";
            }
        }
    }
}
}

// customer register data input
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['customer_register'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password = password_hash($password, PASSWORD_DEFAULT);
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        empty($name) ? $errors[] = "Name Required" : "";
        empty($email) ? $errors[] = "Email Required" : "";
        empty($phone) ? $errors[] = "Phone Required" : "";
        empty($address) ? $errors[] = "Address Required" : "";

        !filter_var($email, FILTER_VALIDATE_EMAIL) ? $errors[] = "Invalid Email Format" : "";
        if (count($errors) == 0) {
            $custUser = "SELECT * FROM customers WHERE email = :email";
            $stmt = $pdo->prepare($custUser);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $custUser = $stmt->fetch(PDO::FETCH_ASSOC);

            if($custUser){
                $errors[] = "Email Already Exists";
            } else {
                $sql = "INSERT INTO customers (name,email,password,phone,address,created_date) VALUES (:name,:email,:password,:phone,:address,:registerdate)";
                $stmt = $pdo->prepare($sql);

                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':password', $password, PDO::PARAM_STR);
                $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
                $stmt->bindParam(':address', $address, PDO::PARAM_STR);
                $stmt->bindParam(':registerdate', $now, PDO::PARAM_STR);

                if($stmt->execute()){
                    $success[] = "Success";
                    header("Location:login.php");
                } else {
                    $errors[] = "Error message";
                }
            }
        }
    }
}


include("./layout/header.php");

include "success.php";
?>

<section class="contact_section layout_padding" id="contact">
    <div class="container">
<?php include "errors.php"; ?>
        <div class="row">
            <div class="col-md-6 px-4 py-4 shadow rounded-lg bg-light">
                <!-- <h3 class="text-center mb-4">Register</h3> -->
                <?php if ($t): ?>
                    <?php include "errors.php"; ?>
                    <form action="register.php" method="post">
                        <div class="heading_container">
                            <h2>Register Techintion</h2>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="name" class="form-control" placeholder="Name" required />
                        </div>
                        <div class="mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Email" required />
                        </div>
                        <div class="mb-3">
                            <input type="password" name="password" class="form-control" placeholder="password" required />
                        </div>
                        <div class="mb-3">
                            <select name="career_id" id="" class="form-control">
                                <?php
                                $sql = "SELECT * FROM careeries";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute();
                                $careers = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($careers as $career) :
                                ?>
                                    <option value="<?= $career['career_id'] ?>"><?= $career['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <textarea name="Specialization" id="" placeholder="Specialization" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="Phone" class="form-control" placeholder="Phone Number" required />
                        </div>
                        <div class="mb-3">
                            <textarea name="Address" id="" placeholder="Address" class="form-control"></textarea>
                        </div>
                        <!-- <div class="mb-3">
                            <input type="date" name="RegisterDate" class="form-control" required />
                        </div> -->

                        <div class="d-grid">
                            <button type="submit" name="tech_register" class="btn btn-primary">Register</button>
                            <a href="login.php">Back</a>
                        </div>
                    </form>
                <?php else: ?>

                    <!-- Customer Register -->
                    <form action="" method="post">
                        <div class="heading_container">
                            <h2>Register Customer</h2>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="name" class="form-control" placeholder="Name" required />
                        </div>
                        <div class="mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Email" required />
                        </div>
                        <div class="mb-3">
                            <input type="password" name="password" class="form-control" placeholder="password" required />
                        </div>

                        <div class="mb-3">
                            <input type="text" name="phone" class="form-control" placeholder="Phone Number" required />
                        </div>
                        <div class="mb-3">
                            <textarea name="address" id="" placeholder="Address" class="form-control"></textarea>
                        </div>


                        <div class="d-grid">
                            <button type="submit" name="customer_register" class="btn btn-primary">Register</button>
                            <a href="login.php">Back</a>
                        </div>
                    </form>
                <?php endif ?>

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

