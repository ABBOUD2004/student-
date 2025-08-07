<?php
session_start();

if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit();
}

include './db/db.php';

$result = mysqli_query($conn, "SELECT * FROM login_logs WHERE status = 'FAIL' ORDER BY log_time DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Failed Login Attempts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1a1a2e, #16213e, #0f3460);
            background-size: 400% 400%;
            animation: gradientShift 20s ease infinite;
            font-family: 'Segoe UI', sans-serif;
            color: #fff;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .container {
            padding: 50px 20px;
        }

        .card-glass {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.2);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            color: #fff;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-glass:hover {
            transform: scale(1.03);
            box-shadow: 0 0 30px rgba(255, 0, 102, 0.4);
        }

        .card-glass .badge {
            font-size: 0.9rem;
            padding: 6px 12px;
            border-radius: 20px;
        }

        .icon {
            font-size: 2rem;
            color: #ff4b5c;
        }

        .log-item {
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .card-glass {
                padding: 15px;
            }
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
    <h2 class="text-center mb-5 fw-bold text-light text-shadow">🚫 Failed Login Attempts</h2>

    <div class="row">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="col-md-6 col-lg-4 log-item">
                <div class="card-glass h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="icon">🔥</div>
                        <span class="badge bg-danger">FAILED</span>
                    </div>
                    <p><strong>ID:</strong> <?= $row["id"] ?></p>
                    <p><strong>Username:</strong> <?= htmlspecialchars($row["username"]) ?></p>
                    <p><strong>Time:</strong> <?= $row["log_time"] ?></p>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
