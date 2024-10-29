<?php
require "database/db.php";

// 1. create query, 2.prepare($query) ,3.execute()

$now = new DateTime('now');
$now = $now->format('Y-m-d H:i:s');

// $sql = "INSERT INTO users (name,email,password,phone,photo,address,created_date,updated_date) VALUES(?,?,?,?,?,?,?,?)";
// $statement  = $pdo -> prepare($sql);
// // $statement->execute(['rose','rose22@gmail.com','23333','093433','aa.jpg','ygn',$now,$now]);
// $statement->execute(['rose', 'rosey@gmail.com', '23333', '093433', 'aa.jpg', 'ygn', $now, $now]);



$sql = "INSERT INTO users(name,email,password,phone,photo,address,created_date,updated_date) VALUES(:name,:email,:password,:phone,:photo,:address,:created_date,:updated_date)";
$statement = $pdo->prepare($sql);


// $name = "popo";
// $email = "aung@gmail.com";
// $password = "123456";
// $phone = "093433";
// $photo = "aa.jpg";
// $address = "ygn";
// $created_date = $now;
// $updated_date = $now;
// $statement = $pdo->prepare($sql);

$statement -> bindParam(':email',$email,PDO::PARAM_STR);
$statement -> bindParam(':phone',$phone,PDO::PARAM_STR);
$statement -> bindParam(':password',$password,PDO::PARAM_STR);
$statement -> bindParam(':photo',$photo,PDO::PARAM_STR);
$statement -> bindParam(':address',$address,PDO::PARAM_STR);
$statement -> bindParam(':created_date',$now,PDO::PARAM_STR);
$statement -> bindParam(':updated_date',$now,PDO::PARAM_STR);
$statement -> bindParam(':name',$name,PDO::PARAM_STR);

$statement -> execute();
















//Third
// $statement = $pdo->prepare($sql);
// $statement->bindValue(':name','popo');
// $statement->bindValue(':email','popo@gmail.com');
// $statement->bindValue(':password','123456');
// $statement->bindValue(':phone','093433');
// $statement->bindValue(':photo','aa.jpg');
// $statement->bindValue(':address','ygn');
// $statement->bindValue(':created_date',$now);
// $statement->bindValue(':updated_date',$now);
// $statement->execute();








// second 
// $statement -> execute ([
//     ':name' => "james",
//     ':password' => "123456",
//     ':email' => "james@gmail.com",
//     ':phone' => "093433",
//     ':photo' => "aa.jpg",
//     ':address' => "ygn",
//     ':created_date' => $now,
//     ':updated_date' => $now
// ]);


?>