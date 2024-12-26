<?php
include '../database/db.php';
$errors = [];
$success = [];

if(isset($_GET['CustomerID'])){
    $CustomerID = $_GET['CustomerID'];

    $sql = "DELETE FROM customers WHERE CustomerID = :CustomerID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':CustomerID', $CustomerID, PDO::PARAM_INT);
    if($stmt->execute()){
        $success = "Customer deleted successfully!";
        header("Location: customer.php");
    }else{
        $error = "Error deleting service!";
    }
}

include '../errors.php';
include '../success.php';

// may yan 
?>