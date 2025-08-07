<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}
include './db/db.php';
include 'navbar.php';

$result = mysqli_query($conn, "SELECT * FROM students ORDER BY id DESC");

$student_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM students"))['total'];
$course_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM courses"))['total'];
$enrollment_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM enrollments"))['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Students</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            background-size: 400% 400%;
            animation: moveBg 18s ease infinite;
            font-family: 'Segoe UI', sans-serif;
            color: #f1f1f1;
        }
        @keyframes moveBg {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .container {
            padding: 40px;
        }
        .card-glass {
            background: rgba(255, 255, 255, 0.07);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 18px;
            padding: 20px;
            color: #fff;
            box-shadow: 0 8px 24px rgba(0,0,0,0.2);
            transition: transform 0.3s ease;
        }
        .card-glass:hover {
            transform: scale(1.02);
        }
        .btn-primary {
            background-color: #3498db;
            border: none;
        }
        .btn-edit, .btn-delete {
            border: none;
            padding: 6px 12px;
            font-size: 0.9rem;
            border-radius: 8px;
        }
        .btn-edit {
            background-color: #27ae60;
            color: white;
        }
        .btn-edit:hover {
            background-color: #1e8449;
        }
        .btn-delete {
            background-color: #e74c3c;
            color: white;
        }
        .btn-delete:hover {
            background-color: #c0392b;
        }
        canvas {
            background-color: rgba(255,255,255,0.05);
            border-radius: 12px;
            padding: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <h2 class="m-0">👨‍🎓 Students List</h2>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <a href="add_student.php" class="btn btn-primary">+ Add Student</a>
        <?php endif; ?>
    </div>

    <div class="row g-4">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="col-md-6 col-lg-4">
            <div class="card-glass h-100 d-flex flex-column justify-content-between">
                <div>
                    <h5><?= htmlspecialchars($row["name"]) ?></h5>
                    <p><strong>Email:</strong> <?= htmlspecialchars($row["email"]) ?></p>
                    <p><strong>Registered:</strong> <?= $row["created_at"] ?? '<span class="text-muted">N/A</span>' ?></p>
                </div>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <div class="d-flex justify-content-between mt-3">
                        <a href="edit_student.php?id=<?= $row['id'] ?>" class="btn btn-edit">Edit</a>
                        <a href="delete_student.php?id=<?= $row['id'] ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endwhile; ?>
    </div>

    <hr class="my-5">
    <h4 class="text-center mb-4">📊 System Statistics</h4>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <canvas id="statsChart" height="140"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
                'rgba(26, 188, 156, 0.9)',
                'rgba(243, 156, 18, 0.9)',
                'rgba(52, 152, 219, 0.9)'
            ],
            borderRadius: 10
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
