<?php
session_start();
$auth = isset($_SESSION['name']);
// print_r($auth);
// die();
$career = isset($_SESSION['career']);
$customer = isset($_SESSION['customer_id']);

include("./database/db.php");
?>

<div class="hero_area">
    <!-- header section strats -->
    <header class="header_section">
        <div class="header_top">
            <div class="container-fluid">
                <div class="contact_nav">
                    <a href="">
                        <i class="fa fa-phone" aria-hidden="true"></i>
                        <span>
                            Call : +81 09044540786
                        </span>
                    </a>　
                    <a href="">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                        <span>
                            Email : waiyan.toshima12@gmail.com
                        </span>
                    </a>
                </div>
            </div>
        </div>
        <div class="header_bottom">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-lg custom_nav-container ">
                    <a class="navbar-brand" href="index.php">
                        <span>
                            Inance
                        </span>
                    </a>

                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class=""> </span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ">
                            <li class="nav-item active">
                                <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#about"> About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#service">Services</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#technicians">Technicians</a>
                            </li>

                            <!-- <php if ($customer): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="create_post.php">Create Post</a>
                                </li>
                            <php endif; ?> -->

                            <?php if ($customer): ?>
                                <!-- Show the 'Create Post' link if customer is logged in -->
                                <li class="nav-item">
                                    <a class="nav-link" href="create_post.php">Create Post</a>
                                </li>
                            <?php endif; ?>


                            <li class="nav-item">
                                <a class="nav-link" href="#contact">Contact Us</a>
                            </li>

                            <?php if ($career): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="profile/profile.php?id=<?= $_SESSION['t_id']; ?>">Profile</a>
                                </li>
                            <?php endif; ?>

                            <?php if ($auth): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="customer_profile.php"><?php echo $_SESSION['name'] ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="logout.php">Logout</a>
                                </li>

                            <?php else: ?>
                                <li class="nav-item">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Log In Here
                                        </button>

                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="login.php?t=tech">Technicians LogIn</a>
                                            <a class="dropdown-item" href="login.php">Customer Login</a>
                                        </div>
                                    </div>
                                </li>

                            <?php endif ?>


                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </header>
    <!-- end header section -->
    <!-- slider section -->
    <section class="slider_section ">
        <div class="container ">
            <div class="row">
                <div class="col-md-6 ">
                    <div class="detail-box">
                        <h1>
                            Repair and <br>
                            Maintenance <br>
                            Services
                        </h1>
                        <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Qui harum voluptatem adipisci.
                            Quos molestiae saepe dicta nobis pariatur, tempora iusto, ad possimus soluta hic
                            praesentium mollitia consequatur beatae, aspernatur culpa.
                        </p>
                        <a href="#">
                            Contact Us
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="img-box">
                        <img src="images/slider-img.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end slider section -->
</div>