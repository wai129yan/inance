<?php
session_start();

include("./database/db.php");

$customer = isset($_SESSION['customer_id']);

if (!$customer) {
    header("Location: login.php");
    exit();
}

$post_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$errors = [];
$success = [];
$post = [];

// Fetch the post to edit
$sql = "SELECT * FROM posts WHERE id = :id AND customer_id = :customer_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $post_id, PDO::PARAM_INT);
$stmt->bindParam(':customer_id', $_SESSION['customer_id'], PDO::PARAM_INT);
$stmt->execute();
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    $errors[] = "Post not found or you don't have permission to edit it.";
}

if (isset($_POST['update'])) {
    $title = $_POST['title'];
    $phone = $_POST['phone'];
    $content = $_POST['content'];
    $price = $_POST['price'];
    $address = $_POST['address'];
    $new_photos = $_FILES['photo']['name'] ?? [];

    $savedPhotos = !empty($post['photo']) ? json_decode($post['photo'], true) : [];
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];

    // Process new photos
    if (!empty($new_photos)) {
        foreach ($new_photos as $key => $photo) {
            $tmpname = $_FILES['photo']['tmp_name'][$key];
            $extension = strtolower(pathinfo($photo, PATHINFO_EXTENSION));

            if (in_array($extension, $allowedExtensions)) {
                $uniqueName = "photo_" . time() . "_" . $key . "." . $extension;
                move_uploaded_file($tmpname, "photos/$uniqueName");
                $savedPhotos[] = $uniqueName;
                // } else {
                //     $errors[] = "Invalid file type: $photo. Only jpg, jpeg, png, and webp are allowed.";
                // }
            }
        }
    }

    $photoDB = json_encode($savedPhotos);

    // Validate inputs
    if (empty($title)) $errors[] = "Title is required.";
    if (empty($phone)) $errors[] = "Phone number is required.";
    if (empty($content)) $errors[] = "Content is required.";
    if (empty($price)) $errors[] = "Price is required.";
    if (empty($address)) $errors[] = "Address is required.";

    if (empty($errors)) {
        // Update the post in the database
        $sql = "UPDATE posts SET title = :title, phone = :phone, content = :content, price = :price, photo = :photo, address = :address WHERE id = :id AND customer_id = :customer_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':photo', $photoDB);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':id', $post_id);
        $stmt->bindParam(':customer_id', $_SESSION['customer_id']);

        if ($stmt->execute()) {
            $success[] = "Post updated successfully.";
            header("Location:customer_profile.php"); // 
        } else {
            $errors[] = "Error updating post.";
        }
    }
}

include './layout/header.php';
?>

<?php include("./layout/header.php"); ?>

<section class="edit_post_section layout_padding" id="edit_post">
    <div class="container">
        <div class="heading_container text-center mb-4">
            <h2>Edit Post</h2>
        </div>

        <?php
        include 'success.php';
        include 'errors.php';
        ?>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success">
                <ul>
                    <?php foreach ($success as $msg): ?>
                        <li><?php echo htmlspecialchars($msg); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ($post): ?>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($post['title']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($post['phone']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="photo" class="form-label">Photos</label>
                    <input type="file" class="form-control" name="photo[]" accept="image/*" multiple>
                    <?php if (!empty($post['photo'])): ?>
                        <?php
                        $photos = json_decode($post['photo'], true);
                        echo '<div class="row">';
                        foreach ($photos as $photo): ?>
                            <div class="col-4 m-2">
                                <div class="position-relative d-inline-block mb-2">
                                    <!-- Photo -->
                                    <img src="photos/<?php echo htmlspecialchars($photo); ?>" alt="Post Photo" class="img-thumbnail" style="max-width: 250px; height:150px;">

                                    <!-- Delete Button -->
                                    <button type="button" class="btn btn-danger  remove-photo" data-photo="<?php echo htmlspecialchars($photo); ?>">
                                        ×
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                </div>
            <?php endif; ?>
    </div>


    <div class="mb-3">
        <label for="content" class="form-label">Content</label>
        <textarea name="content" class="form-control" rows="3"><?php echo htmlspecialchars($post['content']); ?></textarea>
    </div>

    <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="text" name="price" class="form-control" value="<?php echo htmlspecialchars($post['price']); ?>" required>
    </div>

    <div class="mb-3">
        <label for="address" class="form-label">Address</label>
        <textarea name="address" class="form-control" rows="3"><?php echo htmlspecialchars($post['address']); ?></textarea>
    </div>

    <div class="text-center">
        <input type="submit" name="update" class="btn btn-primary" value="Update Post">
    </div>
    </form>
<?php endif; ?>
</div>
</section>

<?php include("./layout/footer.php"); ?>

<script>
    $(document).ready(function() {
        $('.remove-photo').on('click', function() {
            var button = $(this);
            var photoContainer = button.closest('.col-4');
            var photo = button.data('photo');

            $.ajax({
                url: 'remove_photo.php',
                type: 'POST',
                data: {
                    photo: photo,
                    post_id: <?php echo $post_id; ?>
                },
                success: function(response) {
                    if (response.success) {
                        // Immediately remove the photo container
                        photoContainer.fadeOut(200, function() {
                            $(this).remove();
                        });
                    } else {
                        alert(response.message || 'Failed to delete photo');
                    }
                },
                error: function() {
                    alert('Error occurred while deleting the photo');
                }
            });
        });
    });
</script>