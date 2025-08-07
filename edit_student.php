<?php
include './db/db.php';
$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM students WHERE id = $id");
$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            background-size: 400% 400%;
            animation: animateBg 15s ease infinite;
            color: #fff;
            font-family: 'Segoe UI', sans-serif;
        }

        @keyframes animateBg {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            padding: 40px;
            max-width: 600px;
            margin: auto;
            margin-top: 60px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            animation: fadeIn 0.8s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        label {
            font-weight: 500;
            color: #ddd;
        }

        .form-control {
            background-color: rgba(255,255,255,0.1);
            color: #fff;
            border: none;
        }

        .form-control:focus {
            background-color: rgba(255,255,255,0.15);
            color: #fff;
            box-shadow: 0 0 0 0.25rem rgba(255,255,255,0.2);
        }

        .btn-primary {
            background-color: #3498db;
            border: none;
            width: 100%;
        }

        .btn-secondary {
            width: 100%;
        }

        .btn:hover {
            opacity: 0.9;
            transform: scale(1.02);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            text-shadow: 0 0 10px rgba(255,255,255,0.2);
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="glass-card">
    <h2>✏️ Edit Student</h2>
    <form action="student/update_student.php?id=<?= $id ?>" method="POST">
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($data['name']) ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($data['email']) ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" value="<?= htmlspecialchars($data['phone']) ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Date of Birth</label>
            <input type="date" name="dob" value="<?= htmlspecialchars($data['dob']) ?>" class="form-control" required>
        </div>
        <div class="d-grid gap-2 mt-4">
            <button type="submit" class="btn btn-primary">💾 Update Student</button>
            <a href="students.php" class="btn btn-secondary">🔙 Back to List</a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
