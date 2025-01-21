<?php

session_start();
include("./database/db.php");


if (!isset($_SESSION['CustomerID'])) {
    header("Location: login.php");
    exit();
}

// Check if the post ID is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

// Get the post ID from the URL
$postId = intval($_GET['id']);
$customerId = $_SESSION['customer_id'];

// Step 1: Fetch the post to verify ownership
$sql = "SELECT * FROM posts WHERE id = :post_id AND customer_id = :customer_id";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':post_id' => $postId,
    ':customer_id' => $customerId
]);
$post = $stmt->fetch();

if (!$post) {
    // Redirect if the post does not exist or belongs to another user
    header("Location: index.php");
    exit();
}

// Step 2: Delete any associated photos
if (!empty($post['photo'])) {
    $photos = json_decode($post['photo'], true);
    foreach ($photos as $photo) {
        $photoPath = "./photos/" . $photo;
        if (file_exists($photoPath)) {
            unlink($photoPath); // Delete the file
        }
    }
}

// Step 3: Delete the post from the database
$deleteSql = "DELETE FROM posts WHERE id = :post_id";
$deleteStmt = $pdo->prepare($deleteSql);
$deleteStmt->execute([':post_id' => $postId]);

// Redirect back with a success message
header("Location: index.php?message=Post deleted successfully");
exit();
?>
