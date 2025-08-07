<?php
include './db/db.php';

$id = $_POST['id'];
$title = $_POST['title'];
$description = $_POST['description'];
$hours = $_POST['hours'];
$price = $_POST['price'];

$sql = "UPDATE courses SET title='$title', description='$description', hours='$hours', price='$price' WHERE id=$id";
mysqli_query($conn, $sql);
header("Location: courses.php");
exit();
