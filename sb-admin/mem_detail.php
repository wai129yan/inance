<?php
    include '../database/db.php';
    include './layout/header.php';
    ?>


    <?php
    $sql = "SELECT plan_id, plan_name, description ,price,duration FROM membership_plans";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $plans = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
                        <h1 class="h3 mb-2 text-gray-800 mb-3">Member Plan Data Table</h1>
                        <!-- DataTales Example -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Member Lists</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Plan Name</th>
                                                <th>Description</th>
                                                <th>Price</th>
                                                <th>Duration</th>
                                                <th>Action</th>

                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>Plan Name</th>
                                                <th>Description</th>
                                                <th>Price</th>
                                                <th>Duration</th>
                                                <th>Action</th>

                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php foreach ($plans as $plan): ?>
                                                <tr>
                                                    <td><?php echo $plan['plan_id']; ?></td>
                                                    <td><?php echo $plan['plan_name']; ?></td>
                                                    <td><?php echo $plan['description']; ?></td>
                                                    <td><?php echo $plan['price'] . ' $'; ?></td>
                                                    <td><?php echo $plan['duration']. ' Months' ;?></td>

                                                    <td>
                                                        <a href="edit_plan.php?plan_id=<?php echo $plan['plan_id']; ?>" class="btn btn-info btn-sm">Edit</a>

                                                        <a href="delete_plan.php?plan_id=<?php echo $plan['plan_id']; ?>" class="btn btn-danger btn-sm swl-delete" >Delete</a>
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