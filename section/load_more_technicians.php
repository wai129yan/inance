<?php
include "../database/db.php";


// Get offset from POST request
$offset = $_POST['offset'] ?? 0;

// Fetch next 3 technicians 
$sql = "SELECT * FROM technicians LIMIT 3 OFFSET :offset";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$technicians = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Generate HTML for each technician
foreach ($technicians as $technician) :
?>
    <div class="col-sm-6 col-md-4 mx-auto">
        <div class="box">
            <div class="img-box">
                <img src="images/s1.png" alt="" />
            </div>
            <div class="detail-box">
                <h5>
                    <?= $technician['name'] ?>
                </h5>
                <p>
                    <?= $technician['email'] ?>
                </p>
                <p>
                    <?= $technician['Phone'] ?>
                </p>
                <p>
                    <?= $technician['Address'] ?>
                </p>
                <p>
                    <?php 
                    $sql = "SELECT * FROM careeries WHERE career_id = ?";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$technician['career_id']]);
                    $career = $stmt->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <?= $career['name'] ?>
                </p>
            </div>
        </div>
    </div>
<?php endforeach; ?>
