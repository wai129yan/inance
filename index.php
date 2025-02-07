<?php

require "database/db.php";
require "database/config.php";

$errors = [];
$success = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["submit"])) {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $sms = $_POST['message'];

    empty($name) ? $errors[]  = "Name Required" : "";
    empty($phone) ? $errors[]  = "Phone Required" : "";
    empty($email) ? $errors[]  = "Email Required" : "";
    empty($sms) ? $errors[] = "Message Required" : "";

    // if (empty($name) || empty($email) || empty($sms)) { // Removed undefined $subject
    //   echo "Please fill in all fields.";
    //   exit;
    // }


    !filter_var($email, FILTER_VALIDATE_EMAIL) ? $errors[] = "Invalid Email Format" : "";
    if (count($errors) == 0) {
      $sql = "INSERT INTO contact (name, phone, email, message) VALUES (:name, :phone, :email, :sms)";

      $stmt = $pdo->prepare($sql);

      $stmt->bindParam(':name', $name, PDO::PARAM_STR);
      $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
      $stmt->bindParam(':email', $email, PDO::PARAM_STR);
      $stmt->bindParam(':sms', $sms, PDO::PARAM_STR);
      $stmt->execute();
      if ($stmt->execute()) {
        $success[] = "Success";
      } else {
        $error[] = "Error message ";
      }
    }
  }
}



// // Validation: Check if the email format is valid
// if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//   echo "Invalid email format.";
//   exit; // Stop execution if the email is invalid
// }


// print_r($stmt);
// die();




?>


<?php
include "errors.php";
include "success.php";
include "layout/header.php";
include "layout/hero.php";


?>

<!-- feature section -->
<?php
include "section/feature.php";
include "section/job_offer.php";
include "section/customer_detail.php";
include "section/info.php";
include "section/contact.php";
include "section/about.php";
include "section/professional.php";
include "section/service.php";
include "section/techanical.php";
?>


<!-- end feature section -->

<!-- about section -->



<!-- end about section -->


<!-- professional section -->



<!-- end professional section -->

<!-- service section -->



<!-- end service section -->

<!-- client section -->



<!-- end client section -->

<!-- contact section -->



<!-- end contact section -->


<!-- info section -->




<!-- end info_section -->

<!-- footer section -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<?php
include "layout/footer.php";
?>