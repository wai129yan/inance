<?php
include '../database/db.php';
$errors = [];
$success = [];
include '../errors.php';
include '../success.php';

if(isset($_GET['ReviewID'])){
    $ReviewID = $_GET['ReviewID'];

    $sql = "DELETE FROM reviews WHERE ReviewID = :ReviewID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':ReviewID', $ReviewID, PDO::PARAM_INT);
    if($stmt->execute()){
        $success = "Review deleted successfully!";
        header("Location: review.php");
    }else{
        $error = "Error deleting service!";
    }
}