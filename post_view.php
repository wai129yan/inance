<?php
session_start();

include("./database/db.php");

$customer = isset($_SESSION['customer_id']);

if (!$customer) {
    header("Location: login.php");
    exit();
}

$posts = [];

// Fetch posts for the logged-in customer
$sql = "SELECT * FROM posts WHERE customer_id = :customer_id ORDER BY created_at DESC"; // Assuming 'created_at' is the timestamp column
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':customer_id', $_SESSION['customer_id'], PDO::PARAM_INT);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include("./layout/header.php"); ?>

<section class="posts_section layout_padding" id="posts">
    <div class="container">
        <div class="heading_container text-center mb-4">
            <h2>
                <?= isset($customers['name']) ? htmlspecialchars($customers['name']) : ' '; ?> - Post
            </h2>
        </div>

        <?php if (!empty($posts)): ?>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Content</th>
                        <th >Photos</th>
                        <th style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $post): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($post['title']); ?></td>
                            <td><?php echo htmlspecialchars($post['phone']); ?></td>
                            <td><?php echo htmlspecialchars($post['address']); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($post['content'])); ?></td>
                            <td>
                                <?php if (!empty($post['photo'])): ?>
                                    <?php
                                    $photos = json_decode($post['photo'], true);
                                    foreach ($photos as $photo): ?>
                                        <img src="photos/<?php echo htmlspecialchars($photo); ?>" alt="Post Photo" class="img-thumbnail" style="max-width: 100px; height: auto;">
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    No photos
                                <?php endif; ?>
                            </td>
                            <td>
                                <!-- Example of Edit and Delete actions -->
                                <a href="edit_post.php?id=<?php echo $post['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                <a href="delete_post.php?id=<?php echo $post['id']; ?>" class="btn btn-danger btn-sm swl-delete">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>You have not created any posts yet.</p>
        <?php endif; ?>
    </div>
</section>

<?php include("./layout/footer.php"); ?>