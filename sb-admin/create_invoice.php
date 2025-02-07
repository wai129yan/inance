<?php
include '../database/db.php';
include './layout/header.php';
?>

<?php
$errors = [];
$success = [];
?>

<?php
if (isset($_POST['create_invoice'])) {
    $appointmentID = $_POST['appointment_id'];
    $totalAmount = $_POST['totalAmount'];
    $tax = $_POST['tax'];
    $dateIssued = $_POST['dateIssued'];
    $dueDate = $_POST['dueDate'];

    if (empty($appointmentID)) {
        $errors[] = "Appointment ID Required";
    }
    if (empty($totalAmount)) {
        $errors[] = "Total Amount Required";
    }
    if (empty($tax)) {
        $errors[] = "Tax Required";
    }
    if (empty($dateIssued)) {
        $errors[] = "Date Issued Required";
    }
    if (empty($dueDate)) {
        $errors[] = "Due Date Required";
    }

    if (count($errors) == 0) {
        $sqlAppointment = "SELECT COUNT(*) FROM appointments WHERE AppointmentID = :appointmentID";
        $stmt = $pdo->prepare($sqlAppointment);
        $stmt->bindParam(':appointmentID', $appointmentID, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        if (!$count) {
            $errors[] = "Appointment ID does not exist";
        } else {
            $sql = "INSERT INTO invoices (AppointmentID,TotalAmount,Tax,DateIssued,DueDate) VALUES (:appointmentID,:totalAmount,:tax,:dateIssued,:dueDate)";
            $result = $pdo->prepare($sql);
            $result->bindParam(':appointmentID', $appointmentID, PDO::PARAM_INT);
            $result->bindParam(':totalAmount', $totalAmount, PDO::PARAM_STR);
            $result->bindParam(':tax', $tax, PDO::PARAM_STR);
            $result->bindParam(':dateIssued', $dateIssued, PDO::PARAM_STR);
            $result->bindParam(':dueDate', $dueDate, PDO::PARAM_STR);
            $result->execute();
            if ($result) {
                $success[] = "Created Successfully";
            } else {
                $errors[] = "Failed to create the record.";
            }
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
                        <h1 class="text-center fw-bold mb-4">Create invoice</h1>

                        <form action="create_invoice.php" class="row" method="post">
                            <!-- Appointment ID Field -->
                            <div class="col-12">
                                <label for="appointmentID" class="form-label">Appointment Name</label>
                                <select class="form-control" name="appointment_id">
                                    <option>Select Appointment</option>
                                    <?php
                                    $sql = "SELECT * FROM appointments";
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute();
                                    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC); // Corrected to fetchAll

                                    foreach ($appointments as $appointment): // Corrected variable name
                                    ?>
                                        <option value="<?= $appointment['AppointmentID'] ?>"><?= $appointment['AppointmentID'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Total Amount Field -->
                            <div class="col-12">
                                <label for="totalAmount" class="form-label">Total Amount</label>
                                <input type="number" class="form-control" name="totalAmount" step="0.01" required>
                            </div>

                            <!-- Tax Field -->
                            <div class="col-12">
                                <label for="tax" class="form-label">Tax</label>
                                <input type="number" class="form-control" name="tax" step="0.001" required>
                            </div>

                            <!-- Date Issued Field -->
                            <div class="col-12">
                                <label for="dateIssued" class="form-label">Date Issued</label>
                                <input type="date" class="form-control" name="dateIssued" required>
                            </div>

                            <!-- Due Date Field -->
                            <div class="col-12">
                                <label for="dueDate" class="form-label">Due Date</label>
                                <input type="date" class="form-control" name="dueDate" required>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-12 text-center mt-3">
                                <input type="submit" name="create_invoice" value="Create Invoice" class="btn btn-success">
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