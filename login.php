<?php
session_start();
include("./database/db.php");

$errors = [];
 
$t = isset($_GET['t']);
if ($t) {
    $tech = $_GET['t'];
}

if(isset($_POST['Login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    if($t) {
        $sql = "SELECT * FROM Technicians WHERE email = :email";
    }else{
        $sql = "SELECT * FROM Customers WHERE email = :email";
    }
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email',$email,PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    // print_r($user);
    // die();
    if(!$user){
        $errors[] = "Email Not Found";
    }else if (!password_verify($password,$user['password'])){
        $errors[]  = "Invalid email of password";
    }

    if(count($errors) == 0){
        if($email === $user['email'] && password_verify($password, $user['password'])){
            $_SESSION['user_id'] = $user['id']?? "";
            $_SESSION['name'] = $user['name'];
            $_SESSION['customer_id'] = $user['CustomerID'] ?? "";
            $_SESSION['career'] = $user['career_id'] ?? "";
            $_SESSION['t_id'] = $user['TechnicianID']?? "";
            header("Location:index.php");
            exit();
        }
    } else {
        $errors[] = "Error message";
    }

    if($user){
        if(password_verify($password,$user['password'])){
            $_SESSION['user'] = $user;
            header("Location:index.php");
        }
    }
}

 

include("./layout/header.php");
?>

<section class="contact_section layout_padding mt-5" id="contact">
    <div class="container">
        <?php include("errors.php"); ?>
        <div class="">
            <div class="w-50 m-auto px-5 py-2 mt-5 shadow rounded-lg">

                <form action="" method="post" class="mt-3">
                    <h3 class="text-center">Login Here</h3>
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email" required />
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required />
                    </div>

                    <div class="d-flex justify-content-center">
                        <input type="submit" name="Login" value="Login" class="btn btn-primary">
                    </div>

                    <div class="d-flex justify-content-center align-items-center">
                        <hr class="bg-danger  w-100">
                        <span class="mx-2">OR</span>
                        <hr class="bg-danger  w-100">
                    </div>
                    <div class="text-center pb-3 mt-3">
                        
                            <a href="register.php?t=<?= true ?>" class="btn btn-success">Techinician Register</a>
                        
                            <a href="register.php" class="btn btn-success">Register</a>
                        
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>