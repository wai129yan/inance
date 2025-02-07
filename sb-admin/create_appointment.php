<?php
include '../database/db.php';
include './layout/header.php';
?>

<?php
$errors = [];
$success = [];
?>

<?php
if (isset($_POST['create_appointment'])) {
  $customerID = $_POST['customer_id'];
  $serviceID = $_POST['service_id'];
  $technicianID = $_POST['technician_id'];
  $appointmentDate = $_POST['appointment_date'];
  $startTime = $_POST['start_time'];
  $endTime = $_POST['end_time'];
  $status = $_POST['status'];
  $notes = $_POST['notes'];

  // Validation
  empty($customerID) ? $errors[] = "Customer ID is required." : "";
  empty($serviceID) ? $errors[] = "Service ID is required." : "";
  empty($technicianID) ? $errors[] = "Technician ID is required." : "";
  empty($appointmentDate) ? $errors[] = "Appointment date is required." : "";
  empty($startTime) ? $errors[] = "Start time is required." : "";
  empty($endTime) ? $errors[] = "End time is required." : "";
  empty($status) ? $errors[] = "Status is required." : "";
  empty($notes) ? $errors[] = "Notes is required." : "";

  // Check for time conflicts
  if (count($errors) == 0) {
    $checkSql = "SELECT COUNT(*) FROM appointments WHERE TechnicianID = :technicianID AND AppointmentDate = :appointmentDate AND 
                     ((:startTime BETWEEN StartTime AND EndTime) OR (:endTime BETWEEN StartTime AND EndTime))";
    $stmt = $pdo->prepare($checkSql);
    $stmt->bindParam(':technicianID', $technicianID, PDO::PARAM_INT);
    $stmt->bindParam(':appointmentDate', $appointmentDate, PDO::PARAM_STR);
    $stmt->bindParam(':startTime', $startTime, PDO::PARAM_STR);
    $stmt->bindParam(':endTime', $endTime, PDO::PARAM_STR);
    $stmt->execute();
    $conflict = $stmt->fetchColumn();

    if ($conflict) {
      $errors[] = "Technician is already booked for this time slot.";
    } else {
      // Insert Record
      $sql = "INSERT INTO appointments (CustomerID, ServiceID, TechnicianID, AppointmentDate, StartTime, EndTime, Status, Notes)
                    VALUES (:customerID, :serviceID, :technicianID, :appointmentDate, :startTime, :endTime, :status, :notes)";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':customerID', $customerID, PDO::PARAM_INT);
      $stmt->bindParam(':serviceID', $serviceID, PDO::PARAM_INT);
      $stmt->bindParam(':technicianID', $technicianID, PDO::PARAM_INT);
      $stmt->bindParam(':appointmentDate', $appointmentDate, PDO::PARAM_STR);
      $stmt->bindParam(':startTime', $startTime, PDO::PARAM_STR);
      $stmt->bindParam(':endTime', $endTime, PDO::PARAM_STR);
      $stmt->bindParam(':status', $status, PDO::PARAM_STR);
      $stmt->bindParam(':notes', $notes, PDO::PARAM_STR);
      if ($stmt->execute()) {
        $success[] = "Appointment created successfully.";
      } else {
        $errors[] = "Failed to create appointment.";
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
            <h1 class="text-center fw-bold mb-4">Create Appointment</h1>

            <form action="create_appointment.php" class="row" method="post">
              <!-- Customer ID Field -->
              <div class="col-12 mb-3">
                <label for="customer_id" class="form-label">Customer Name</label>
                <!-- <input type="number" class="form-control" name="customer_id" required> -->
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

              <!-- Service ID Field -->
              <div class="col-12 mb-3">
                <label for="service_id" class="form-label">Service Name</label>
                <select class="form-control" name="service_id">
                  <option>Select Service</option>
                  <?php
                  $sql = "SELECT * FROM services";
                  $stmt = $pdo->prepare($sql);
                  $stmt->execute();
                  $services = $stmt->fetchALL(PDO::FETCH_ASSOC);

                  foreach ($services as $service):

                  ?>
                    <option value="<?= $service['ServiceID'] ?>"><?= $service['ServiceName'] ?></option>
                  <?php endforeach ?>
                </select>
              </div>

              <!-- Technician ID Field -->
              <div class="col-12 mb-3">
                <label for="TechnicianID" class="form-label">Technician Name</label>
                <select class="form-control" name="technician_id">
                  <option>Select Technician</option>
                  <?php
                  $sql = "SELECT * FROM technicians";
                  $stmt = $pdo->prepare($sql);
                  $stmt->execute();
                  $technicians = $stmt->fetchAll(PDO::FETCH_ASSOC); // Corrected to fetchAll

                  foreach ($technicians as $technician): // Corrected variable name
                  ?>
                    <option value="<?= $technician['TechnicianID'] ?>"><?= $technician['name'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <!-- Appointment Date Field -->
              <div class="col-12 mb-3">
                <label for="appointment_date" class="form-label">Appointment Date</label>
                <input type="date" class="form-control" name="appointment_date" required>
              </div>

              <!-- Start Time Field -->
              <div class="col-12 mb-3">
                <label for="start_time" class="form-label">Start Time</label>
                <input type="time" class="form-control" name="start_time" required>
              </div>

              <!-- End Time Field -->
              <div class="col-12 mb-3">
                <label for="end_time" class="form-label">End Time</label>
                <input type="time" class="form-control" name="end_time" required>
              </div>

              <!-- Status Field -->
              <div class="col-12 mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" name="status" >
                  <option value="pending">Pending</option>
                  <option value="confirmed">Confirmed</option>
                  <option value="cancelled">Cancelled</option>
                </select>
              </div>

              <!-- Notes Field -->
              <div class="col-12 mb-3">
                <label for="notes" class="form-label">Notes</label>
                <textarea class="form-control" name="notes" rows="3"></textarea>
              </div>

              <!-- Submit Button -->
              <div class="col-12 text-center mt-3">
                <input type="submit" name="create_appointment" value="Create Appointment" class="btn btn-success">
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