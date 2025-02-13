<?php
// Include database connection
include("./database/db.php"); // Replace with your actual config file

// Get the post ID from the query parameter
$postId = $_GET['id'] ?? null;
$TechnicianID = isset($_GET['TechnicianID']) ? (int)$_GET['TechnicianID'] : 0;

if ($postId) {

    $sql = "SELECT * FROM posts WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $postId, PDO::PARAM_INT);
    $stmt->execute();
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($posts) {

        $post = $posts[0];

        $title = $post['title'];
        $content = $post['content'];
        $price = $post['price'];
        $photo = $post['photo'];

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
    <div class="col-md-8" >
    <section class="job-detail py-5">
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="card shadow-lg rounded-lg" style="max-width: 600px; width: 100%;">
            <!-- Display the image if exists, otherwise show a default image -->
            <?php
            $photos = json_decode($post['photo']);
            $photoToShow = !empty($photos) ? $photos[0] : 'dummy.png';
            ?>
            <img src="./photos/<?= htmlspecialchars($photoToShow); ?>" alt="photo" style="min-width: 500px; width: 100%; ">

            <div class="card-body bg-light p-4 shadow-md"  style="min-height: auto;  ">
                <h3 class="card-title text-center mb-3"><?= $title; ?></h3>
                <p class="card-text text-center mt-4">
                    <strong>Content: </strong> <?= $content; ?>
                </p>
                <p class="card-text text-center">
                    <strong>Price: </strong> $<?= number_format($price, 2); ?>
                </p>
                <div class="text-center mt-4">
                    <a href="index.php" class="btn btn-primary btn-lg px-4 py-2">Back to Jobs</a>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    /* .card {
        border: none;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
       
    }
    .card-title {
        font-size: 1.75rem;
        color: #333;
    }
    .card-text {
        font-size: 1.1rem;
        color: #555;
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        transition: background-color 0.3s, border-color 0.3s;
    }
    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    } */
</style>
    </div>


    <div class="col-md-4">
    <div class="py-2">
        <h3 class="mb-4 text-center">Related Posts</h3>
        <div class="d-flex flex-column align-items-center" style="gap: 15px; min-height: 100vh; ">
            <?php
            $relatedSql = "SELECT * FROM posts WHERE id != :id ORDER BY RAND() LIMIT 3";
            $relatedStmt = $pdo->prepare($relatedSql);
            $relatedStmt->bindParam(':id', $postId, PDO::PARAM_INT);
            $relatedStmt->execute();
            $relatedPosts = $relatedStmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($relatedPosts as $relatedPost) {
                $photos = json_decode($relatedPost['photo']); // Use $relatedPost instead of $post
                $photoToShow = !empty($photos) ? $photos[0] : 'dummy.png';
            ?>
                <div class="card text-center shadow-lg" style="width: 50%; max-width: 250px; border-radius: 5px; object-fit: cover;  object-position: center;">
                    <img src="./photos/<?= htmlspecialchars($photoToShow); ?>"
                         class="card-img-top"
                         alt="photo"
                         style="height: 150px; object-fit: cover; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                    <div class="card-body">
                        <h6 class="card-title font-weight-bold text-primary " style="font-size: 1.25rem;"><?= strlen($relatedPost['title']) > 20 ? substr($relatedPost['title'], 0, 20) . '...' : $relatedPost['title']; ?></h6>
                        <p class="card-text text-success">$<?= htmlspecialchars($relatedPost['price']); ?></p>
                        <a href="job_detail.php?id=<?= $relatedPost['id'] ?>" class="btn btn-sm btn-primary">View Details</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
</div>






<!-- technicians  -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
<div class="row">
    <div class="col-md-12"> <!-- Changed to proper Bootstrap column class -->
        <?php

        $sqlTech = "SELECT * FROM technicians WHERE TechnicianID != :TechnicianID ORDER BY RAND() LIMIT 3";
        $res = $pdo->prepare($sqlTech);
        $res->bindValue(':TechnicianID', $TechnicianID, PDO::PARAM_INT);
        $res->execute();

        // Remove debug statements to allow fetching results
        // print_r($res);
        // die("hhh");

        $technicians = $res->fetchAll(PDO::FETCH_ASSOC);

        ?>

        <div class="row">
            <?php if (!empty($technicians)): ?>
                <?php foreach ($technicians as $technician): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-80 shadow-hover" style="transition: all 0.3s ease; border-radius: 15px;">
                            <?php if (!empty($technician['photos'])): ?>
                                <img src="<?= htmlspecialchars($technician['photos']) ?>"
                                    class="card-img-top rounded-top"
                                    alt="<?= htmlspecialchars($technician['name'] ?? 'Technician') ?>"
                                    style="height: 20px; object-fit: cover;">
                            <?php endif; ?>

                            <div class="card-body p-3">
                                <div class="mb-3">
                                    <h5 class="card-title mb-0 text-primary font-weight-bold">
                                        <?= htmlspecialchars($technician['name']) ?>
                                    </h5>
                                    <small class="text-muted"><?= htmlspecialchars($technician['techCode']) ?></small>
                                </div>

                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-envelope text-muted mr-2"></i>
                                    <p class="card-text mb-0 small"><?= htmlspecialchars($technician['email']) ?></p>
                                </div>

                                <div class="d-flex align-items-center mb-4">
                                    <i class="fas fa-phone text-muted mr-2"></i>
                                    <p class="card-text mb-0 small"><?= htmlspecialchars($technician['Phone']) ?></p>
                                </div>

                                <div class="border-top pt-3">
                                    <a href="profile/profile.php?= $technician['TechnicianID'] ?>"
                                        class="btn btn-primary btn-block rounded-pill py-2"
                                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                                        View Profile <i class="fas fa-arrow-right ml-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info shadow-sm">No other technicians found.</div>
                </div>
            <?php endif; ?>
        </div>

        <style>
            .shadow-hover {
                box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
                transition: all 0.3s ease;
            }

            .shadow-hover:hover {
                transform: translateY(-5px);
                box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
            }

            .card {
                border: 1px solid rgba(0, 0, 0, 0.1);
                /* overflow: hidden; */
            }

            .btn-primary {
                transition: all 0.3s ease;
            }

            .btn-primary:hover {
                transform: translateX(-17px);
            }
        </style>
    </div>
</div>