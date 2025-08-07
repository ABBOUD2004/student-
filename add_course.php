<?php
session_start();
if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit();
}
include './navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Course</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #ffecd2, #fcb69f);
            font-family: 'Segoe UI', sans-serif;
        }

        .form-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }

        label i {
            color: #0d6efd;
            margin-right: 6px;
        }

        .btn-primary {
            background: linear-gradient(45deg, #0d6efd, #007bff);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, #0b5ed7, #0069d9);
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 90vh;">
    <div class="col-md-8 col-lg-6 form-card">
        <h2 class="text-center mb-4">📘 Add New Course</h2>

        <form action="insert_course.php" method="POST">
            
            <div class="mb-3">
                <label><i class="bi bi-book-fill"></i>Title</label>
                <input type="text" name="title" class="form-control" placeholder="Course Title" required>
            </div>

            
            <div class="mb-3">
                <label><i class="bi bi-chat-left-dots-fill"></i>Description</label>
                <textarea name="description" class="form-control" rows="3" placeholder="Brief course description..."></textarea>
            </div>

            
            <div class="mb-3">
                <label><i class="bi bi-clock-history"></i>Hours</label>
                <input type="number" name="hours" class="form-control" placeholder="Number of hours" required>
            </div>

          
            <div class="mb-3">
                <label><i class="bi bi-cash-coin"></i>Price</label>
                <input type="text" name="price" class="form-control" placeholder="e.g. 499 EGP" required>
            </div>

            
            <div class="text-end">
                <button type="submit" class="btn btn-primary px-4">Add</button>
                <a href="courses.php" class="btn btn-outline-secondary ms-2">Back</a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
