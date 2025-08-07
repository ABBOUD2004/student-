<?php include './db/db.php'; ?>
<?php include './navbar.php';

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM courses WHERE id = $id");
$course = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Course</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #2C5364, #203A43, #0F2027);
            background-size: 400% 400%;
            animation: gradientFlow 18s ease infinite;
            color: #fff;
            font-family: 'Segoe UI', sans-serif;
        }

        @keyframes gradientFlow {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .glass-box {
            max-width: 650px;
            margin: 60px auto;
            padding: 40px;
            background: rgba(255, 255, 255, 0.07);
            border-radius: 20px;
            box-shadow: 0 12px 24px rgba(0,0,0,0.3);
            backdrop-filter: blur(10px);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #ffffff;
            text-shadow: 0 0 10px rgba(255,255,255,0.2);
        }

        label {
            font-weight: 500;
            color: #ddd;
        }

        .form-control {
            background-color: rgba(255,255,255,0.08);
            border: none;
            color: #fff;
        }

        .form-control:focus {
            background-color: rgba(255,255,255,0.12);
            color: #fff;
            box-shadow: 0 0 0 0.2rem rgba(255,255,255,0.25);
        }

        .btn-success {
            width: 100%;
            padding: 10px;
            font-weight: bold;
            letter-spacing: 0.5px;
            background-color: #27ae60;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background-color: #2ecc71;
            transform: scale(1.02);
        }

        .btn-secondary {
            background-color: #7f8c8d;
            color: #fff;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #95a5a6;
        }
    </style>
</head>
<body>

<div class="glass-box">
    <h2>📚 Edit Course</h2>
    <form action="update_course.php" method="POST">
        <input type="hidden" name="id" value="<?= $course['id'] ?>">

        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" value="<?= htmlspecialchars($course['title']) ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" rows="4" class="form-control" required><?= htmlspecialchars($course['description']) ?></textarea>
        </div>

        <div class="mb-3">
            <label>Hours</label>
            <input type="number" name="hours" value="<?= $course['hours'] ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Price</label>
            <input type="text" name="price" value="<?= $course['price'] ?>" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success mt-3">💾 Update Course</button>
        <a href="courses.php" class="btn btn-secondary mt-2 w-100">🔙 Back to Courses</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
