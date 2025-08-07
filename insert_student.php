<?php
include './db/db.php';

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$dob = $_POST['dob'];

$sql = "INSERT INTO students (name, email, phone, dob) VALUES ('$name', '$email', '$phone', '$dob')";
mysqli_query($conn, $sql);

header("Location: index.php");
exit();
