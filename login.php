<?php
include("./database/db.php");

include("./layout/header.php");

$t = isset($_GET['t']);

if ($t) {
    $tech = $_GET['t'];
}

?>

<section class="contact_section layout_padding mt-5" id="contact">
    <div class="container">

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
                        <input type="submit" value="Login" class="btn btn-primary">
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <hr class="bg-danger  w-100">
                        <span class="mx-2">OR</span>
                        <hr class="bg-danger  w-100">
                    </div>
                    <div class="text-center pb-3 mt-3">
                        <?php if ($t): ?>
                            <a href="register.php?t=<?= $tech ?>" class="btn btn-success">Register</a>
                        <?php else: ?>
                            <a href="register.php" class="btn btn-success">Register</a>
                        <?php endif ?>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>