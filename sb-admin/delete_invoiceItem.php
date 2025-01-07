<?php

include '../database/db.php';


if (isset($_GET['InvoiceItemID'])) {
    $InvoiceItemID = $_GET['InvoiceItemID'];

    $sql = "DELETE FROM invoiceitems WHERE InvoiceItemID = :InvoiceItemID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':InvoiceID', $InvoiceID, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: invoice_item.php");
        exit();
    } else {
        echo "Error: Could not delete career!";
    }
} else {
    echo "Error: No career ID provided!";
}
