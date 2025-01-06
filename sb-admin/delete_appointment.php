<?php
include '../database/db.php';
$errors = [];
$success = [];
include '../errors.php';
include '../success.php';

if (isset($_GET['AppointmentID'])) {
    $AppointmentID = $_GET['AppointmentID'];

    $sql = "DELETE FROM appointments WHERE AppointmentID = :AppointmentID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':AppointmentID', $AppointmentID, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        $success = "Appointment deleted successfully!";

        header("Location: appointment.php");
    } else {
        $error = "Error deleting service!";
    }
}
