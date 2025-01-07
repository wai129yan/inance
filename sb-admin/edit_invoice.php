<?php
include '../database/db.php';
include './layout/header.php';
?>

<?php
$errors = [];
$success = [];
?>

<?php
if (isset($_GET['InvoiceID'])) {
    $InvoiceID  = $_GET['InvoiceID'];
    $sql = "SELECT * FROM invoices WHERE InvoiceID = :InvoiceID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':InvoiceID', $InvoiceID, PDO::PARAM_INT);
    $stmt->execute();
    $invoice = $stmt->fetch(PDO::FETCH_ASSOC);
}
if (isset($_POST['update_invoice'])) {
    $appointmentID = $_POST['appointmentID'];
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
        $checkAppointmentSql = "SELECT COUNT(*) FROM appointments WHERE AppointmentID = :appointmentID";
        $stmt = $pdo->prepare($checkAppointmentSql);
        $stmt->bindParam(':appointmentID', $appointmentID, PDO::PARAM_INT);
        $stmt->execute();
        $appointmentExists = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($appointmentExists['COUNT(*)'] == 0) {
            $errors[] = "Appointment ID does not exist";
        }
        if (isset($_POST['update_invoice'])) {
            $sql = "UPDATE invoices SET AppointmentID = :appointmentID, TotalAmount = :totalAmount, Tax = :tax, DateIssued = :dateIssued, DueDate = :dueDate WHERE InvoiceID = :InvoiceID";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':appointmentID', $appointmentID, PDO::PARAM_INT);
            $stmt->bindParam(':totalAmount', $totalAmount, PDO::PARAM_STR);
            $stmt->bindParam(':tax', $tax, PDO::PARAM_STR);
            $stmt->bindParam(':dateIssued', $dateIssued, PDO::PARAM_STR);
            $stmt->bindParam(':dueDate', $dueDate, PDO::PARAM_STR);
            $stmt->bindParam(':InvoiceID', $InvoiceID, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt) {
                $success[] = "Updated Successfully";
            } else {
                $errors[] = "Failed to update the record.";
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
                        <h1 class="text-center fw-bold mb-4">Edit invoice</h1>

                        <form action="" class="row" method="post">
                            <!-- Appointment ID Field -->
                            <input type="hidden" name="id" value="<?= $invoice['InvoiceID']; ?>">

                            <div class="col-12">
                                <label for="appointmentID" class="form-label">Appointment ID</label>
                                <input type="number" class="form-control" value="<?= $invoice['AppointmentID']; ?>" name="appointmentID" required>
                            </div>

                            <!-- Total Amount Field -->
                            <div class="col-12">
                                <label for="totalAmount" class="form-label">Total Amount</label>
                                <input type="number" class="form-control" value="<?= $invoice['TotalAmount']; ?>" name="totalAmount" step="0.01" required>
                            </div>

                            <!-- Tax Field -->
                            <div class="col-12">
                                <label for="tax" class="form-label">Tax</label>
                                <input type="number" class="form-control" value="<?= $invoice['Tax']; ?>" name="tax" step="0.001" required>
                            </div>

                            <!-- Date Issued Field -->
                            <div class="col-12">
                                <label for="dateIssued" class="form-label">Date Issued</label>
                                <input type="date" class="form-control" value="<?= $invoice['DateIssued']; ?>" name="dateIssued" required>
                            </div>

                            <!-- Due Date Field -->
                            <div class="col-12">
                                <label for="dueDate" class="form-label">Due Date</label>
                                <input type="date" class="form-control" value="<?= $invoice['DueDate']; ?>" name="dueDate" required>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-12 text-center mt-3">
                                <input type="submit" name="update_invoice" value="Update Invoice" class="btn btn-success">
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