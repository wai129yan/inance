<?php
    include '../database/db.php';
    include './layout/header.php';
    ?>

    <?php
    $errors = [];
    $success = [];
    ?>

    <?php
   
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
                <h1 class="text-center fw-bold mb-4">Create Career</h1>

                <form action="create_career.php" class="row" method="post">
                  <!-- Name Field -->
                  <div class="col-12">
                    <label for="name" class="form-label"> Career Name</label>
                    <input type="text" class="form-control" name="name" value="" required>
                  </div>

                  <!-- Description Field -->
                  <div class="col-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" name="description" rows="3" required></textarea>
                  </div>
                  <!-- Submit Button -->
                  <div class="col-12 text-center mt-3">
                    <input type="submit" name="create_career" value="Create Career" class="btn btn-success">
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