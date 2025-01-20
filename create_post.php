<?php
session_start();

include("./database/db.php");

$customer = isset($_SESSION['customer_id']);

$errors = [];
$success = [];

if (!$customer) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['create_post'])) {
    $customer_id = $_POST['CustomerID'];
    $title = $_POST['title'];
    $phone = $_POST['phone'];
    $content = $_POST['content'];
    $address = $_POST['address'];

    // $photos = $_FILES['photo']['name'];

    // $savedPhotos = []; // Array to store names for the database

    // foreach ($photos as $key => $photo) {
    //     $tmpname = $_FILES['photo']['tmp_name'][$key];
    //     $uniqueName = "photo_" . time() . "_" . $key . "_" . $photo; // Ensure uniqueness
    //     move_uploaded_file($tmpname, "photos/$uniqueName");
    //     $savedPhotos[] = $uniqueName; // Save the same name for database
    // }

    // // Save $savedPhotos to the database in JSON format
    // $json_data = json_encode($savedPhotos);


    $photos = $_FILES['photo']['name'];

    $savedPhotos = []; // Array to store valid photo names for the database
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp']; // Allowed file types

    foreach ($photos as $key => $photo) {
        $tmpname = $_FILES['photo']['tmp_name'][$key];
        $extension = strtolower(pathinfo($photo, PATHINFO_EXTENSION)); // Get file extension

        if (in_array($extension, $allowedExtensions)) {
            $uniqueName = "photo_" . time() . "_" . $key . "." . $extension; // Unique file name
            move_uploaded_file($tmpname, "photos/$uniqueName");
            $savedPhotos[] = $uniqueName; // Add valid photo name to the database array
        } else {
            // Optionally handle invalid files
            $errors[] = "Invalid file type: $photo. Only jpg, jpeg, png, and webp are allowed.<br>";
        }
    }

    $photoDB= json_encode($savedPhotos);


    // echo $photoNamesForDatabase;

    // echo $json_data;
    // die();

    // Validate inputs
    if (empty($customer_id)) {
        $errors[] = "Customer ID is required";
    }

    if (empty($title)) {
        $errors[] = "Title is required";
    }

    if (empty($phone)) {
        $errors[] = "Phone Number is required";
    }

    if (empty($content)) {
        $errors[] = "Content is required";
    }

    if (empty($address)) {
        $errors[] = "Address is required";
    }

    if (count($errors) == 0) {
        // Check if Customer ID exists
        $sql = "SELECT COUNT(*) FROM customers WHERE CustomerID = :customer_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetchColumn();



        if (!$count) {
            $errors[] = "Customer ID does not exist";
        } else {
            // Insert new post into the database
            $sql = "INSERT INTO posts (customer_id, title, phone, content, photo,address) 
                    VALUES (:customer_id, :title, :phone, :content, :photo,:address)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':customer_id', $customer_id);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':photo', $photoDB);
            $stmt->bindParam(':address', $address);

            if ($stmt->execute()) {
                $success[] = "Post created successfully!";
            } else {
                $errors[] = "An error occurred while creating the post";
            }
        }
    }
}
?>

<?php include("./layout/header.php"); ?>

<section class="contact_section layout_padding" id="contact">
    <div class="container">
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

        <div class="row justify-content-center">
            <div class="col-md-6 px-4 py-4 shadow rounded-lg bg-light">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="heading_container text-center mb-4">
                        <h2>Create Post</h2>
                    </div>

                    <!-- Customer ID Field -->
                    <!-- <div class="mb-3">
                        <label for="CustomerID" class="form-label">Customer ID</label>
                        <input type="number" name="CustomerID" class="form-control" placeholder="Customer ID" required />
                    </div> -->
                    <input type="hidden" name="CustomerID" value=<?= $_SESSION['customer_id'] ?>>

                    <!-- Title Field -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" placeholder="Enter your Title" required />
                    </div>

                    <!-- Phone Number Field -->
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number<span class="text-danger">*</span></label>
                        <input type="text" name="phone" class="form-control" placeholder="Enter your phone number" required />
                    </div>

                    <div class="mb-3">
                        <label for="photo" class="form-label">Photo</label>
                        <input type="file" class="form-control" accept="image/*" multiple name="photo[]">
                    </div>

                    <!-- Content Field -->
                    <div class="mb-3">
                        <label for="content" class="form-label">Description</label>
                        <textarea name="content" class="form-control" placeholder="Enter Your Content" rows="3"></textarea>
                    </div>

                    <!-- Address Field -->
                    <div class="mb-3">
                        <label for="address" class="form-label">Address<span class="text-danger">*</span></label>
                        <textarea name="address" class="form-control" placeholder="Enter Your Address" rows="3"></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12 text-center mt-3">
                        <input type="submit" name="create_post" value="Create Post" class="btn btn-success">
                    </div>

                    <!-- Back Link -->
                    <div class="text-center mt-3">
                        <a href="login.php">Already have an account? Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>