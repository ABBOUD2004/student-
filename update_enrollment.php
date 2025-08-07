<?php
include './db/db.php';

$id = $_POST['id'];
$student_id = $_POST['student_id'];
$course_id = $_POST['course_id'];
$grade = $_POST['grade'];
$enrollment_date = $_POST['enrollment_date'];

$sql = "UPDATE enrollments SET 
        student_id='$student_id',
        course_id='$course_id',
        grade='$grade',
        enrollment_date='$enrollment_date'
        WHERE id=$id";

mysqli_query($conn, $sql);
header("Location: enrollments.php");
