<?php

require "database/db.php";
require "database/config.php";

$errors = [];
$success = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["submit"])) {

        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        
        empty($email) ? $errors[]  = "Email Required" : "";
        empty($password) ? $errors[]  = "Password Required" : "";
        

        !filter_var($email, FILTER_VALIDATE_EMAIL) ? $errors[] = "Invalid Email Format" : "";
        if (count($errors) == 0) {
            if ($email === "admin@admin.com" && $password === "admin") {
                header("Location:admin-dashboard.php");
            }
        } else {
            $error[] = "Error message ";
        }
    }
}

include "errors.php";
include "success.php";
include "layout/header.php";

?>

<div class="m-5">
    <form action="admin_login.php" method="post" class="p-5 shadow-lg w-50 m-auto mb-5 rounded">
        <h2 class="text-center">Login</h2>

        <div>
            <input type="email" name="email" placeholder="Email" required class="form-control mb-3" />
        </div>
        <div>
            <input type="password" name="password"  placeholder="password" required class="form-control mb-3" />
        </div>
        <div class="d-flex">
            <button type="submit" class="btn btn-primary" name="submit">Login</button>
        </div>
    </form>
</div>