<?php
// Using relative path
include("../database/db.php");

// Check if session variables are set
$auth = isset($_SESSION['name']);
$career = isset($_SESSION['career']);

// Check if technician ID is passed
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

// Fetch technician details
$query = "SELECT * FROM technicians WHERE TechnicianID = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $id, PDO::PARAM_STR);
$stmt->execute();
$technician = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch career details
if ($technician) {
    $career_id = $technician['career_id'];
    $query = "SELECT * FROM careeries WHERE career_id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $career_id, PDO::PARAM_STR);
    $stmt->execute();
    $career = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($_POST['profile_update'])) {
    // Initialize error array
    $errors = [];
    $success = [];

    // Retrieve form data
    $id = $_POST['id'];
    $name = $_POST['name'];
    $photo = $_FILES['photos']['name'];
    $tmpName = $_FILES['photos']['tmp_name'];
    $phone = $_POST['Phone'];
    $address = $_POST['Address'];

    // Validate inputs
    if (empty($name)) $errors[] = "Name is required";
    if (empty($address)) $errors[] = "Address is required";
    if (empty($phone)) $errors[] = "Phone number is required";

    // Handle file upload if a new photo is provided
    if (!empty($photo)) {
        // Validate file type and size (optional)
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!in_array($_FILES['photos']['type'], $allowedTypes)) {
            $errors[] = "Invalid file type. Only JPG, JPEG, and PNG are allowed.";
        }

        // Move uploaded file if no errors
        if (empty($errors)) {
            if (!move_uploaded_file($tmpName, "../images/technician/$photo")) {
                $errors[] = "Failed to upload photo.";
            }
        }
    } else {
        // If no new photo is uploaded, keep the existing one
        $photo = $_POST['existing_photo'];
    }

    // If no errors, proceed with database update
    if (count($errors) == 0) {
        // Prepare the update query
        $updateTech = "UPDATE technicians SET name = :name, photos = :photos, Phone = :phone, Address = :address WHERE TechnicianID = :id";
        $stmt = $pdo->prepare($updateTech);

        // Bind parameters
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':photos', $photo, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);

        // Execute the query and check for success
        if ($stmt->execute()) {
            $success[] = "Profile updated successfully";
            header("Location: profile.php?id=" . $id);
            exit();
        } else {
            // Handle database execution errors
            $errorInfo = $stmt->errorInfo();
            if (isset($errorInfo[2])) {
                $errors[] = "Database error: " . htmlspecialchars($errorInfo[2]);
            } else {
                $errors[] = "Failed to update profile due to an unknown error.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Technician Profile</title>
  <!-- Bootstrap 4.3 CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .profile-container {
      margin-top: 50px;
    }
    .profile-card {
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      padding: 20px;
      background-color: white;
    }
    .profile-photo {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      object-fit: cover;
      margin-bottom: 20px;
    }
    .section-title {
      font-size: 1.5rem;
      font-weight: bold;
      color: #333;
      margin-bottom: 20px;
    }
    .profile-info {
      font-size: 1rem;
      margin-bottom: 15px;
    }
    .btn-custom {
      background-color: #007bff;
      color: white;
      border-radius: 5px;
      padding: 10px 20px;
    }
    .btn-custom:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <div class="profile-container text-center ">
    <div class="profile">
      <h3 class="section-title">Technician Profile</h3>
      <!-- Profile Image -->
      <img src="../images/technician/<?= $technician['photos'] ?? 'client-1.jpg' ?>" alt="Technician Photo" class="profile-photo">
      <!-- Profile Info -->
      <p class="profile-info"><strong>Career ID:</strong> #<?= $technician['career_id'] ?? 'N/A' ?></p>
      <p class="profile-info"><strong>Tech Code:</strong> <?= $technician['techCode'] ?? 'N/A' ?></p>
      <div class="container rounded">
        <div class="shadow-lg p-3 mb-4 ">
          <div class="card-body d-flex flex-column justify-content-center">
            <p class="profile-info"><strong>Name:</strong> <?= $technician['name'] ?? '' ?></p>
            <p class="profile-info"><strong>Email:</strong> <?= $technician['email'] ?? '' ?></p>
            <p class="profile-info"><strong>Password:</strong> **********</p>
            <p class="profile-info"><strong>Phone:</strong> <?= $technician['Phone'] ?? '+123 456 7890' ?></p>
            <p class="profile-info"><strong>Address:</strong> <?= $technician['Address'] ?? 'N/A' ?></p>
            <p class="profile-info"><strong>Registration Date:</strong> <?= $technician['RegistrationDate'] ?? 'N/A' ?></p>
          </div>
        </div>
      </div>
      <div class="text-center mt-4">
        <button class="btn btn-custom" data-toggle="modal" data-target="#technician">Edit Profile</button>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="technician" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Technician Profile</h5>
        </div>
        <div class="modal-body">
          <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= htmlspecialchars($technician['TechnicianID']); ?>">
            <input type="hidden" name="existing_photo" value="<?= htmlspecialchars($technician['photos'] ?? ''); ?>">

            <div class="mb-3">
              <input type="text" name="name" value="<?= htmlspecialchars($technician['name'] ?? ''); ?>" class="form-control" placeholder="Name">
            </div>
            <div class="mb-3">
              <input type="email" name="email" value="<?= htmlspecialchars($technician['email'] ?? '') ?>" class="form-control" placeholder="Email">
            </div>
            <!-- <div class="mb-3">
              <input type="password" name="password" value="<= htmlspecialchars($technician['password'] ?? '') ?>" class="form-control" placeholder="Password" disabled>
            </div> -->
            <div class="mb-3">
              <label for="">Upload Photo</label>
              <img src="../images/technician/<?= htmlspecialchars($technician['photos'] ?? 'client-1.jpg'); ?>" alt="" width="150px">
              <input type="file" class="form-control" name="photos">
            </div>
            <div class="mb-3">
              <input type="text" name="Phone" value="<?= htmlspecialchars($technician['Phone'] ?? ''); ?>" class="form-control" placeholder="Phone">
            </div>
            <div class="mb-3">
              <textarea name="Address" class="form-control" placeholder="Address"><?= htmlspecialchars($technician['Address'] ?? ''); ?></textarea>
            </div>
            <input type="submit" class="btn btn-info" name="profile_update">
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap 4.3 JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
