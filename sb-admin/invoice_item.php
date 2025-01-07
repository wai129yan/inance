<?php
include '../database/db.php';
include './layout/header.php';
?>

<?php
// Fixed SQL query with commas between column names
$sql = "SELECT InvoiceItemID,InvoiceID,Description,Quantity,UnitPrice,TotalPrice FROM invoiceitems";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$invoiceIts = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                    <h1 class="h3 mb-2 text-gray-800 mb-3">InvoiceItem Data Table</h1>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">InvoiceItem Lists</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>InvoiceItemID</th>
                                            <th>InvoiceID</th>
                                            <th>Description</th>
                                            <th>Quantity</th>
                                            <th>UnitPrice</th>
                                            <th>TotalPrice</th>
                                        </tr>
                                    </thead>
                                    <!-- <tfoot>
                                        <tr>
                                            <th>serviceID</th>
                                            <th>serviceName</th>
                                            <th>Description</th>
                                            <th>BasePrice</th>
                                            <th>Duration</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot> -->
                                    <tbody>
                                        <?php foreach ($invoiceIts as $invoiceIt): ?>
                                            <tr>
                                                <td><?php echo $invoiceIt['InvoiceID']; ?></td>
                                                <td><?php echo $invoiceIt['Description']; ?></td>
                                                <td><?php echo $invoiceIt['Quantity']; ?></td>
                                                <td><?php echo $invoiceIt['UnitPrice']; ?></td>
                                                <td><?php echo $invoiceIt['TotalPrice']; ?></td>
                                                
                                                <td>
                                                    <a href="edit_invoiceItem.php?InvoiceItemID=<?php echo $invoiceIt['InvoiceItemID']; ?>" class="btn btn-info btn-sm">Edit</a>
                                                    
                                                    <a href="delete_invoiceItem.php?InvoiceItemID=<?php echo $invoiceIt['InvoiceItemID']; ?>" class="btn btn-danger btn-sm swl-delete">Delete</a>
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