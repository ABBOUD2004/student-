<?php

$pdo = new PDO("mysql:host=localhost;dbname=login_system", "root", "");


$username = "admin";
$plainPassword = "123456";


$hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);


$stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->execute([$username, $hashedPassword]);

echo "User added successfully.";
?>
