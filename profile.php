<?php
session_start();
include './db/db.php';

$username = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    echo "User not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #1f4037, #99f2c8);
            font-family: 'Segoe UI', sans-serif;
        }

        .profile-card {
            max-width: 700px;
            margin: 60px auto;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            color: #fff;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .profile-img {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.4);
        }

        .info-item {
            font-size: 18px;
            margin-bottom: 15px;
        }

        .info-item i {
            color: #00ffe7;
            margin-right: 10px;
        }
    </style>
</head>

<body>

<?php include './navbar.php'; ?>

<div class="profile-card text-center">
    <img src="uploads/profile_pics/<?= htmlspecialchars($user['profile_pic']) ?>" class="profile-img mb-4" alt="Profile Picture">
    <h2 class="mb-0"><?= htmlspecialchars($user['full_name']) ?></h2>
    <p class="text-light fst-italic mb-4"><?= ucfirst($user['role']) ?></p>

    <div class="text-start px-3">
        <div class="info-item"><i class="bi bi-person-fill"></i> <strong>Username:</strong>
            <?= htmlspecialchars($user['username']) ?></div>
        <div class="info-item"><i class="bi bi-envelope-fill"></i> <strong>Email:</strong>
            <?= htmlspecialchars($user['email']) ?></div>
        <div class="info-item"><i class="bi bi-calendar-check-fill"></i> <strong>Joined:</strong>
            <?php
            if (!empty($user['created_at']) && strtotime($user['created_at']) > 0) {
                echo date("F j, Y", strtotime($user['created_at']));
            } else {
                echo "<span class='text-warning'>Not set</span>";
            }
            ?>
        </div>
    </div>

    <a href="settings.php" class="btn btn-outline-light mt-4"><i class="bi bi-pencil-square"></i> Edit Profile</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
