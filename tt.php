<?php

// Configuration
$uploadDirectory = "uploads/"; // Directory to store uploaded files (relative to this script)
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif']; // Allowed file types
$maxFileSize = 204800; // Maximum file size in bytes (200KB)
$newFilename = uniqid('', true); // Generate unique name

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if a file was actually uploaded
    if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0) {

        $file = $_FILES["photo"];

        $filename = basename($file["name"]); // Get the original filename
        $fileType = $file["type"]; // Get the MIME type
        $fileSize = $file["size"]; // Get the file size
        $fileTmpName = $file["tmp_name"]; // Temporary location of the file

        // **VALIDATION**

        // 1. Check File Type
        if (!in_array($fileType, $allowedTypes)) {
            $error = "Error: Only JPEG, PNG, and GIF files are allowed.";
        }

        // 2. Check File Size
        if ($fileSize > $maxFileSize) {
            $error = "Error: File size cannot exceed 200KB.";
        }

        // 3. Check for upload errors (more robust)
        if ($file["error"] !== UPLOAD_ERR_OK) {
            $error = "Upload error: " . $file["error"]; // More specific error message
        }

        // If there are no errors, proceed with the upload
        if (empty($error)) {

            // Create the uploads directory if it doesn't exist
            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0777, true); // Creates nested directories
            }

             // Get the file extension
            $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);

            // Create a unique filename
            $targetFilename = $newFilename . "." . $fileExtension;

            // The full path to the uploaded file
            $targetPath = $uploadDirectory . $targetFilename;

            // Move the uploaded file to its final destination
            if (move_uploaded_file($fileTmpName, $targetPath)) {
                $success = "The file " . htmlspecialchars(basename($filename)) . " has been uploaded.";
                $uploadedFile = $targetPath; // Store path for later use (e.g., database)
            } else {
                $error = "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        $error = "Error: Please select a file to upload.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Photo Upload</title>
</head>
<body>

<?php if (isset($error)): ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php endif; ?>

<?php if (isset($success)): ?>
    <p style="color: green;"><?php echo $success; ?></p>
    <img src="<?php echo $uploadedFile; ?>" alt="Uploaded Image" style="max-width: 300px;">
<?php endif; ?>


<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="photo" id="photo">
    <input type="submit" value="Upload Image" name="submit">
</form>

</body>
</html>
