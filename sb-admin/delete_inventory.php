<?php
include '../database/db.php';
$errors = [];
$success = [];
include '../errors.php';
include '../success.php';

if(isset($_GET['ItemID'])){
    $ItemID = $_GET['ItemID'];

    $sql = "DELETE FROM inventory WHERE ItemID = :ItemID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':ItemID', $ItemID, PDO::PARAM_INT);
    if($stmt->execute()){
        $success = "Inventory deleted successfully!";
        header("Location: inventory.php");
    }else{
        $error = "Error deleting service!";
    }
}