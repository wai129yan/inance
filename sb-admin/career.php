    <?php
    include './layout/header.php';

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
                include './table.php';
                ?>
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