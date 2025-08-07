<?php
session_start();
if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit();
}
include './navbar.php';
include './db/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Enrollment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #d9afd9, #97d9e1);
            font-family: 'Segoe UI', sans-serif;
        }
        .form-card {
            background: rgba(255, 255, 255, 0.85);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }
        label i {
            color: #0d6efd;
            margin-right: 6px;
        }
        .btn-success {
            background: linear-gradient(45deg, #198754, #28a745);
            border: none;
        }
        .btn-success:hover {
            background: linear-gradient(45deg, #157347, #218838);
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 90vh;">
    <div class="col-md-8 col-lg-6 form-card">
        <h2 class="text-center mb-4">📚 Add Enrollment</h2>

        <form action="insert_enrollment.php" method="post">
            
            <div class="mb-3">
                <label><i class="bi bi-person-fill"></i>Student</label>
                <select name="student_id" class="form-select" required>
                    <option disabled selected>Select Student</option>
                    <?php
                    $students = mysqli_query($conn, "SELECT id, name FROM students");
                    while ($s = mysqli_fetch_assoc($students)) {
                        $name = htmlspecialchars($s['name']);
                        echo "<option value='{$s['id']}'>{$name}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label><i class="bi bi-journal-text"></i>Course</label>
                <select name="course_id" class="form-select" required>
                    <option disabled selected>Select Course</option>
                    <?php
                    $courses = mysqli_query($conn, "SELECT id, title FROM courses");
                    while ($c = mysqli_fetch_assoc($courses)) {
                        $title = htmlspecialchars($c['title']);
                        echo "<option value='{$c['id']}'>{$title}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label><i class="bi bi-bar-chart-fill"></i>Grade</label>
                <input type="text" name="grade" class="form-control" placeholder="e.g. A, B+, 95..." required>
            </div>

            <div class="mb-3">
                <label><i class="bi bi-calendar2-week"></i>Enrollment Date</label>
                <input type="date" name="enrollment_date" class="form-control" required>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-success px-4">Save</button>
                <a href="enrollments.php" class="btn btn-outline-secondary ms-2">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
