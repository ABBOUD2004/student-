<?php
session_start();
if (!isset($_SESSION["username"]) || !isset($_SESSION["role"])) {
    header("Location: login.php");
    exit();
}
include './db/db.php';
include './navbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Courses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1d2b64, #f8cdda);
            background-size: 400% 400%;
            animation: gradientFlow 20s ease infinite;
            color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }

        @keyframes gradientFlow {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .container {
            padding: 40px;
        }

        .card-glass {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .card-glass:hover {
            transform: scale(1.02);
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.15);
        }

        h2 {
            font-weight: bold;
            text-shadow: 0 0 10px rgba(255,255,255,0.2);
        }

        .stats-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            color: #fff;
        }

        canvas {
            background-color: rgba(255,255,255,0.05);
            border-radius: 12px;
            padding: 10px;
        }

        .btn-warning {
            background-color: #f1c40f;
            color: #000;
        }

        .btn-danger {
            background-color: #e74c3c;
            color: #fff;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h2>📚 Courses</h2>
        <div class="text-muted">
            Welcome, <strong><?= htmlspecialchars($_SESSION["username"]) ?></strong>
            <span class="badge bg-light text-dark ms-2"><?= htmlspecialchars($_SESSION["role"]) ?></span>
        </div>
    </div>

    <?php if ($_SESSION["role"] === "admin"): ?>
        <a href="add_course.php" class="btn btn-success mb-4">+ Add Course</a>
    <?php endif; ?>

    <div class="row g-4">
        <?php
        $result = mysqli_query($conn, "SELECT * FROM courses");
        while ($row = mysqli_fetch_assoc($result)):
        ?>
        <div class="col-md-6 col-lg-4">
            <div class="card-glass h-100">
                <h4><?= htmlspecialchars($row['title']) ?></h4>
                <p><?= htmlspecialchars($row['description']) ?></p>
                <p><strong>Hours:</strong> <?= $row['hours'] ?> ⏱️</p>
                <p><strong>Price:</strong> $<?= $row['price'] ?> 💵</p>
                <div class="d-flex justify-content-end gap-2">
                    <?php if ($_SESSION["role"] === "admin"): ?>
                        <a href="edit_course.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete_course.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>

    <?php
    $student_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM students"))['total'];
    $course_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM courses"))['total'];
    $enrollment_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM enrollments"))['total'];
    ?>

    <hr class="my-5">
    <h4 class="text-center mb-4">📊 System Statistics</h4>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <canvas id="statsChart" height="150"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                'rgba(26, 188, 156, 0.8)',
                'rgba(243, 156, 18, 0.8)',
                'rgba(52, 152, 219, 0.8)'
            ],
            borderRadius: 12,
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>
</body>
</html>
