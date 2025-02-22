<?php
include "../database/db.php";


// Get offset from POST request
$offset = $_POST['offset'] ?? 0;

// Fetch next 3 technicians 
$sql = "SELECT * FROM posts LIMIT 3 OFFSET :offset";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Generate HTML for each technician
foreach ($posts as $post) :
?>
    <div class="col-sm-6 col-md-4 mx-auto">

        <div class="box ">
            <div class="img-box">
                <!-- <img src="./customerPhotos/<= $post['photo'] ?? 'dummy.png' ?>" alt="photo" /> -->
                <?php
                
                $photos = json_decode($post['photo']); 
                //print_r($photos[0]);
                
                $photoToShow = !empty($photos) ? $photos[0] : 'dummy.png';

                echo '<img src="./photos/' . htmlspecialchars($photoToShow) . '" alt="photo" />'
                ?>

                

            </div>
            <div class="detail-box">
                <h5>
                    <a href="./job_detail.php?id=<?= $post['id']; ?>"><?= strlen($post['title']) > 20 ? substr($post['title'], 0, 20) . '...' : $post['title']; ?></a>
                </h5>
                <p>
                    <?= strlen($post['content']) > 20 ? substr($post['content'], 0, 20) . '...' : $post['content']; ?>
                </p>
                <p>
                    $ <?= $post['price']  ?>
                </p>

            </div>
        </div>
        <?php
        // $sql = "SELECT * FROM careeries WHERE career_id = ?";
        // $stmt = $pdo->prepare($sql);
        // $stmt->execute([$technician['career_id']]);
        // $career = $stmt->fetch(PDO::FETCH_ASSOC);
        ?>
        <!-- <= $career['name'] ?? "" ?> -->
        </p>

    </div>
    </div>
<?php endforeach; ?>