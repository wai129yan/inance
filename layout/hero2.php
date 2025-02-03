<?php
// session_start();
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
        <?php 
        include("navtop.php") ;
        ?>
    </header>
    <!-- end header section -->
    <!-- slider section -->
    
    <!-- end slider section -->
</div>