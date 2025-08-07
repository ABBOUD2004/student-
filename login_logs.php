<?php
session_start();

if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit();
}

include './db/db.php';


$result = mysqli_query($conn, "SELECT * FROM login_logs ORDER BY log_time DESC");


$success_count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM login_logs WHERE status = 'SUCCESS'"));
$fail_count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM login_logs WHERE status = 'FAIL'"));


function parse_user_agent($agent) {
    $browser = 'Unknown';
    $os = 'Unknown';

    if (preg_match('/Windows NT 10.0/i', $agent)) $os = '🪟 Windows 10';
    elseif (preg_match('/Mac OS X/i', $agent)) $os = '🍏 macOS';
    elseif (preg_match('/Android/i', $agent)) $os = '🤖 Android';
    elseif (preg_match('/iPhone/i', $agent)) $os = '📱 iOS';

    if (preg_match('/Edg\/([0-9\.]+)/i', $agent, $match)) $browser = '🌐 Edge ' . $match[1];
    elseif (preg_match('/Chrome\/([0-9\.]+)/i', $agent, $match)) $browser = '🌐 Chrome ' . $match[1];
    elseif (preg_match('/Firefox\/([0-9\.]+)/i', $agent, $match)) $browser = '🔥 Firefox ' . $match[1];
    elseif (preg_match('/Safari\/([0-9\.]+)/i', $agent, $match) && !preg_match('/Chrome/i', $agent)) $browser = '🧭 Safari ' . $match[1];

    return "$browser<br>$os";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Logs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background: linear-gradient(to right, #141e30, #243b55);
            color: #fff;
        }
        .card-log {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }
        .card-log:hover {
            transform: scale(1.02);
            box-shadow: 0 0 12px rgba(255, 255, 255, 0.1);
        }
        .badge-status {
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: bold;
        }
        .badge-success {
            background-color: #28ffbf;
            color: black;
        }
        .badge-fail {
            background-color: #ff5e5e;
        }
        .user-agent {
            font-size: 0.85rem;
            color: #b0d0ff;
        }
        .chart-container {
            background-color: #ffffff09;
            padding: 30px;
            border-radius: 15px;
            margin-top: 40px;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">🧾 Login Logs</h2>

    <div class="row">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="col-md-6">
                <div class="card-log">
                    <h5><strong><?= htmlspecialchars($row["username"]) ?></strong></h5>
                    <div class="mb-2">
                        <span class="badge-status <?= $row["status"] === 'SUCCESS' ? 'badge-success' : 'badge-fail' ?>">
                            <?= $row["status"] ?>
                        </span>
                        <small class="ms-2"><?= date("Y-m-d H:i:s", strtotime($row["log_time"])) ?></small>
                    </div>
                    <div>IP: <?= $row["ip_address"] ?? '-' ?></div>
                    <div class="user-agent"><?= parse_user_agent($row["user_agent"] ?? '-') ?></div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>


    <div class="chart-container d-flex justify-content-center align-items-center flex-column" style="max-width: 400px; margin: 40px auto;">
    <h5 class="mb-3 text-center">📊 Login Summary</h5>
    <canvas id="loginChart" width="250" height="250"></canvas>
</div>

</div>

<script>
    const ctx = document.getElementById('loginChart').getContext('2d');
    const loginChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Successful', 'Failed'],
            datasets: [{
                label: 'Login Attempts',
                data: [<?= $success_count ?>, <?= $fail_count ?>],
                backgroundColor: ['#28ffbf', '#ff5e5e'],
                borderWidth: 2
            }]
        },
        options: {
            plugins: {
                legend: {
                    labels: {
                        color: '#fff',
                        font: { size: 14 }
                    }
                }
            }
        }
    });
</script>

</body>
</html>
