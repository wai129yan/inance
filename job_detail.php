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
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($posts) {
        // Since fetchAll() returns an array, get the first post
        $post = $posts[0];

        $title = htmlspecialchars($post['title']);
        $content = htmlspecialchars($post['content']);
        $price = htmlspecialchars($post['price']);
        $photo = htmlspecialchars($post['photo']);

        // echo "<pre>";
        // print_r($post);
        // die();
    } else {
        echo "Post not found.";
        exit;
    }
} else {
    echo "Invalid post ID.";
    exit;
}

include("./layout/header.php");
include("./layout/hero2.php");
?>
<div class="row">
    <div class="col-md-8">
        <section class="job-detail py-5">
            <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="card" style="max-width: 600px; width: 100%;">
                    <!-- Display the image if exists, otherwise show a default image -->
                    <img src="./customerPhotos/<?= $post['photo'] ?? 'dummy.png' ?>" alt="photo" />
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
    </div>
    <div class="col-md-4">

    </div>
</div>
