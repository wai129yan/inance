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

    <div class="col-md-4 ms-auto">
        <div class="d-flex flex-column flex-md-col  justify-content-around align-items-center py-5">
            <!-- Related Item 1 -->
            <div class="related-item text-center mb-4 mb-md-0">
                <img src="./customerPhotos/<?php $post['photo'] ?? 'dummy.png'?>" alt="Related 1" class="img-fluid rounded-circle" style="width: 100px; height: 100px;">
                <p class="mt-2"><strong>Related Job 1</strong> $<?= $price; ?></p>
                <p>$100</p>
            </div>

            <!-- Related Item 2 -->
            <div class="related-item text-center mb-4 mb-md-0">
                <img src="./customerPhotos/related2.jpg" alt="Related 2" class="img-fluid rounded-circle" style="width: 100px; height: 100px;">
                <p class="mt-2"><strong>Related Job 2</strong></p>
                <p>$150</p>
            </div>

            <!-- Related Item 3 -->
            <div class="related-item text-center">
                <img src="./customerPhotos/related3.jpg" alt="Related 3" class="img-fluid rounded-circle" style="width: 100px; height: 100px;">
                <p class="mt-2"><strong>Related Job 3</strong></p>
                <p>$200</p>
            </div>
        </div>
    </div>
</div>