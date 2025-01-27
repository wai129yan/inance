<?php
// Include database connection
include("./database/db.php"); // Replace with your actual config file

// Get the post ID from the query parameter
$postId = $_GET['id'] ?? null;

if ($postId) {
    // Fetch the specific post from the database
    $sql = "SELECT * FROM posts WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $postId, PDO::PARAM_INT);
    $stmt->execute();
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($post) {
       
        $title = htmlspecialchars($post['title']);
        $content = htmlspecialchars($post['content']);
        $price = htmlspecialchars($post['price']);
        $photo = htmlspecialchars($post['photo']);
    } else {
        
        echo "Post not found.";
        exit;
    }
} else {
    echo "Invalid post ID.";
    exit;
}
include("./layout/header.php"); 
?>
<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?> - Job Details</title>
    <link rel="stylesheet" href="style.css"> <!-- Replace with your actual CSS file -->
<!-- </head>
<body> --> 
<section class="job-detail py-5">
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="card" style="max-width: 600px; width: 100%;">
            <img class="card-img-top" src="./customerPhotos/<?= $photo ?: 'client-1.jpg'; ?>" alt="<?= $title; ?>">
            <div class="card-body shadow-lg rounded">
                <h3 class="card-title text-center"><?= $title; ?></h3>
                <p class="card-text text-center mt-4"><strong>Content - </strong> <?= $content; ?></p>
                <p class="card-text text-center">
                    <strong>Price - </strong> $<?= $price; ?>
                </p>
                <div class="text-center">
                    <a href="index.php" class="btn btn-primary">Back to Jobs</a>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- </body>
</html> -->
<!-- 
<div class="card" style="width: 18rem;">
  <img src="..." class="card-img-top" alt="...">
  <div class="card-body">
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
  </div>
</div> -->