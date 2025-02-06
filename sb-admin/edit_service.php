<?php
include '../database/db.php';
include './layout/header.php';
?>

<?php
$errors = [];
$success = [];
?>

<?php
if(isset($_GET['serviceID'])){
    $serviceID = $_GET['serviceID'];

    $sql = "SELECT * FROM services WHERE serviceID = :serviceID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':serviceID', $serviceID, PDO::PARAM_INT);
    $stmt->execute();
    $service = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$service){
        $errors[] = "Service not found!";
    }
}else{
    $errors[] = "Invalid service ID!";
}


if(isset($_POST['update_service'])){
    $name = $_POST['serviceName'];
    $description = $_POST['description'];
    $basePrice = $_POST['basePrice'];
    $duration = $_POST['duration'];
    

    if(empty($name)){
        $errors[] = "Service name is required!";
    }
    if(empty($description)){
        $errors[] = "Description is required!";
    }
    if(empty($basePrice)){
        $errors[] = "Base price is required!";
    }
    if(empty($duration)){
        $errors[] = "Duration is required!";
    }
    if (count($errors) == 0){
        $sql = "UPDATE services SET serviceName = :name, description = :description, basePrice = :basePrice, duration = :duration WHERE serviceID = :serviceID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':basePrice', $basePrice, PDO::PARAM_STR);
        $stmt->bindParam(':duration', $duration, PDO::PARAM_STR);
        $stmt->bindParam(':serviceID', $serviceID, PDO::PARAM_INT);
        if($stmt->execute()){
            $success[] = "Service updated successfully!";
        }else{
            $errors[] = "Failed to update service!";
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
                        <h1 class="text-center fw-bold mb-4">Service Career</h1>

                        <form action="" class="row" method="post">
                            <!-- Name Field -->
                            <input type="hidden" name="id" value="<?= $service['ServiceID']; ?>">

                            <div class="col-12">
                                <label for="name" class="form-label"> Service Name</label>
                                <input type="text" class="form-control" value="<?= $service['ServiceName']; ?>"  name="serviceName" value="" required>
                            </div>

                            <!-- Description Field -->
                            <div class="col-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control"  name="description" rows="3" required><?= $service['Description']; ?></textarea>
                            </div>

                            <div class="col-12">
                                <label for="basePrice">Base Price</label>
                                <input type="number" class="form-control" id="basePrice"  value="<?= $service['BasePrice']; ?>" name="basePrice" step="0.01" required>
                            </div>

                            <div class="col-12">
                                <label for="duration">Duration (e.g. '1 hour', '30 minutes')</label>
                                <input type="text" class="form-control" id="duration"value="<?= $service['Duration']; ?>" name="duration" required>
                            </div>
                            
                            <div class="col-12 text-center mt-3">
                                <input type="submit" name="update_service" value="Update Service" class="btn btn-success">
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