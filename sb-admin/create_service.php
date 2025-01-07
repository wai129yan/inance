<?php
include '../database/db.php';
include './layout/header.php';
?>

<?php
$errors = [];
$success = [];
?>

<?php
if(isset($_POST['create_service'])){
    $name = $_POST['serviceName'];
    $description  = $_POST['description'];
    $basePrice  = $_POST['basePrice'];
    $duration = $_POST['duration'];

    empty($name) ? $errors[] = "Name Required" : "";
    empty($description) ? $errors[] = "Description Required" : "";
    empty($basePrice) ? $errors[] = "Base Price Required" : "";
    empty($duration) ? $errors[] = "Duration Required" : "";

    if(count($errors) == 0){
        $serSql = "SELECT COUNT(*) FROM services WHERE serviceName = :name";
        $stmt = $pdo->prepare($serSql);
        $stmt->bindParam(':name',$name,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if($count){
            $errors[] = "Service Name Already Exists";
        }else{
            $sql = "INSERT INTO services (serviceName,description,basePrice,duration) VALUES (:name,:description,:basePrice,:duration)";
            $result = $pdo->prepare($sql);
            $result->bindParam(':name',$name,PDO::PARAM_STR);
            $result->bindParam(':description',$description,PDO::PARAM_STR);
            $result->bindParam(':basePrice',$basePrice,PDO::PARAM_STR);
            $result->bindParam(':duration',$duration,PDO::PARAM_STR);
            $result->execute();
            if($result){
                $success[] = "Created Successfully";
            }else{
                $errors[] = "Failed to create the record.";
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
                        <h1 class="text-center fw-bold mb-4">Create Service </h1>

                        <form action="create_service.php" class="row" method="post">
                            <!-- Name Field -->
                            <div class="col-12">
                                <label for="name" class="form-label"> Service Name</label>
                                <input type="text" class="form-control" name="serviceName" value="" required>
                            </div>

                            <!-- Description Field -->
                            <div class="col-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="3" required></textarea>
                            </div>

                            <div class="col-12">
                                <label for="basePrice">Base Price</label>
                                <input type="number" class="form-control" id="basePrice" name="basePrice" step="0.01" required>
                            </div>

                            <div class="col-12">
                                <label for="duration">Duration (e.g. '1 hour', '30 minutes')</label>
                                <input type="text" class="form-control" id="duration" name="duration" required>
                            </div>
                            
                            <div class="col-12 text-center mt-3">
                                <input type="submit" name="create_service" value="Create Service" class="btn btn-success">
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