<?php
session_start();
if (!isset($_SESSION["username"]) || !isset($_SESSION["role"])) {
    header("Location: login.php");
    exit();
}
include './db/db.php';

$student_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM students"))['total'];
$course_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM courses"))['total'];
$enrollment_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM enrollments"))['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background: linear-gradient(to right, #eef2f3, #8e9eab);
            font-family: 'Segoe UI', sans-serif;
        }

        .dashboard-card {
            border-radius: 20px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            backdrop-filter: blur(12px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            position: relative;
            overflow: hidden;
            transition: 0.4s;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
        }

        .dashboard-icon {
            font-size: 2.5rem;
            position: absolute;
            top: 15px;
            right: 15px;
            opacity: 0.2;
        }

        .admin-section {
            background: rgba(255,255,255,0.9);
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        }

        .admin-section a {
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .admin-section a:hover {
            color: #0d6efd;
        }

        .btn-modern {
            background: #ffffff22;
            color: white;
            border: 1px solid #fff3;
            transition: all 0.3s ease;
        }

        .btn-modern:hover {
            background: white;
            color: #000;
        }

        canvas {
            max-height: 250px;
        }

        @media(max-width: 767px) {
            canvas {
                max-height: 200px;
            }
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold text-dark">📊 Dashboard</h1>
        <p class="text-muted">Welcome, <strong><?= htmlspecialchars($_SESSION["username"]) ?></strong>
            <span class="badge bg-dark"><?= $_SESSION["role"] ?></span>
        </p>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="dashboard-card" style="background: linear-gradient(135deg, #6a11cb, #2575fc);">
                <i class="bi bi-people-fill dashboard-icon"></i>
                <h5>👨‍🎓 Students</h5>
                <h2><?= $student_count ?></h2>
                <a href="students.php" class="btn btn-modern mt-3">View Students</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dashboard-card" style="background: linear-gradient(135deg, #11998e, #38ef7d);">
                <i class="bi bi-book-half dashboard-icon"></i>
                <h5>📚 Courses</h5>
                <h2><?= $course_count ?></h2>
                <a href="courses.php" class="btn btn-modern mt-3">View Courses</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dashboard-card" style="background: linear-gradient(135deg, #f7971e, #ffd200); color:#000;">
                <i class="bi bi-journal-check dashboard-icon"></i>
                <h5>📝 Enrollments</h5>
                <h2><?= $enrollment_count ?></h2>
                <a href="enrollments.php" class="btn btn-modern mt-3">View Enrollments</a>
            </div>
        </div>
    </div>

    
    <div class="glass p-4 mb-4 rounded-4 shadow-lg" style="background: rgba(255,255,255,0.6); backdrop-filter: blur(12px);">
        <h5 class="text-dark mb-3">📈 Overview Chart</h5>
        <canvas id="statsChart"></canvas>
    </div>

    <?php if ($_SESSION["role"] === "admin"): ?>
        <div class="mt-4">
            <h4 class="text-dark mb-3">🛠 Admin Shortcuts</h4>
            <div class="admin-section">
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="admin_panel.php" class="text-decoration-none text-dark"><i class="bi bi-speedometer2 me-2"></i>Admin Panel</a></li>
                    <li class="mb-2"><a href="login_logs.php" class="text-decoration-none text-dark"><i class="bi bi-fingerprint me-2"></i>Login Logs</a></li>
                    <li class="mb-2"><a href="failed_logins.php" class="text-decoration-none text-dark"><i class="bi bi-shield-exclamation me-2"></i>Failed Attempts</a></li>
                </ul>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    const ctx = document.getElementById('statsChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Students', 'Courses', 'Enrollments'],
            datasets: [{
                label: 'Total',
                data: [<?= $student_count ?>, <?= $course_count ?>, <?= $enrollment_count ?>],
                backgroundColor: [
                    'rgba(106, 17, 203, 0.7)',
                    'rgba(17, 153, 142, 0.7)',
                    'rgba(255, 215, 0, 0.7)'
                ],
                borderRadius: 12,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { color: '#333' }
                },
                x: {
                    ticks: { color: '#333' }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#fff',
                    titleColor: '#000',
                    bodyColor: '#000'
                }
            }
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
