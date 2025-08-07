<?php
session_start();
if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit();
}
include './db/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #2c3e50, #4ca1af);
            background-size: 300% 300%;
            animation: bgAnimation 20s ease infinite;
            font-family: 'Segoe UI', sans-serif;
            color: #fff;
        }

        @keyframes bgAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .container {
            margin-top: 60px;
            background-color: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.3);
        }

        .card {
            background: rgba(255, 255, 255, 0.08);
            border: none;
            border-radius: 16px;
            backdrop-filter: blur(6px);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            color: white;
        }

        .card:hover {
            transform: scale(1.02);
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.15);
        }

        h2 {
            text-align: center;
            margin-bottom: 40px;
            text-shadow: 0 0 10px rgba(255,255,255,0.3);
        }

        .btn {
            border-radius: 12px;
            font-weight: 500;
        }

        .card-title {
            font-weight: bold;
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container">
    <h2>🛠️ Admin Panel</h2>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card p-4 shadow-sm border-start border-primary border-5">
                <h5 class="card-title">👨‍🎓 Manage Students</h5>
                <p class="card-text">View and manage student records.</p>
                <a href="students.php" class="btn btn-outline-primary w-100">Go to Students</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 shadow-sm border-start border-success border-5">
                <h5 class="card-title">📚 Manage Courses</h5>
                <p class="card-text">View and edit available courses.</p>
                <a href="courses.php" class="btn btn-outline-success w-100">Go to Courses</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 shadow-sm border-start border-warning border-5">
                <h5 class="card-title">📝 Manage Enrollments</h5>
                <p class="card-text">Handle course enrollments.</p>
                <a href="enrollments.php" class="btn btn-outline-warning w-100">Go to Enrollments</a>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-4">
        <div class="col-md-6">
            <div class="card p-4 shadow-sm border-start border-info border-5">
                <h5 class="card-title">📋 Login Logs</h5>
                <p class="card-text">View all successful login records.</p>
                <a href="login_logs.php" class="btn btn-outline-info w-100">View Logs</a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-4 shadow-sm border-start border-danger border-5">
                <h5 class="card-title">❌ Failed Login Attempts</h5>
                <p class="card-text">Monitor failed login attempts.</p>
                <a href="failed_logins.php" class="btn btn-outline-danger w-100">View Failed Attempts</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
