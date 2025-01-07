<?php
include '../database/db.php';
include './layout/header.php';
?>

<?php
$errors = [];
$success = [];

if (isset($_GET['ReviewID'])) {
    $ReviewID = $_GET['ReviewID'];
    $sql = "SELECT * FROM reviews WHERE ReviewID = :ReviewID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':ReviewID', $ReviewID, PDO::PARAM_INT);
    $stmt->execute();
    $review = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$review) {
        $errors[] = "Review not found!";
    }
} else {
    $errors[] = "Invalid Review ID!";
}

if (isset($_POST['update_review'])) {
    $customerid = $_POST['customer_id'];
    $appointmentid = $_POST['appointment_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $date = $_POST['date'];

    if (empty($customerid)) {
        $errors[] = "Customer ID is required!";
    }
    if (empty($appointmentid)) {
        $errors[] = "Appointment ID is required!";
    }
    if (empty($rating)) {
        $errors[] = "Rating is required!";
    }
    if (empty($comment)) {
        $errors[] = "Comment is required!";
    }
    if (empty($date)) {
        $errors[] = "Review Date is required!";
    }

    if (count($errors) == 0) {
        // Validate Customer ID
        $checkCustomerSql = "SELECT COUNT(*) FROM customers WHERE CustomerID = :customer_id";
        $stmt = $pdo->prepare($checkCustomerSql);
        $stmt->bindParam(':customer_id', $customerid, PDO::PARAM_INT);
        $stmt->execute();
        $customerExists = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($customerExists['COUNT(*)'] == 0) {
            $errors[] = "Customer ID does not exist!";
        }
    }

    if (count($errors) == 0) {
        // Validate Appointment ID
        $checkAppointmentSql = "SELECT COUNT(*) FROM appointments WHERE AppointmentID = :appointment_id";
        $stmt = $pdo->prepare($checkAppointmentSql);
        $stmt->bindParam(':appointment_id', $appointmentid, PDO::PARAM_INT);
        $stmt->execute();
        $appointmentExists = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($appointmentExists['COUNT(*)'] == 0) {
            $errors[] = "Appointment ID does not exist!";
        }
    }

    // Update review if there are no errors
    if (count($errors) == 0) {
        $sql = "UPDATE reviews SET customerid = :customer_id, appointmentid = :appointment_id, rating = :rating, comment = :comment, ReviewDate = :date WHERE ReviewID = :ReviewID";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':customer_id', $customerid, PDO::PARAM_INT);
        $stmt->bindParam(':appointment_id', $appointmentid, PDO::PARAM_INT);
        $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->bindParam(':ReviewID', $ReviewID, PDO::PARAM_INT);
        $result = $stmt->execute();

        if ($result) {
            $success[] = "Review updated successfully!";
        } else {
            $errors[] = "Failed to update Review!";
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
                        <h1 class="text-center fw-bold mb-4">Edit Review</h1>

                        <form action="" method="post" class="row">
                            <input type="hidden" name="id" value="<?= $review['ReviewID']; ?>">

                            <div class="col-12">
                                <label for="customer_id" class="form-label">Customer ID</label>
                                <input type="text" class="form-control" value="<?= $review['CustomerID']; ?>" name="customer_id" required>
                            </div>

                            <div class="col-12">
                                <label for="appointment_id" class="form-label">Appointment ID</label>
                                <input type="text" class="form-control" value="<?= $review['AppointmentID']; ?>" name="appointment_id" required>
                            </div>

                            <div class="col-12">
                                <label for="rating" class="form-label">Rating</label><br>

                                <?php
                                // Assuming $old_rating is the old rating value (e.g., fetched from the database)
                                $old_rating = $review['Rating']; // Replace this with the actual value from the database

                                for ($i = 1; $i <= 5; $i++) {
                                    // Check if the current rating matches the old rating
                                    $checked = ($i == $old_rating) ? 'checked' : '';

                                    echo '<input type="radio" id="star' . $i . '" name="rating" value="' . $i . '" ' . $checked . ' />';
                                    echo '<label for="star' . $i . '" title="' . $i . ' star' . ($i > 1 ? 's' : '') . '" aria-label="' . $i . ' star' . ($i > 1 ? 's' : '') . '">☆</label>';
                                }
                                ?>
                            </div>

                            <div class="col-12">
                                <label for="comment" class="form-label">Comment</label>
                                <textarea class="form-control" name="comment" rows="3" required><?= htmlspecialchars($review['Comment']); ?></textarea>
                            </div>

                            <!-- <div class="col-12">
                                <label for="comment" class="form-label">ReviewDate</label>
                                <input type="date" class="form-control" name="date" value="<?= $review['ReviewDate']; ?>" required>
                            </div>-->

                            <div class="col-12">
                                <label for="comment" class="form-label">ReviewDate</label>
                                <?php
                                // Assuming $review['ReviewDate'] is in the format 'YYYY-MM-DD HH:MM:SS'
                                $formattedDate = date('Y-m-d', strtotime($review['ReviewDate']));
                                ?>
                                <input type="datetime-local" class="form-control" name="date" value="<?= $formattedDate; ?>" required>
                            </div>

                            <div class="col-12 text-center mt-3">
                                <input type="submit" name="update_review" value="Update Review" class="btn btn-success">
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