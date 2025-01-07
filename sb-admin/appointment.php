<?php
include '../database/db.php';
include './layout/header.php';
?>


<?php
$sql = "SELECT AppointmentID, CustomerID, ServiceID, TechnicianID, AppointmentDate, StartTime, EndTime, Status, Notes FROM appointments";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);


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
            <div class="container-fluid">
                <!-- Page Heading -->
                <!-- Content Row -->
                <?php
                // include './table.php';
                ?>
                <!-- Table For Career -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800 mb-3">Appointment Data Table</h1>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Appointment Lists</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Appointment ID</th>
                                            <th>Customer ID</th>
                                            <th>Service ID</th>
                                            <th>Technician ID</th>
                                            <th>Appointment Date</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Status</th>
                                            <th>Notes</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Appointment ID</th>
                                            <th>Customer ID</th>
                                            <th>Service ID</th>
                                            <th>Technician ID</th>
                                            <th>Appointment Date</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Status</th>
                                            <th>Notes</th>
                                            <th>Action</th>

                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php foreach ($appointments as $appointment): ?>
                                            <tr>
                                                <td><?php echo $appointment['AppointmentID']; ?></td>
                                                <td><?php echo $appointment['CustomerID']; ?></td>
                                                <td><?php echo $appointment['ServiceID']; ?></td>
                                                <td><?php echo $appointment['TechnicianID']; ?></td>
                                                <td><?php echo $appointment['AppointmentDate']; ?></td>
                                                <td><?php echo $appointment['StartTime']; ?></td>
                                                <td><?php echo $appointment['EndTime']; ?></td>
                                                <td><?php echo $appointment['Status']; ?></td>
                                                <td><?php echo $appointment['Notes']; ?></td>

                                                <td>
                                                    <a href="edit_appointment.php?AppointmentID=<?php echo $appointment['AppointmentID']; ?>" class="btn btn-info btn-sm">Edit</a>

                                                    <a href="delete_appointment.php?AppointmentID=<?php echo $appointment['AppointmentID']; ?>" class="btn btn-danger btn-sm swl-delete">Delete</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>


                <!-- Content Row -->

                <!-- Content Row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->

        <!-- End of Footer -->

        <!-- Logout Modal-->
        <?php
        include './layout/footer.php';
        ?>