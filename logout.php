<?php
session_start();
unset($_SESSION['name']);
unset($_SESSION['career']);
unset($_SESSION['t_id']);
unset($_SESSION['user_id']);
session_destroy();
header("Location: index.php");
?>