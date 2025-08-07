<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include './db/db.php';

$students = mysqli_query($conn, "SELECT COUNT(*) AS total FROM students");
$courses = mysqli_query($conn, "SELECT COUNT(*) AS total FROM courses");
$enrollments = mysqli_query($conn, "SELECT COUNT(*) AS total FROM enrollments");

$student_count = mysqli_fetch_assoc($students)['total'];
$course_count = mysqli_fetch_assoc($courses)['total'];
$enrollment_count = mysqli_fetch_assoc($enrollments)['total'];

$role = $_SESSION['role'];
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background: linear-gradient(135deg, #2c3e50, #3498db, #2980b9, #8e44ad);
            background-size: 500% 500%;
            animation: gradientBG 15s ease infinite;
            font-family: 'Segoe UI', sans-serif;
            color: white;
        }

        @keyframes gradientBG {
            0% {background-position: 0% 50%;}
            50% {background-position: 100% 50%;}
            100% {background-position: 0% 50%;}
        }

        .card {
            backdrop-filter: blur(16px);
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            transition: transform 0.3s ease;
            color: white;
        }

        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .card-title {
            font-weight: bold;
        }

        .btn {
            border-radius: 30px;
        }

        .chart-container {
            background-color: rgba(255, 255, 255, 0.07);
            padding: 20px;
            border-radius: 20px;
            margin-top: 40px;
        }

        h2 span {
            font-size: 0.7em;
            margin-left: 10px;
        }

        .counter {
            font-size: 1.8rem;
            font-weight: bold;
            color: #f1f1f1;
        }
    </style>
</head>
<body>
<?php include './navbar.php'; ?>

<div class="container mt-4">
    <h2>Welcome, <?= htmlspecialchars($username) ?> 
        <span class="badge bg-<?= $role === 'admin' ? 'primary' : 'secondary' ?>"><?= ucfirst($role) ?></span>
    </h2>

    <div class="row g-4 mt-3">
        
        <div class="col-md-4">
            <div class="card p-4 border-start border-4 border-success">
                <h5 class="card-title"><i class="bi bi-people-fill me-2"></i>Students</h5>
                <p class="counter" id="studentCount">0</p>
                <a href="students.php" class="btn btn-outline-success btn-sm">View Students</a>
            </div>
        </div>

        
        <div class="col-md-4">
            <div class="card p-4 border-start border-4 border-warning">
                <h5 class="card-title"><i class="bi bi-book-half me-2"></i>Courses</h5>
                <p class="counter" id="courseCount">0</p>
                <a href="courses.php" class="btn btn-outline-warning btn-sm">View Courses</a>
            </div>
        </div>

       
        <div class="col-md-4">
            <div class="card p-4 border-start border-4 border-info">
                <h5 class="card-title"><i class="bi bi-journal-check me-2"></i>Enrollments</h5>
                <p class="counter" id="enrollCount">0</p>
                <a href="enrollments.php" class="btn btn-outline-info btn-sm">View Enrollments</a>
            </div>
        </div>
    </div>

    
    <?php if ($role === 'admin'): ?>
        <hr class="my-5">
        <h4>Admin Tools</h4>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <a href="admin_panel.php" class="btn btn-dark w-100"><i class="bi bi-shield-lock-fill me-2"></i>Admin Panel</a>
            </div>
            <div class="col-md-4">
                <a href="login_logs.php" class="btn btn-secondary w-100"><i class="bi bi-clock-history me-2"></i>Login Logs</a>
            </div>
            <div class="col-md-4">
                <a href="failed_logins.php" class="btn btn-danger w-100"><i class="bi bi-exclamation-triangle-fill me-2"></i>Failed Logins</a>
            </div>
        </div>
    <?php endif; ?>

    
    <div class="chart-container">
        <h5><i class="bi bi-bar-chart-fill me-2"></i>Enrollment Overview</h5>
        <canvas id="chart" height="100"></canvas>
    </div>
</div>

<script>
    
    const animateCounter = (id, end) => {
        let start = 0;
        const duration = 800;
        const step = Math.ceil(end / (duration / 16));
        const el = document.getElementById(id);
        const interval = setInterval(() => {
            start += step;
            if (start >= end) {
                start = end;
                clearInterval(interval);
            }
            el.innerText = start;
        }, 16);
    };

    animateCounter("studentCount", <?= $student_count ?>);
    animateCounter("courseCount", <?= $course_count ?>);
    animateCounter("enrollCount", <?= $enrollment_count ?>);

    
    const ctx = document.getElementById('chart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Students', 'Courses', 'Enrollments'],
            datasets: [{
                label: 'Total Count',
                data: [<?= $student_count ?>, <?= $course_count ?>, <?= $enrollment_count ?>],
                backgroundColor: ['#28a745', '#ffc107', '#17a2b8']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { color: 'white' },
                    grid: { color: 'rgba(255,255,255,0.1)' }
                },
                x: {
                    ticks: { color: 'white' },
                    grid: { color: 'rgba(255,255,255,0.1)' }
                }
            }
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
