<?php

require "database/db.php";
require "database/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["submit"]) ){
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $sms = $_POST['message'];

    // Validation: Ensure no fields are empty
    if (empty($name) || empty($email) || empty($sms)) { // Removed undefined $subject
        echo "Please fill in all fields.";
        exit;
    }

    // Validation: Check if the email format is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit; // Stop execution if the email is invalid
    }

    
    $sql = "INSERT INTO contact (name, phone, email, message) VALUES (:name, :phone, :email, :sms)";

    
    $stmt = $pdo->prepare($sql);

    
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':sms', $sms, PDO::PARAM_STR);

    // print_r($stmt);
    // die();

    $stmt->execute();
    if ($stmt->execute()) {
        echo "Data sent successfully.";
    } else {
        echo "Error sending message.";
    }
}
}


?>

<section class="contact_section layout_padding">
    <div class="container">
        <div class="heading_container">
            <h2>Contact Us</h2>
        </div>
        <div class="row">
            <div class="col-md-6">
                <form action="contact.php" method="post">
                    <div>
                        <input type="text" name="name" placeholder="Name" required />
                    </div>
                    <div>
                        <input type="text" name="phone" placeholder="Phone Number" required />
                    </div>
                    <div>
                        <input type="email" name="email" placeholder="Email" required />
                    </div>
                    <div>
                        <input type="text" name="message" class="message-box" placeholder="Message" required />
                    </div>
                    <div class="d-flex">
                        <button type="submit" name="submit">SEND</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <div class="map_container">
                    <div class="map">
                        <div id="googleMap" style="width:100%;height:100%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>