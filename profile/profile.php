<!-- header -->
<?php
session_start();
$auth = isset($_SESSION['name']);
$t_id = isset($_SESSION['t_id']);
$career_id = isset($_SESSION['career']);

$errors = [];
$success = [];
include("../database/db.php");

if (isset($_GET['id'])) {
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
$stmt->bindParam(':id', $id, PDO::PARAM_STR);
$stmt->execute();
$career = $stmt->fetch(PDO::FETCH_ASSOC);
// print_r($career);
// die();

if (isset($_POST['profile_update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $photo = $_FILES['photos']['name'];
    $tmpName = $_FILES['photos']['tmp_name'];
    move_uploaded_file($tmpName, "../images/technician/$photo");
    $specialization = $_POST['Specialization'];
    $aboutme = $_POST['aboutme'];
    $address = $_POST['Address'];

    empty($name) ? $errors[] = "Name Required" : "";
    empty($specialization) ? $errors[] = "Specialization Required" : "";
    empty($aboutme) ? $errors[] = "About me required" : "";
    empty($address) ? $errors[] = "Address me required" : "";

    if (count($errors) == 0) {
        $updateTech = "UPDATE technicians SET name = :name, photos = :photos, Specialization = :specialization, aboutme = :aboutme, Address = :address WHERE TechnicianID = :id";
        $stmt = $pdo->prepare($updateTech);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':photos', $photo, PDO::PARAM_STR);
        $stmt->bindParam(':specialization', $specialization, PDO::PARAM_STR);
        $stmt->bindParam(':aboutme', $aboutme, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);
        $result = $stmt->execute();
        if ($result) {
            $success[] = "Profile Updated Successfully";
            header("Location: profile.php?id=" . $id);
            exit();
        }
    }
}

// echo $id;

// echo $career_id;


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" defer></script>
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




        body {
            background-color: #e0ffff;
            font-family: sans-serif;
        }

        .profile-section {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .profile-card {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .profile-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-bottom: 20px;
        }

        .profile-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .profile-title {
            color: #888;
            margin-bottom: 20px;
        }

        .social-icons {
            margin-bottom: 20px;
        }

        .social-icon {
            margin: 0 10px;
            font-size: 20px;
            color: #333;
        }

        .button {
            background-color: #00bfff;
            color: #fff;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #009acd;
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
                                    <?php
                                    // echo "db",$techician['TechnicianID'];
                                    // echo "Session",$_SESSION['t_id'];
                                    if ($techician['TechnicianID'] == $_SESSION['t_id']) : ?>

                                        <li class="nav-item">
                                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#profile">Edit</button>
                                        </li>
                                    <?php endif ?>
                                <?php else: ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="../login.php?t=tech">Login</a>
                                    </li>
                                <?php endif; ?>


                            </ul>

                        </div>
                    </nav>
                </div>
            </div>

            <div class="container">
                <div class="profile-section">
                    <div class="profile-card">
                        <img src="https://via.placeholder.com/150" alt="Profile Image" class="profile-img">
                        <h2 class="profile-name">John Doe</h2>
                        <p class="profile-title">Web Developer</p>
                        <div class="social-icons">
                            <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                        <button class="button">Contact Me</button>
                    </div>
                </div>
            </div>
            <!-- Button trigger modal -->
            <!-- Modal -->

            <div class="modal fade " id="profile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog  w-50 ">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Profile Edit</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?= $techician['TechnicianID']; ?>">
                                <div class="mb-3">
                                    <input type="text" name="name" value="<?= $techician['name'] ?? ""; ?>" class="form-control" placeholder="Name">
                                </div>
                                <div class="mb-3">
                                    <input type="email" name="email" value="<?= $techician['email'] ?? ""; ?>" class=" form-control" placeholder="Email" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="">Upload Photo</label>
                                    <img src="../images/technician/<?= $techician['photos'] ?? 'client-1.jpg'; ?>" alt="" width="150px">
                                    <input type="file" class="form-control" name="photos">
                                </div>
                                <div class="mb-3">
                                    <input type="text" name="Phone" value="<?= $techician['Phone'] ?? ""; ?>" class="form-control" placeholder="Phone">
                                </div>
                                <div class="mb-3">
                                    <input type="text" name="Specialization" value="<?= $techician['Specialization'] ?? ""; ?>" class="form-control" placeholder="Specialization">
                                </div>
                                <div class="mb-3">
                                    <textarea name="aboutme" class="form-control" placeholder="AboutMe"><?= $techician['aboutme'] ?? ""; ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <textarea name="Address" class="form-control" placeholder="Address"><?= $techician['Address'] ?? ""; ?></textarea>
                                </div>
                                <input type="submit" class="btn btn-info" name="profile_update">


                            </form>




                        </div>

                    </div>
                </div>
            </div>
        </header>




        <!-- end header section -->
        <!-- slider section -->

        <!-- end slider section -->
    </div>

    <div class="container-fluid p-3">
        <?php
        include_once "../errors.php";
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