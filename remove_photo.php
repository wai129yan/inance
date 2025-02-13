<?php
session_start();
include("./database/db.php");

header('Content-Type: application/json');

if (!isset($_SESSION['customer_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

if (!isset($_POST['photo']) || !isset($_POST['post_id'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required data']);
    exit();
}

$photo = $_POST['photo'];
$post_id = $_POST['post_id'];
$customer_id = $_SESSION['customer_id'];

try {
    // Get current photos
    $stmt = $pdo->prepare("SELECT photo FROM posts WHERE id = ? AND customer_id = ?");
    $stmt->execute([$post_id, $customer_id]);
    $result = $stmt->fetch();

    if (!$result) {
        echo json_encode(['success' => false, 'message' => 'Post not found']);
        exit();
    }

    $photos = json_decode($result['photo'], true);
    
    // Remove the specific photo
    $key = array_search($photo, $photos);
    if ($key !== false) {
        unset($photos[$key]);
        $photos = array_values($photos); // Reindex array
        
        // Delete physical file
        $file_path = "photos/" . $photo;
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        
        // Update database
        $stmt = $pdo->prepare("UPDATE posts SET photo = ? WHERE id = ? AND customer_id = ?");
        if ($stmt->execute([json_encode($photos), $post_id, $customer_id])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update database']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Photo not found in post']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Server error']);
}
?>
