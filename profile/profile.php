<!-- header -->
<?php

session_start();
$career = isset($_SESSION['career']);
?>



<?php if ($career) : ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" />
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

        <div class="container-fluid p-3">
            <?php

            include_once "./layout/card1.php";
            include_once "./layout/badges.php";

            ?>
            <!-- card start -->


            <!-- card finish-->

            <!-- badges start -->
        </div>
    <?php else : ?>
    <?php header("Location:../index.php");?>
    <?php endif ?>
    <?php
    include_once "./layout/footer.php";
    ?>

    <!-- footer -->