<?php
$pdo = new PDO("mysql:host=localhost;dbname=training_system", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$pdo->prepare("DELETE FROM users WHERE username = 'admin'")->execute();


$username = "admin";
$password = "123456";
$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->execute([$username, $hash]);

echo " User 'admin' added with password '123456'";
