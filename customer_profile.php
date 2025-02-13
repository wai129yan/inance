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

if (isset($_POST['customUpdate'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $price = $_POST['price'];
    $address = $_POST['address'];
    $customerid = $_POST['customerid'];

    $photo = $_FILES['photo']['name'] ?? [];
    $tmpname = $_FILES['photo']['tmp_name'];
    $extension = strtolower(pathinfo($photo, PATHINFO_EXTENSION));
    $uniqueName = "photo_" . time() . "." . $extension;
    move_uploaded_file($tmpname, "customerPhotos/$uniqueName");

    $sql = "UPDATE customers SET name = :name, email = :email, phone = :phone, price = :price, address = :address, photo = :photo WHERE CustomerID = :customerid";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':photo', $uniqueName);
    $stmt->bindParam(':customerid', $customerid);

    if ($stmt->execute()) {
        $success[] = "Customer updated successfully!";
        header("Location:post_view.php");
    } else {
        $errors[] = "An error occurred while updating the customer";
    }
}

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


        <div class="card" style="min-width:18rem ; max-width:20rem">

            <img src="./customerPhotos/<?php echo $currentCus['photo'] ?? 'dummy.png' ?>" class="object-fit-cover m-auto rounded-circle" alt="..." width="100" height="100" style="transform:translateY(-50%)" ;>
            <div class="card-body" style="margin-top:-60px" ;>

                <h5 class="card-title">Name- <?= $currentCus['name'] ?> </h5>
                <h5 class="card-title">Email- <?= $currentCus['email'] ?> </h5>
                <h5 class="card-title">Phone- <?= $currentCus['phone'] ?> </h5>
                <p class="card-text">Address- <?= $currentCus['address'] ?> </p>
            </div>
            <a class="btn btn-success" data-toggle="modal" data-target="#customer">Edit</a>
        </div>

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

                            <div class="mb-3">
                                <label for="price">Price</label>
                                <input class="form-control" type="text" name="price" value="<?php echo  $currentCus['price'] ?>">
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
            <table class="table table-striped table-bordered m-3" id="posts-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Phone</th>
                        <th>Price</th>
                        <th>Address</th>
                        <th>Content</th>
                        <th>Photos</th>
                        <th style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $post): ?>
                        <tr>
                            <td>
                                <?php
                                // Limit title to 20 characters
                                $maxLength = 20; // Maximum length for the truncated title
                                $title = htmlspecialchars($post['title']); // Sanitize the title
                                $limitedTitle = substr($title, 0, $maxLength); // Truncate the title to 20 characters

                                // Add an ellipsis (...) if the title exceeds the max length
                                if (strlen($title) > $maxLength) {
                                    $limitedTitle .= '...'; // Append ellipsis for truncated titles
                                }

                                echo $limitedTitle; // Display the truncated title

                                // If the title exceeds the max length, show a "Details" link
                                if (strlen($title) > $maxLength): ?>
                                    <br><a href="edit_post.php?id=<?php echo $post['id']; ?>" class="btn btn-link">Details</a>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($post['phone']); ?></td>
                            <td><?php echo htmlspecialchars($post['price']); ?></td>
                            <td><?php echo htmlspecialchars($post['address']); ?></td>
                            <td>
                                <?php
                                // Limit content to 20 words
                                $words = explode(' ', strip_tags($post['content'])); // Remove HTML tags and split by spaces
                                $limitedContent = implode(' ', array_slice($words, 0, 10)); // Get the first 20 words
                                echo nl2br(htmlspecialchars($limitedContent)); // Display the truncated content

                                // If the content has more than 20 words, show a "Details" link
                                if (count($words) > 10): ?>
                                    <br><a href="edit_post.php?id=<?php echo $post['id']; ?>" class="btn btn-link">Details</a>
                                <?php endif; ?>
                            </td>
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

<script>
    $(document).ready(function() {
        $('#posts-table').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true
        });
    });
</script>

<!-- <php
// Sample array
$array = [
    ['Name', 'Age', 'Location'],
    ['Alice', 30, 'New York'],
    ['Bob', 25, 'Los Angeles'],
    ['Charlie', 35, 'Chicago']
];

// Open a file in write mode (this will create or overwrite the file)
$file = fopen('output.csv', 'w');

// Check if the file was opened successfully
if ($file === false) {
    die('Error opening the file');
}

// Loop through the array and write each row to the CSV file
foreach ($array as $row) {
    fputcsv($file, $row); // Writes the row to the CSV file
}

// Close the file after writing
fclose($file);

echo 'CSV file created successfully!';
> -->