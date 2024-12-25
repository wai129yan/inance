<?php
include '../database/db.php';
$errors = [];
$success = [];
include '../errors.php';
include '../success.php';

if(isset($_GET['serviceID'])){
    $serviceID = $_GET['serviceID'];

    $sql = "DELETE FROM services WHERE serviceID = :serviceID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':serviceID', $serviceID, PDO::PARAM_INT);
    if($stmt->execute()){
        $success = "Service deleted successfully!";
        header("Location: service.php");
    }else{
        $error = "Error deleting service!";
    }
}