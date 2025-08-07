<?php
session_start();
if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #dae2f8, #d6a4a4);
            font-family: 'Segoe UI', sans-serif;
        }

        .form-card {
            background: rgba(255, 255, 255, 0.85);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }

        .form-card h2 {
            font-weight: bold;
            color: #333;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .btn-primary {
            background: linear-gradient(45deg, #007bff, #00c6ff);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, #0056b3, #0096c7);
        }

        label i {
            margin-right: 5px;
            color: #0d6efd;
        }
    </style>
</head>

<body>
<?php include 'navbar.php'; ?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 90vh;">
    <div class="col-md-8 col-lg-6 form-card">
        <h2 class="mb-4 text-center">🧑‍🎓 Add New Student</h2>
        <form action="insert_student.php" method="POST">
            <div class="mb-3">
                <label><i class="bi bi-person-fill"></i>Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter full name" required>
            </div>
            <div class="mb-3">
                <label><i class="bi bi-envelope-fill"></i>Email</label>
                <input type="email" name="email" class="form-control" placeholder="example@mail.com" required>
            </div>
            <div class="mb-3">
                <label><i class="bi bi-telephone-fill"></i>Phone</label>
                <input type="text" name="phone" class="form-control" placeholder="01xxxxxxxxx" required>
            </div>
            <div class="mb-3">
                <label><i class="bi bi-calendar2-week-fill"></i>Date of Birth</label>
                <input type="date" name="dob" class="form-control" required>
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary px-4">Save</button>
                <a href="index.php" class="btn btn-secondary px-4">Back</a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
