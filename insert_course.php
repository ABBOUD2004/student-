<?php
include './db/db.php';

$title = $_POST['title'];
$description = $_POST['description'];
$hours = $_POST['hours'];
$price = $_POST['price'];

$sql = "INSERT INTO courses (title, description, hours, price) 
        VALUES ('$title', '$description', '$hours', '$price')";

mysqli_query($conn, $sql);
header("Location: courses.php");
exit();
