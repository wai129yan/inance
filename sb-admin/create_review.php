<?php
include '../database/db.php';
include './layout/header.php';
?>

<?php
$errors = [];
$success = [];

if (isset($_POST['create_review'])) {
    $customer_id = $_POST['customer_id'];
    $appointment_id = $_POST['appointment_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $date = $_POST['date'];

    if (empty($customer_id)) {
        $errors[] = "Customer ID is required!";
    }
    if (empty($appointment_id)) {
        $errors[] = "Appointment ID is required!";
    }
    if (empty($rating)) {
        $errors[] = "Rating is required!";
    }
    if (empty($comment)) {
        $errors[] = "Comment is required!";
    }

    // Check if the CustomerID exists in the 'customers' table
    if (count($errors) == 0) {
        $checkCustomerSql = "SELECT COUNT(*) FROM customers WHERE CustomerID = :customer_id";
        $stmt = $pdo->prepare($checkCustomerSql);
        $stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
        $stmt->execute();
        $customerExists = $stmt->fetchColumn();

        if (!$customerExists) {
            $errors[] = "Customer ID does not exist!";
        }
    }

    // Check if the AppointmentID exists in the 'appointments' table
    if (count($errors) == 0) {
        $checkAppointmentSql = "SELECT COUNT(*) FROM appointments WHERE AppointmentID = :appointment_id";
        $stmt = $pdo->prepare($checkAppointmentSql);
        $stmt->bindParam(':appointment_id', $appointment_id, PDO::PARAM_INT);
        $stmt->execute();
        $appointmentExists = $stmt->fetchColumn();

        if (!$appointmentExists) {
            $errors[] = "Appointment ID does not exist!";
        }
    }

    if (count($errors) == 0) {
        $sql = "INSERT INTO reviews (CustomerID, AppointmentID, Rating, Comment, ReviewDate) 
                VALUES (:customer_id, :appointment_id, :rating, :comment, :date)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
        $stmt->bindParam(':appointment_id', $appointment_id, PDO::PARAM_INT);
        $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $success[] = "Review created successfully!";
        } else {
            $errors[] = "Failed to create the review.";
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
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <?php
                        // Include error and success messages if any
                        include '../errors.php';
                        include '../success.php';
                        ?>

                        <!-- Form starts here -->
                        <h1 class="text-center fw-bold mb-4">Create Review</h1>

                        <form action="create_review.php" method="post" class="row">

                            <div class="col-12">
                                <label for="customer_id" class="form-label">Customer ID</label>
                                <select class="form-control" name="customer_id">
                                    <option>Select Customer</option>
                                    <?php
                                    $sql = "SELECT * FROM customers";
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute();
                                    $customers = $stmt->fetchALL(PDO::FETCH_ASSOC);

                                    foreach ($customers as $customer):

                                    ?>
                                        <option value="<?= $customer['CustomerID'] ?>"><?= $customer['name'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="appointment_id" class="form-label">Appointment ID</label>
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

                            <div class="col-12">
                                <label for="rating" class="form-label">Rating</label><br>

                                <?php
                                for ($i = 1; $i <= 5; $i++) {
                                    echo '<input type="radio" id="star' . $i . '" name="rating" value="' . $i . '" />';
                                    echo '<label for="star' . $i . '" title="' . $i . ' star' . ($i > 1 ? 's' : '') . '" aria-label="' . $i . ' star' . ($i > 1 ? 's' : '') . '">☆</label>';
                                }
                                ?>
                            </div>

                            <div class="col-12">
                                <label for="comment" class="form-label">Comment</label>
                                <textarea class="form-control" name="comment" rows="3" required></textarea>
                            </div>
                            <br><br>

                            <div class="col-12">
                            <label for="date" class="form-label">Date</label>
                                <input type="datetime-local" class="form-control" name="date" value="" required>
                            </div>

                            <div class="col-12 text-center mt-3">
                                <input type="submit" name="create_review" value="Create Review" class="btn btn-success">
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


<!-- Fatal error: Uncaught PDOException: SQLSTATE[23000]: Integrity constraint violation: 1452 Cannot add or update a child row:
  a foreign key constraint fails (`inance`.`reviews`, CONSTRAINT `Reviews_ibfk_2` FOREIGN KEY (`AppointmentID`) REFERENCES `appointments` (`AppointmentID`)) in C:\xampp\htdocs\inance\sb-admin\create_review.php:53 Stack trace: #0 C:\xampp\htdocs\inance\sb-admin\create_review.php(53):
     PDOStatement->execute() #1 {main} thrown in C:\xampp\htdocs\inance\sb-admin\create_review.php on line 53 -->