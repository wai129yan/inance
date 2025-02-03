<?php
session_start();
include("../database/db.php");

$auth = isset($_SESSION['name']);
$t_id = isset($_SESSION['t_id']);
$technician = isset($_SESSION['technicianID']);
$career_id = isset($_SESSION['career']);

$errors = [];
$success = [];

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM technicians WHERE TechnicianID = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id',$id,PDO::PARAM_STR);
    $stmt->execute();
    $technician = $stmt->fetch(PDO::FETCH_ASSOC);

    // print_r($technician);
    // die();

}



include "../layout/navtop.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <!-- <link rel="stylesheet" type="text/css" href="../css/" /> -->
    <!-- <link rel="stylesheet" href="css/style.css"> -->
    <title>Document</title>
    <style>
       body {
      background-color: #f5f5f5;
      font-family: Arial, sans-serif;
    }

    .profile-card {
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      margin: 30px auto;
      max-width: 800px;
      padding: 30px;
    }

    .profile-card h2 {
      color: #333;
      font-size: 24px;
      margin-bottom: 20px;
    }

    .profile-card p {
      color: #666;
      line-height: 1.6;
      margin-bottom: 15px;
    }

    .skills-container {
      display: flex;
      justify-content: space-between;
      margin-bottom: 30px;
    }

    .skills-item {
      background-color: #f0f0f0;
      border-radius: 5px;
      padding: 10px;
      text-align: center;
    }

    .skills-item h4 {
      color: #333;
      font-size: 16px;
      margin-bottom: 5px;
    }

    .skills-item .star-rating {
      display: flex;
      justify-content: center;
    }

    .star {
      color: #ffcc00;
      margin: 0 2px;
    }

    .button {
      background-color: #007bff;
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .button:hover {
      background-color: #0056b3;
    }


    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .team-section {
      padding: 50px 0;
    }

    .team-card {
      background-color: #ffffff;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      margin: 20px;
      text-align: center;
      transition: transform 0.3s;
    }

    .team-card:hover {
      transform: translateY(-5px);
    }

    .team-img {
      width: 100%;
      border-radius: 10px 10px 0 0;
    }

    .team-name {
      font-size: 20px;
      font-weight: bold;
      margin: 15px 0 5px;
    }

    .team-role {
      color: #6c757d;
      margin-bottom: 15px;
    }

    .button {
      background-color: #28a745;
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .button:hover {
      background-color: #218838;
    }
    </style>
</head>

<body>

    <?php
    include "../profile/layout/header.php";
    include "../profile/layout/card1.php";
    include "../profile/layout/badges.php";
    ?>
</body>

</html>