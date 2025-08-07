<?php
ob_start();
session_start();
$message = "";

try {
    $pdo = new PDO("mysql:host=localhost;dbname=training_system", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB Error: " . $e->getMessage());
}

function log_attempt($pdo, $username, $status) {
    $ip = $_SERVER['REMOTE_ADDR'];
    $agent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
    $stmt = $pdo->prepare("INSERT INTO login_logs (username, status, ip_address, user_agent) VALUES (?, ?, ?, ?)");
    $stmt->execute([$username, $status, $ip, $agent]);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST["action"] ?? "";

    if ($action === "login") {
        $username = trim($_POST["username"] ?? '');
        $password = $_POST["password"] ?? '';

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            log_attempt($pdo, $username, "FAIL");
            $message = "Username not found.";
        } elseif (!password_verify($password, $user["password"])) {
            log_attempt($pdo, $username, "FAIL");
            $message = "Incorrect password.";
        } else {
            
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["role"] = $user["role"];
            $_SESSION["full_name"] = $user["full_name"] ?? '';
            $_SESSION["email"] = $user["email"] ?? '';
            $_SESSION["profile_pic"] = $user["profile_pic"] ?? '';

            log_attempt($pdo, $username, "SUCCESS");
            header("Location: index.php");
            exit();
        }

    } elseif ($action === "register") {
        $new_user = trim($_POST["new_username"] ?? '');
        $new_pass = $_POST["new_password"] ?? '';
        $confirm = $_POST["confirm_password"] ?? '';
        $role = $_POST["role"] ?? 'user';

        if (empty($new_user) || empty($new_pass) || empty($confirm)) {
            $message = "All fields are required.";
        } elseif ($new_pass !== $confirm) {
            $message = "Passwords do not match.";
        } else {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$new_user]);
            if ($stmt->fetch()) {
                $message = "Username already exists.";
            } else {
                $hash = password_hash($new_pass, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
                $stmt->execute([$new_user, $hash, $role]);
                $message = "✅ Registered successfully! You can now login.";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>🔥 Login / Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: radial-gradient(circle at 20% 20%, #0f2027, #203a43, #2c5364);
            background-size: 300% 300%;
            animation: bgSlide 15s ease infinite;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        @keyframes bgSlide {
            0% {background-position: 0% 50%;}
            50% {background-position: 100% 50%;}
            100% {background-position: 0% 50%;}
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            backdrop-filter: blur(20px);
            box-shadow: 0 0 40px rgba(255, 255, 255, 0.1);
            padding: 40px;
            width: 400px;
            color: white;
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {opacity: 0; transform: scale(0.98);}
            to {opacity: 1; transform: scale(1);}
        }

        .nav-tabs .nav-link {
            color: #ccc;
            border: none;
        }

        .nav-tabs .nav-link.active {
            color: #fff;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.07);
            border: none;
            color: #fff;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 10px #0ff;
            color: white;
        }

        .btn {
            border-radius: 10px;
            font-weight: bold;
        }

        .alert {
            font-size: 0.9rem;
            background-color: rgba(255, 0, 0, 0.1);
            border: 1px solid rgba(255, 0, 0, 0.3);
            color: #fff;
        }

        select.form-control {
            color: white;
        }
    </style>
</head>
<body>
<div class="glass-card">
    <ul class="nav nav-tabs mb-3 justify-content-center" id="authTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button">Login</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button">Register</button>
        </li>
    </ul>

    <?php if ($message): ?>
        <div class="alert text-center mb-3"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="login">
            <form method="POST">
                <input type="hidden" name="action" value="login">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-light w-100"> Login</button>
            </form>
        </div>

        <div class="tab-pane fade" id="register">
            <form method="POST">
                <input type="hidden" name="action" value="register">
                <div class="mb-3">
                    <label class="form-label">New Username</label>
                    <input type="text" name="new_username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <input type="password" name="new_password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-control" required>
                        <option value="user" selected>User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success w-100"> Register</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
