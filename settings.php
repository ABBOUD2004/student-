<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

include './db/db.php';

$username = $_SESSION["username"];
$sql = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    echo "User not found.";
    exit;
}

$full_name = htmlspecialchars($user["full_name"]);
$email = htmlspecialchars($user["email"]);
$profile_pic = htmlspecialchars($user["profile_pic"]);
$role = htmlspecialchars($user["role"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            background-size: 400% 400%;
            animation: gradientBG 10s ease infinite;
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .glass-card {
            max-width: 720px;
            margin: 80px auto;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.3);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            padding: 40px;
            color: #fff;
        }

        .profile-img {
            width: 130px;
            height: 130px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #fff;
        }

        .form-label {
            font-weight: 600;
            color: #fff;
        }

        .form-control,
        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        .btn-primary {
            background: linear-gradient(to right, #0072ff, #00c6ff);
            border: none;
            font-weight: bold;
        }

        input::file-selector-button {
            background-color: #ffffff22;
            border: 1px solid #ffffff33;
            color: white;
            padding: 0.3em 1em;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<?php include './navbar.php'; ?>

<div class="glass-card text-white">
    <div class="text-center mb-4">
        <img id="profilePreview" src="uploads/profile_pics/<?= $profile_pic ?>?v=<?= time() ?>" alt="Profile Picture" class="profile-img mb-3">
        <h3 class="mb-0"><?= $full_name ?></h3>
        <span class="text-light fst-italic"><?= ucfirst($role) ?></span>
    </div>

    <form action="update_settings.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-person-fill"></i> Full Name</label>
            <input type="text" name="full_name" class="form-control" value="<?= $full_name ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><i class="bi bi-envelope-fill"></i> Email Address</label>
            <input type="email" name="email" class="form-control" value="<?= $email ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><i class="bi bi-key-fill"></i> Change Password</label>
            <input type="password" name="new_password" class="form-control" placeholder="Leave blank to keep current password">
        </div>

        <div class="mb-4">
            <label class="form-label"><i class="bi bi-image-fill"></i> Profile Picture</label>
            <input type="file" name="profile_pic" class="form-control" accept="image/*" onchange="previewImage(event)">
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow">
                <i class="bi bi-save2-fill me-2"></i> Save Changes
            </button>
        </div>
    </form>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function () {
            const output = document.getElementById('profilePreview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
