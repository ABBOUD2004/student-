<?php
session_start();
if (!isset($_SESSION["username"]) || !isset($_SESSION["role"])) {
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
    <title>Enrollments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            background-size: 300% 300%;
            animation: gradientFlow 20s ease infinite;
            color: #f1f1f1;
            font-family: 'Segoe UI', sans-serif;
        }

        @keyframes gradientFlow {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .container {
            background-color: rgba(255, 255, 255, 0.06);
            padding: 40px;
            border-radius: 15px;
            margin-top: 50px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(8px);
        }

        h2 {
            color: #ffffff;
            text-shadow: 0 0 5px rgba(255, 255, 255, 0.2);
        }

        .card-enroll {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
        }

        .card-enroll:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: scale(1.02);
            transition: all 0.3s ease-in-out;
        }

        .stats-card {
            color: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <h2>📘 Enrollments</h2>
            <div class="text-muted">
                Welcome, <strong><?= htmlspecialchars($_SESSION["username"]) ?></strong>
                <span class="badge bg-info text-dark ms-2"><?= htmlspecialchars($_SESSION["role"]) ?></span>
            </div>
        </div>

        <?php if ($_SESSION["role"] === "admin"): ?>
            <a href="add_enrollment.php" class="btn btn-primary mb-3">+ Add Enrollment</a>
        <?php endif; ?>

        <div class="row">
            <?php
            $sql = "SELECT enrollments.id, students.name AS student_name, courses.title AS course_title, enrollments.grade, enrollments.enrollment_date 
                    FROM enrollments 
                    JOIN students ON enrollments.student_id = students.id 
                    JOIN courses ON enrollments.course_id = courses.id";
            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='col-md-4'>
                        <div class='card-enroll'>
                            <h5>👨‍🎓 " . htmlspecialchars($row['student_name']) . "</h5>
                            <p>📘 Course: <strong>" . htmlspecialchars($row['course_title']) . "</strong></p>
                            <p>📊 Grade: <span class='text-warning'>" . htmlspecialchars($row['grade']) . "</span></p>
                            <p>📅 Date: " . htmlspecialchars($row['enrollment_date']) . "</p>
                            <div class='d-flex gap-2'>";
                if ($_SESSION["role"] === "admin") {
                    echo "<a href='edit_enrollment.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                        <a href='delete_enrollment.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure?')\">Delete</a>";
                }
                echo "</div></div></div>";
            }
            ?>
        </div>

        <?php
        $students = mysqli_query($conn, "SELECT COUNT(*) AS total FROM students");
        $courses = mysqli_query($conn, "SELECT COUNT(*) AS total FROM courses");
        $enrollments = mysqli_query($conn, "SELECT COUNT(*) AS total FROM enrollments");

        $student_count = mysqli_fetch_assoc($students)['total'];
        $course_count = mysqli_fetch_assoc($courses)['total'];
        $enrollment_count = mysqli_fetch_assoc($enrollments)['total'];
        ?>

        <hr class="my-5">

        <div class="row text-center g-4">
            <div class="col-md-4">
                <div class="p-4 stats-card" style="background: linear-gradient(135deg, #1abc9c, #16a085);">
                    <h5>👨‍🎓 Total Students</h5>
                    <h2><?= $student_count ?></h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 stats-card" style="background: linear-gradient(135deg, #f39c12, #e67e22);">
                    <h5>📚 Total Courses</h5>
                    <h2><?= $course_count ?></h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 stats-card" style="background: linear-gradient(135deg, #3498db, #2980b9);">
                    <h5>📝 Total Enrollments</h5>
                    <h2><?= $enrollment_count ?></h2>
                </div>
            </div>
        </div>

        

<hr class="my-5">
<div class="text-center mb-4">
    <h3 class="text-white">📊 Enrollments Statistics</h3>
</div>

<div class="d-flex justify-content-center">
    <div style="width: 500px; max-width: 90%;">
        <canvas id="enrollmentChart"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('enrollmentChart').getContext('2d');
    const enrollmentChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Students', 'Courses', 'Enrollments'],
            datasets: [{
                label: 'Statistics',
                data: [<?= $student_count ?>, <?= $course_count ?>, <?= $enrollment_count ?>],
                backgroundColor: [
                    '#1abc9c',
                    '#f39c12',
                    '#3498db'
                ],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: 'white',
                        font: {
                            size: 14
                        }
                    }
                },
                tooltip: {
                    backgroundColor: '#2c3e50',
                    titleColor: '#fff',
                    bodyColor: '#fff'
                }
            }
        }
    });
</script>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
