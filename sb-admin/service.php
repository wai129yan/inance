<?php
include '../database/db.php';
include './layout/header.php';
?>

<?php
// Fixed SQL query with commas between column names
$sql = "SELECT serviceID, serviceName, description, basePrice, duration FROM services";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

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
                    <h1 class="h3 mb-2 text-gray-800 mb-3">Service Data Table</h1>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Service Lists</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>serviceID</th>
                                            <th>serviceName</th>
                                            <th>Description</th>
                                            <th>BasePrice</th>
                                            <th>Duration</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>serviceID</th>
                                            <th>serviceName</th>
                                            <th>Description</th>
                                            <th>BasePrice</th>
                                            <th>Duration</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php foreach ($services as $service): ?>
                                            <tr>
                                                <td><?php echo $service['serviceID']; ?></td>
                                                <td><?php echo $service['serviceName']; ?></td>
                                                <td><?php echo $service['description']; ?></td>
                                                <td><?php echo $service['basePrice'] ; ?></td>
                                                <td><?php echo $service['duration'] ; ?></td>
                                                <td>
                                                    <a href="edit_service.php?serviceID=<?php echo $service['serviceID']; ?>" class="btn btn-info btn-sm">Edit</a>
                                                    <a href="delete_service.php?serviceID=<?php echo $service['serviceID']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this career?');">Delete</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <!-- End of Footer -->

    <!-- Logout Modal-->
    <?php
    include './layout/footer.php';
    ?>
</div>
