<?php
require "config.php";

$dsn = "mysql:host=$host;dbname=$dbname;charset=UTF8mb4";

try{
    $pdo = new PDO($dsn,$user,$pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    // if ($pdo) {
    //     echo "db connect";
    // }
}catch(PDOException $e){
    echo $e->getMessage();
}


?>