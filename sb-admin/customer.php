<?php
include '../database/db.php';
include './layout/header.php';
?>


<?php
$sql = "SELECT CustomerID, name,email,phone,address,created_date  FROM customers";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
                    <h1 class="h3 mb-2 text-gray-800 mb-3">Customer Data Table</h1>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Customer Lists</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Customer Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>Created Date</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Customer Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>Created Date</th>
                                            <th>Action</th>

                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php foreach ($customers as $customer): ?>
                                            <tr>
                                                <td><?php echo $customer['CustomerID']; ?></td>
                                                <td><?php echo $customer['name']; ?></td>
                                                <td><?php echo $customer['email']; ?></td>
                                                <td><?php echo $customer['phone']; ?></td>
                                                <td><?php echo $customer['address']; ?></td>
                                                <td><?php echo $customer['created_date']; ?></td>

                                                <td>
                                                    <a href="edit_customer.php?CustomerID=<?php echo $customer['CustomerID']; ?>" class="btn btn-info btn-sm">Edit</a>

                                                    <a href="delete_customer.php?CustomerID=<?php echo $customer['CustomerID']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this career?');">Delete</a>
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