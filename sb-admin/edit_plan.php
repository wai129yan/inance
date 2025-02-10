<?php
include '../database/db.php';
include './layout/header.php';

$errors = [];
$success = [];


if (isset($_GET['plan_id'])) {
    $planID = $_GET['plan_id'];
    $sql = "SELECT * FROM membership_plans WHERE plan_id = :plan_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':plan_id', $planID, PDO::PARAM_INT);
    $stmt->execute();

    $memPlan = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$memPlan) {
        $errors[] = "Plan not found!";
    }
} else {
    $errors[] = "Invalid Plan ID!";
}



if (isset($_POST['update_plan'])) {
    $plan_name = $_POST['plan_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];

    // Validate input
    if (empty($plan_name)) {
        $errors[] = 'Plan name is required';
    }
    if (empty($description)) {
        $errors[] = 'Description is required';
    }
    if (empty($price) || !is_numeric($price)) {
        $errors[] = 'Valid price is required';
    }
    if (empty($duration)) {
        $errors[] = 'Duration is required';
    }

    // If no errors, update the plan in the database
    if (empty($errors)) {
        $sql = "UPDATE membership_plans SET plan_name = :name, description = :description, price = :price, duration = :duration WHERE plan_id = :plan_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $plan_name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_INT);
        $stmt->bindParam(':duration', $duration, PDO::PARAM_INT);
        $stmt->bindParam(':plan_id', $plan_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $success[] = "Plan updated successfully!";
            // Optionally, redirect to another page after successful update
            // header("Location: success_page.php");
            // exit();
        } else {
            $errors[] = "Failed to update the plan.";
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
                        <?php include '../errors.php'; ?>
                        <?php include '../success.php'; ?>

                        <h1 class="text-center fw-bold mb-4">Edit Membership Plan</h1>

                        <form action="" method="post">
                            <input type="hidden" name="id" value="<?= ($memPlan['plan_id'] ?? ''); ?>">

                            <!-- Plan Name -->
                            <div class="form-group">
                                <label for="plan_name">Plan Name</label>
                                <select class="form-control" name="plan_name">
                                    <option value="basic" <?= ($memPlan['plan_name'] ?? '') == 'basic' ? 'selected' : ''; ?>>Basic</option>
                                    <option value="standard" <?= ($memPlan['plan_name'] ?? '') == 'standard' ? 'selected' : ''; ?>>Standard</option>
                                    <option value="premium" <?= ($memPlan['plan_name'] ?? '') == 'premium' ? 'selected' : ''; ?>>Premium</option>
                                </select>
                            </div>

                            <!-- Description -->
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" rows="3" name="description" placeholder="Enter plan description"><?= htmlspecialchars($memPlan['description'] ?? ''); ?></textarea>
                            </div>

                            <!-- Price -->
                            <div class="form-group">
                                <label for="price">Price ($)</label>
                                <input type="number" class="form-control" name="price" value="<?= $memPlan['price'] ?? ''; ?>" placeholder="Enter price" required>
                            </div>

                            <!-- Duration -->
                            <div class="form-group">
                                <label for="duration">Duration</label>
                                <select class="form-control" name="duration" required>
                                    <option value="1" <?= ($memPlan['duration'] ?? '') == 1 ? 'selected' : ''; ?>>1 Month</option>
                                    <option value="3" <?= ($memPlan['duration'] ?? '') == 3 ? 'selected' : ''; ?>>3 Months</option>
                                    <option value="6" <?= ($memPlan['duration'] ?? '') == 6 ? 'selected' : ''; ?>>6 Months</option>
                                    <option value="12" <?= ($memPlan['duration'] ?? '') == 12 ? 'selected' : ''; ?>>12 Months</option>
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" name="update_plan" class="btn btn-primary btn-block">Update Plan</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <?php include './layout/footer.php'; ?>
        </div>
    </div>
</div>