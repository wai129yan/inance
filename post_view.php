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

$customerSql = "SELECT * FROM customers WHERE CustomerID = :customer_id";
$cus  = $pdo->prepare($customerSql);
$cus->bindParam(':customer_id', $_SESSION['customer_id'], PDO::PARAM_INT);
$cus->execute();
$currentCus = $cus->fetch();
// print_r($currentCus);


?>


<?php
include("./layout/header.php");
include("./layout/hero2.php");

?>

<section class="posts_section layout_padding" id="posts">
    <div class="container">
        <!-- <div class="heading_container text-center mb-4">
            <h2>
                <php if (isset($_SESSION['name'])): ?>
                    <php echo $_SESSION['name'] ?? 'ALL' ?>
                <php endif ?>   
                - Post
            </h2>
        </div> -->


        <div class="card" style="width:18rem">

            <img src="./customerPhotos/640px-Smiley.svg.png" class="object-fit-cover m-auto" alt="..." width="100" height="100">
            <div class="card-body">

                <h5 class="card-title">Name- <?= $currentCus['name'] ?> </h5>
                <h5 class="card-title">Email- <?= $currentCus['email'] ?> </h5>
                <h5 class="card-title">Phone- <?= $currentCus['phone'] ?> </h5>
                <p class="card-text">Address- <?= $currentCus['address'] ?> </p>
            </div>
            <a class="btn btn-success" data-toggle="modal" data-target="#customer">Edit</a>
        </div>
        <!-- Button trigger modal -- 

        <!-- Modal -->
        <div class="modal fade" id="customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="customer">Profile Edit Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="customerid" value="<?php echo $currentCus['CustomerID'] ?>">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input class="form-control" type="text" name="name" value="<?php echo $currentCus['name'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input class="form-control" type="email" name="email" value="<?php echo  $currentCus['email'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="phone">Phone</label>
                                <input class="form-control" type="text" name="phone" value="<?php echo  $currentCus['phone'] ?>">
                            </div>

                            <div id="imageContainer">
                                <img id="preview" style="display:none;" width="150" alt="Image Preview">
                            </div>

                            <div class="mb-3">
                                <label for="photo">Upload Photo</label>
                                <input type="file" class="form-control" name="photo" id="cusphoto">
                            </div>

                            <div class="mb-3">
                                <label for="address">Address</label>
                                <textarea name="address" class="form-control"><?php echo $currentCus['address'] ?></textarea>
                            </div>
                            <input type="submit" class="btn btn-info" name="customUpdate" value="Update">
                        </form>

                    </div>

                </div>
            </div>
        </div>














        <?php if (!empty($posts)): ?>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Content</th>
                        <th>Photos</th>
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
                                    $photos = json_decode($post['photo'], true) ?? [];
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
<script>
    // Get the file input element
    const fileInput = document.getElementById('cusphoto');

    // Get the image preview element
    const imagePreview = document.getElementById('preview');

    // Event listener for file input change
    fileInput.addEventListener('change', function() {
        // console.log(this.files);
        const file = this.files[0]; // Get the selected file

        if (file) {
            // Create a FileReader object
            const reader = new FileReader();
            // console.log(reader);
            // Define what happens when the file is loaded
            reader.onload = function() {
                // console.log(this.result);
                // Set the image src to the file URL
                imagePreview.src = this.result;

                // Show the image
                imagePreview.style.display = 'block';
            }

            // Read the file as a data URL (base64)
            reader.readAsDataURL(file);
        } else {
            // Hide the image if no file is selected
            imagePreview.style.display = 'none';
        }
    });
</script>