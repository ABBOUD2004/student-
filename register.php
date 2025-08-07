<?php
session_start();
$message = "";

try {
    $pdo = new PDO("mysql:host=localhost;dbname=training_system", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"] ?? '');
    $password = $_POST["password"] ?? '';
    $confirm = $_POST["confirm"] ?? '';

    if (empty($username) || empty($password) || empty($confirm)) {
        $message = '<div class="alert alert-warning text-center">⚠️ All fields are required.</div>';
    } elseif ($password !== $confirm) {
        $message = '<div class="alert alert-danger text-center">❌ Passwords do not match.</div>';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $message = '<div class="alert alert-danger text-center">🚫 Username already exists.</div>';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->execute([$username, $hash]);
            $message = '<div class="alert alert-success text-center">✅ Account created successfully. <a href="login.php">Login here</a></div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #141e30, #243b55);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.07);
            backdrop-filter: blur(12px);
            border-radius: 16px;
            padding: 30px;
            color: white;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
        }

        .form-control, .btn {
            border-radius: 10px;
        }

        h3 {
            text-align: center;
            margin-bottom: 25px;
            text-shadow: 0 0 8px rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body>

    <div class="glass-card">
        <h3>🔐 Create Account</h3>

        <?= $message ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="confirm" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Register</button>
            <a href="login.php" class="btn btn-link text-light mt-2 w-100">Already have an account?</a>
        </form>
    </div>

</body>
</html>
