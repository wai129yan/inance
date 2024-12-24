<?php

include '../database/db.php';


if (isset($_GET['career_id'])) {
    $career_id = $_GET['career_id'];

    $sql = "DELETE FROM careeries WHERE career_id = :career_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':career_id', $career_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: career.php");
        exit();
    } else {
        echo "Error: Could not delete career!";
    }
} else {
    echo "Error: No career ID provided!";
}
