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
<!-- Add DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">

<style>
    .d-flex.gap-1 {
        gap: 0.25rem !important;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        line-height: 1.5;
    }

    .btn-outline-primary,
    .btn-outline-danger {
        border-width: 1px;
        transition: all 0.2s ease-in-out;
    }

    .btn-outline-primary:hover,
    .btn-outline-danger:hover {
        transform: translateY(-1px);
    }

    .fas {
        font-size: 0.875rem;
    }
</style>

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


        <div class="card mb-5" style="min-width:18rem ; max-width:20rem">

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
            <div class="table-responsive">
                <table id="postsTable" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Phone</th>
                            <th>Price</th>
                            <th>Address</th>
                            <th>Content</th>
                            <th>Photos</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($posts as $post): ?>
                            <tr>
                                <td><?php
                                    $title = htmlspecialchars($post['title']);
                                    echo (strlen($title) > 15) ? substr($title, 0, 15) . '...' : $title;
                                    ?></td>
                                <td><?php echo htmlspecialchars($post['phone']); ?></td>
                                <td>$<?php echo number_format($post['price'], 2); ?></td>
                                <td><?php
                                    $address = htmlspecialchars($post['address']);
                                    echo (strlen($address) > 15) ? substr($address, 0, 15) . '...' : $address;
                                    ?></td>
                                <td><?php
                                    $content = strip_tags($post['content']);
                                    $words = str_word_count($content, 1);
                                    if (count($words) > 15) {
                                        $limitedWords = array_slice($words, 0, 15);
                                        echo htmlspecialchars(implode(' ', $limitedWords)) . '...';
                                    } else {
                                        echo htmlspecialchars($content);
                                    }
                                    ?></td>
                                <td class="text-center">
                                    <?php if (!empty($post['photo'])): ?>
                                        <?php
                                        $photos = json_decode($post['photo'], true) ?? [];
                                        $count = 0;
                                        foreach ($photos as $photo): ?>
                                            <?php if ($count % 2 == 0): ?>
                                                <div class="row">
                                                <?php endif; ?>
                                                <div class="col">
                                                    <img src="photos/<?php echo htmlspecialchars($photo); ?>" alt="Post Photo" class="img-thumbnail" style="width: 250px;margin:
                                                    2px;">
                                                </div>
                                                <?php if ($count % 2 == 1): ?>
                                                </div>
                                            <?php endif; ?>
                                            <?php $count++; ?>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <span class="text-muted">No photos</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="edit_post.php?id=<?php echo $post['id']; ?>"
                                            class="btn btn-sm btn-outline-primary d-inline-flex align-items-center">
                                            Edit
                                        </a>
                                        <a href="delete_post.php?id=<?php echo $post['id']; ?>"
                                            class="btn btn-sm btn-outline-danger d-inline-flex align-items-center swl-delete">
                                            Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-muted">You have not created any posts yet.</p>
        <?php endif; ?>
    </div>
</section>

<?php include("./layout/footer.php"); ?>
<!-- Add DataTables JS -->
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>

<!-- Initialize DataTable -->
<script>
    $(document).ready(function() {
        $('#postsTable').DataTable({
            responsive: true,
            pageLength: 10,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search posts...",
                lengthMenu: "_MENU_ posts per page",
                info: "Showing _START_ to _END_ of _TOTAL_ posts",
                infoEmpty: "No posts available",
                infoFiltered: "(filtered from _MAX_ total posts)",
                zeroRecords: "No matching posts found"
            },
            columnDefs: [{
                    className: "text-center",
                    targets: [1, 2, 5, 6]
                },
                {
                    className: "text-right",
                    targets: [2]
                },
                {
                    orderable: false,
                    targets: [5, 6]
                }
            ],
            order: [
                [0, 'asc']
            ],
            autoWidth: false,
            scrollX: true,
            scrollY: '50vh',
            scrollCollapse: true,
            fixedHeader: true
        });

        // Add custom styling to DataTables elements
        $('.dataTables_wrapper .dataTables_filter input').addClass('form-control form-control-sm');
        $('.dataTables_wrapper .dataTables_length select').addClass('form-control form-control-sm');
    });
</script>

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