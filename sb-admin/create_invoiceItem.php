<?php
include '../database/db.php';
include './layout/header.php';
?>

<?php
$errors = [];
$success = [];
?>

<?php
if(isset($_POST['create_invoiceIt'])){
    $InvoiceID = $_POST['InvoiceID'];
    $description  = $_POST['description'];
    $quantity  = $_POST['quantity'];
    $unitPrice = $_POST['unitPrice'];
    $totalPrice = $_POST['totalPrice'];

    if(empty($InvoiceID)){
        $errors[] = "Invoice ID Required";
    }
    if(empty($description)){
        $errors[] = "Description Required";
    }   
    if(empty($quantity)){
        $errors[] = "Quantity Required";
    }   
    if(empty($unitPrice)){
        $errors[] = "Unit Price Required";
    }
    if(empty($totalPrice)){
        $errors[] = "Total Price Required";
    }
    if(count($errors) == 0){
        $sqlInvoice = "SELECT COUNT(*) FROM invoices WHERE InvoiceID = :InvoiceID";
        $stmt = $pdo->prepare($sqlInvoice);
        $stmt->bindParam(':InvoiceID',$InvoiceID,PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        if(!$count){
            $errors[] = "Invoice ID does not exist";
        }else{
            $sql = "INSERT INTO invoiceItems (InvoiceID,Description,Quantity,UnitPrice,TotalPrice) VALUES (:InvoiceID,:description,:quantity,:unitPrice,:totalPrice)";
            $result = $pdo->prepare($sql);
            $result->bindParam(':InvoiceID',$InvoiceID,PDO::PARAM_INT);
            $result->bindParam(':description',$description,PDO::PARAM_STR);
            $result->bindParam(':quantity',$quantity,PDO::PARAM_STR);
            $result->bindParam(':unitPrice',$unitPrice,PDO::PARAM_STR);
            $result->bindParam(':totalPrice',$totalPrice,PDO::PARAM_STR);
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
                        <h1 class="text-center fw-bold mb-4">Create InvoiceItem</h1>

                        <form action="create_invoiceItem.php" class="row" method="post">
                          
                            <div class="col-12">
                                <label for="InvoiceId" class="form-label">Invoice ID</label>
                                <input type="number" class="form-control"  name="InvoiceID" value="" required>
                            </div>

                            
                            <div class="col-12">
                                <label for="text" class="form-label">Description</label>
                               <textarea  class="form-control" name="description" ></textarea>
                            </div>

                            
                            <div class="col-12">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" name="quantity"  required>
                            </div>

                            
                            <div class="col-12">
                                <label for="unitprice" class="form-label">UnitPrice</label>
                                <input type="number" class="form-control" name="unitPrice" required>
                            </div>

                            <!-- Due Date Field -->
                            <div class="col-12">
                                <label for="totalprice" class="form-label">TotalPrice</label>
                                <input type="number" class="form-control"name="totalPrice" required>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-12 text-center mt-3">
                                <input type="submit" name="create_invoiceIt" value="Create Invoice-Item" class="btn btn-success">
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