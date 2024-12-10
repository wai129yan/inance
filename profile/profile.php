<!-- header -->
<?php
// session_start();
$auth = isset($_SESSION['name']);
$career = isset($_SESSION['career']);


include("../database/db.php");

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $query = "SELECT * FROM technicians WHERE TechnicianID = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->execute();
    $techician = $stmt->fetch(PDO::FETCH_ASSOC);
}
$id = $techician['career_id'];
$query = "SELECT *  FROM careeries WHERE career_id = :id";
$stmt = $pdo->prepare($query);
$stmt -> bindParam(':id',$id,PDO::PARAM_STR);
$stmt->execute();
$career = $stmt->fetch(PDO::FETCH_ASSOC);
// print_r($career);
// die();




?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" />
    <!-- <link rel="stylesheet" type="text/css" href="../css/" /> -->
    <!-- <link rel="stylesheet" href="css/style.css"> -->
    <title>Document</title>
    <style>
        .profile-image {
            width: 150px;
            height: 150px;
        }

        .badge-item {
            text-align: center;
            margin-right: 1rem;
            margin-bottom: 1rem;
        }

        .badge-item img {
            max-width: 50px;
        }

        .icon-hover {
            transition: color 0.3s, transform 0.3s;
        }

        .icon-hover:hover {
            color: gold;
            transform: scale(1.2);
        }

        .custom {
            background-color: rgb(180, 221, 233);
        }

        .custom-shadow {
            box-shadow: 0px 4px 6px rgba(46, 164, 233, 0.822);
            border-radius: 8px;
            background: hwb(214 95% 2% / 0.432);
        }

        .c-shadow {
            box-shadow: 0px 4px 6px rgba(46, 164, 233, 0.822);
        }

        .card-body {
            flex-grow: 1;
            /* Ensure the body stretches if needed */
            overflow-y: auto;
            /* Add scrolling if content overflows */
        }

        .title {
            font-size: 1.3rem;
            font-weight: bold;
            color: #61b7da;
        }
    </style>
</head>

<body>
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
                                    <a class="nav-link" href="../index.php">Home <span class="sr-only">(current)</span></a>
                                </li>
                               
                                <li class="nav-item">
                                    <a class="nav-link" href="../#contact">Contact Us</a>
                                </li>

                                <?php if ($auth): ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="../logout.php">Logout</a>
                                    </li>
                                <?php else: ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="../login.php?t=tech">Login</a>
                                    </li>
                                <?php endif; ?>

                                <?php if ($career): ?>

                                    <li class="nav-item">
                                        <a class="nav-link" href="profile/profile.php">Profile</a>
                                    </li>
                                <?php endif; ?>

                            </ul>
                            <button class="btn-btn-success">Edit</button>
                        </div>
                    </nav>
                </div>
            </div>
        </header>
        <!-- end header section -->
        <!-- slider section -->
       
        <!-- end slider section -->
    </div>

    <div class="container-fluid p-3">
        <?php

        include_once "./layout/card1.php";
        include_once "./layout/badges.php";

        ?>
        <!-- card start -->


        <!-- card finish-->

        <!-- badges start -->
    </div>
    <!-- <php else : ?> -->

    <!-- <php endif ?> -->
    <?php
    include_once "./layout/footer.php";
    ?>

    <!-- footer -->