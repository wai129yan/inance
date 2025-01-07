<?php
include '../database/db.php';
include './layout/header.php';
?>

<?php
$errors = [];
$success = [];
?>

<?php
// Fetch invoice item if InvoiceItemID is passed via GET
if (isset($_GET['InvoiceItemID'])) {
    $InvoiceItemID = $_GET['InvoiceItemID'];
    $sql = "SELECT * FROM invoiceItems WHERE InvoiceItemID = :InvoiceItemID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':InvoiceItemID', $InvoiceItemID, PDO::PARAM_INT);
    $stmt->execute();
    $invoiceIt = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if invoice item was found
    if (!$invoiceIt) {
        $errors[] = "InvoiceItem not found!";
    }
} else {
    $errors[] = "Invalid InvoiceItem ID!";
}

// Handle form submission when the form is posted
if (isset($_POST['update_invoiceIt'])) {
    $InvoiceItemID = $_POST['id']; // Use hidden ID for updating
    $InvoiceID = $_POST['InvoiceID'];
    $description  = $_POST['description'];
    $quantity  = $_POST['quantity'];
    $unitPrice = $_POST['unitPrice'];
    $totalPrice = $_POST['totalPrice'];

    // Validation
    if (empty($InvoiceID)) {
        $errors[] = "Invoice ID is required";
    }
    if (empty($description)) {
        $errors[] = "Description is required";
    }
    if (empty($quantity)) {
        $errors[] = "Quantity is required";
    }
    if (empty($unitPrice)) {
        $errors[] = "Unit Price is required";
    }
    if (empty($totalPrice)) {
        $errors[] = "Total Price is required";
    }

    // If no errors, proceed with updating the invoice item
    if (count($errors) == 0) {
        // Check if the InvoiceID exists in the invoices table
        $checkInvoiceSql = "SELECT COUNT(*) FROM invoices WHERE InvoiceID = :InvoiceID";
        $stmt = $pdo->prepare($checkInvoiceSql);
        $stmt->bindParam(':InvoiceID', $InvoiceID, PDO::PARAM_INT);
        $stmt->execute();
        $invoiceItExists = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($invoiceItExists['COUNT(*)'] == 0) {
            $errors[] = "Invoice ID does not exist";
        } else {
            // If no errors, update the invoice item
            $sql = "UPDATE invoiceItems SET InvoiceID = :InvoiceID, Description = :description, Quantity = :quantity, UnitPrice = :unitPrice, TotalPrice = :totalPrice WHERE InvoiceItemID = :InvoiceItemID";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':InvoiceID', $InvoiceID, PDO::PARAM_INT);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->bindParam(':unitPrice', $unitPrice, PDO::PARAM_STR);
            $stmt->bindParam(':totalPrice', $totalPrice, PDO::PARAM_STR);
            $stmt->bindParam(':InvoiceItemID', $InvoiceItemID, PDO::PARAM_INT);
            
            // Execute update
            if ($stmt->execute()) {
                $success[] = "Invoice Item updated successfully!";
            } else {
                $errors[] = "Failed to update Invoice Item!";
            }
        }
    }
}
?>

<!-- Page Wrapper -->
<div id="wrapper">
    <!-- Sidebar -->
    <?php include './layout/sidebar.php'; ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Topbar -->
            <?php include './layout/topbar.php'; ?>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container mt-5">
                <!-- Page Heading -->
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <!-- Show errors and success messages -->
                        <?php
                        include '../errors.php';
                        include '../success.php';
                        ?>

                        <h1 class="text-center fw-bold mb-4">Edit Invoice Item</h1>

                        <form action="" class="row" method="post">
                            <!-- Hidden input for the InvoiceItemID -->
                            <input type="hidden" name="id" value="<?= $invoiceIt['InvoiceItemID']; ?>">

                            <div class="col-12">
                                <label for="InvoiceID" class="form-label">Invoice ID</label>
                                <input type="number" class="form-control" name="InvoiceID" value="<?= $invoiceIt['InvoiceID']; ?>" required>
                            </div>

                            <div class="col-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="3" required><?= $invoiceIt['Description']; ?></textarea>
                            </div>

                            <div class="col-12">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" name="quantity" value="<?= $invoiceIt['Quantity']; ?>" required>
                            </div>

                            <div class="col-12">
                                <label for="unitPrice" class="form-label">Unit Price</label>
                                <input type="number" class="form-control" name="unitPrice" value="<?= $invoiceIt['UnitPrice']; ?>" required>
                            </div>

                            <div class="col-12">
                                <label for="totalPrice" class="form-label">Total Price</label>
                                <input type="number" class="form-control" name="totalPrice" value="<?= $invoiceIt['TotalPrice']; ?>" required>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-12 text-center mt-3">
                                <input type="submit" name="update_invoiceIt" value="Update Invoice Item" class="btn btn-success">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <?php include './layout/footer.php'; ?>
        </div>
    </div>
</div>
