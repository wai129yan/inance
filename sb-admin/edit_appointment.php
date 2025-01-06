<?php
include '../database/db.php';
include './layout/header.php';
?>

<?php
$errors = [];
$success = [];
?>

<?php

if (isset($_GET['AppointmentID'])) {
    $AppointmentID = $_GET['AppointmentID'];


    $sql = "SELECT * FROM appointments WHERE AppointmentID = :AppointmentID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':AppointmentID', $AppointmentID, PDO::PARAM_INT);
    $stmt->execute();
    $appointment = $stmt->fetch(PDO::FETCH_ASSOC);
    // print_r($appointment);
    // die();

    if (!$appointment) {
        $errors[] = "Appointment not found!";
    }
} else {
    $errors[] = "Invalid Appointment ID!";
}


if (isset($_POST['update_appointment'])) {
  
    $customer_id = $_POST['customer_id'];
    $service_id = $_POST['service_id'];
    $technician_id = $_POST['technician_id'];
    $appointment_date = $_POST['appointment_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $status = $_POST['status'];
    $notes = $_POST['notes'];

  
    if (empty($customer_id)) {
        $errors[] = "Customer ID is required!";
    }
    if (empty($service_id)) {
        $errors[] = "Service ID is required!";
    }
    if (empty($technician_id)) {
        $errors[] = "Technician ID is required!";
    }
    if (empty($appointment_date)) {
        $errors[] = "Appointment Date is required!";
    }
    if (empty($start_time)) {
        $errors[] = "Start Time is required!";
    }
    if (empty($end_time)) {
        $errors[] = "End Time is required!";
    }
    if (empty($status)) {
        $errors[] = "Status is required!";
    }

    // If no errors, proceed with the update
    if (count($errors) == 0) {
        // Prepare the SQL query to update the appointment
        $sql = "UPDATE appointments SET 
                    CustomerID = :customer_id, 
                    ServiceID = :service_id, 
                    TechnicianID = :technician_id, 
                    AppointmentDate = :appointment_date, 
                    StartTime = :start_time, 
                    EndTime = :end_time, 
                    Status = :status, 
                    Notes = :notes 
                WHERE AppointmentID = :AppointmentID";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
        $stmt->bindParam(':service_id', $service_id, PDO::PARAM_INT);
        $stmt->bindParam(':technician_id', $technician_id, PDO::PARAM_INT);
        $stmt->bindParam(':appointment_date', $appointment_date, PDO::PARAM_STR);
        $stmt->bindParam(':start_time', $start_time, PDO::PARAM_STR);
        $stmt->bindParam(':end_time', $end_time, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':notes', $notes, PDO::PARAM_STR);
        $stmt->bindParam(':AppointmentID', $AppointmentID, PDO::PARAM_INT);

        // Execute the query and check if it was successful
        if ($stmt->execute()) {
            $success[] = "Appointment updated successfully!";
        } else {
            $errors[] = "Failed to update Appointment!";
        }
    }
}
?>

<!-- Page Wrapper -->
<div id="wrapper">
    <!-- Sidebar -->
    <?php
    include './layout/sidebar.php';
    ?>
    <!-- End of Sidebar -->
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Topbar -->
            <?php
            include './layout/topbar.php';
            ?>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container mt-5">
                <!-- Page Heading -->
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <?php
                        include '../errors.php';
                        include '../success.php';
                        ?>
                        <!-- Form starts here -->
                        <h1 class="text-center fw-bold mb-4">Edit Appointment</h1>

                        <form action="" class="row" method="post">
                            <!-- Customer ID Field -->
                            <input type="hidden" name="id" value="<?= $appointment['AppointmentID']; ?>">

                            <div class="col-12 mb-3">
                                <label for="customer_id" class="form-label">Customer ID</label>
                                <input type="number" class="form-control" name="customer_id" value="<?=$appointment['CustomerID'] ?>" required>
                            </div>

                            <!-- Service ID Field -->
                            <div class="col-12 mb-3">
                                <label for="service_id" class="form-label">Service ID</label>
                                <input type="number" class="form-control" name="service_id" value="<?=$appointment['ServiceID'] ?>" required>
                            </div>

                            <!-- Technician ID Field -->
                            <div class="col-12 mb-3">
                                <label for="technician_id" class="form-label">Technician ID</label>
                                <input type="number" class="form-control" name="technician_id" value="<?=$appointment['TechnicianID'] ?>" required>
                            </div>

                            <!-- Appointment Date Field -->
                            <div class="col-12 mb-3">
                                <label for="appointment_date" class="form-label">Appointment Date</label>
                                <input type="date" class="form-control" name="appointment_date" value="<?= $appointment['AppointmentDate'] ?>" required>
                            </div>

                            <!-- Start Time Field -->
                            <div class="col-12 mb-3">
                                <label for="start_time" class="form-label">Start Time</label>
                                <input type="time" class="form-control" name="start_time" value="<?= $appointment['StartTime'] ?>" required>
                            </div>

                            <!-- End Time Field -->
                            <div class="col-12 mb-3">
                                <label for="end_time" class="form-label">End Time</label>
                                <input type="time" class="form-control" name="end_time" value="<?= $appointment['EndTime']?>" required>
                            </div>

                            <!-- Status Field -->
                            <div class="col-12 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-control" name="status" required>
                                    <option value="Pending" <?= isset($appointment['Status']) && $appointment['Status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="Confirmed" <?= isset($appointment['Status']) && $appointment['Status'] == 'Confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                                    <option value="Cancelled" <?= isset($appointment['Status']) && $appointment['Status'] == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                </select>
                            </div>

                            <!-- Notes Field -->
                            <div class="col-12 mb-3">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea class="form-control" name="notes" rows="3"><?= isset($appointment['Notes']) ? $appointment['Notes'] : ''; ?></textarea>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-12 text-center mt-3">
                                <input type="submit" name="update_appointment" value="Update Appointment" class="btn btn-success">
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            <!-- Footer (Make sure this is inside the container) -->
            <?php
            include './layout/footer.php';
            ?>
            <!-- /.container -->
