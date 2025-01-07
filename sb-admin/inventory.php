<?php
include '../database/db.php';
include './layout/header.php';
?>


<?php
$sql = "SELECT ItemID,itemName,description,quantity,unitPrice,reorderLevel FROM inventory";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$inventorys = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
                    <h1 class="h3 mb-2 text-gray-800 mb-3">Inventory Data Table</h1>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Inventory Lists</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Item Name</th>
                                            <th>Description</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Reorder Level</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <!-- <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Item Name</th>
                                            <th>Description</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Reorder Level</th>
                                            <th>Action</th>


                                        </tr>
                                    </tfoot> -->
                                    <tbody>
                                        <?php foreach ($inventorys as $inventory): ?>
                                            <tr>
                                                <td><?php echo $inventory['ItemID']; ?></td>
                                                <td><?php echo $inventory['itemName']; ?></td>
                                                <td><?php echo $inventory['description']; ?></td>
                                                <td><?php echo $inventory['quantity']; ?></td>
                                                <td><?php echo $inventory['unitPrice']; ?></td>
                                                <td><?php echo $inventory['reorderLevel']; ?></td>
                                                <td>
                                                    <a href="edit_inventory.php?ItemID=<?php echo $inventory['ItemID']; ?>" class="btn btn-info btn-sm">Edit</a>

                                                    <a href="delete_inventory.php?ItemID=<?php echo $inventory['ItemID']; ?>" class="btn btn-danger btn-sm swl-delete">Delete</a>
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