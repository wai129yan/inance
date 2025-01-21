<?php
session_start();

include("./database/db.php");

$errors = [];
$success = [];

// Check if the user is logged in
if (!isset($_SESSION['name'])) {
    header("Location: login.php");
    exit();
}

// Validate the `id` parameter passed via GET
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error_message'] = "Invalid post ID.";
    header("Location: posts.php");
    exit();
}

$postId = intval($_GET['id']);

// Verify that the post belongs to the logged-in customer
$sql = "DELETE FROM posts WHERE id = :post_id AND customer_id = :customer_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':post_id', $postId, PDO::PARAM_INT);
$stmt->bindParam(':customer_id', $_SESSION['customer_id'], PDO::PARAM_INT);

// Attempt to execute the query
if ($stmt->execute() && $stmt->rowCount() > 0) {
    $_SESSION['success_message'] = "Post deleted successfully!";
} else {
    $_SESSION['error_message'] = "Failed to delete the post. It may not exist or does not belong to you.";
}

// Redirect back to the posts page
header("Location: posts.php");
exit();
