<?php

include '../database/db.php';


if (isset($_GET['plan_id'])) {
    $planID = $_GET['plan_id'];

    $sql = "DELETE FROM membership_plans WHERE plan_id = :plan_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':plan_id', $planID, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: mem_detail.php");
        exit();
    } else {
        echo "Error: Could not delete career!";
    }
} else {
    echo "Error: No career ID provided!";
}
