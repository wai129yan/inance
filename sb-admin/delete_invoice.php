<?php

include '../database/db.php';


if (isset($_GET['InvoiceID'])) {
    $InvoiceID = $_GET['InvoiceID'];

    $sql = "DELETE FROM invoices WHERE InvoiceID = :InvoiceID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':InvoiceID', $InvoiceID, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: invoice.php");
        exit();
    } else {
        echo "Error: Could not delete career!";
    }
} else {
    echo "Error: No career ID provided!";
}
