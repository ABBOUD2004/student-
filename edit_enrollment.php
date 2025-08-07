<?php
include './navbar.php';
include './db/db.php';

$id = $_GET['id'];
$sql = "SELECT * FROM enrollments WHERE id = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Enrollment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1d2b64, #f8cdda);
            background-size: 400% 400%;
            animation: animatedBg 15s ease infinite;
            font-family: 'Segoe UI', sans-serif;
            color: #fff;
        }

        @keyframes animatedBg {
            0% {background-position: 0% 50%;}
            50% {background-position: 100% 50%;}
            100% {background-position: 0% 50%;}
        }

        .glass-form {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px;
            padding: 40px;
            max-width: 650px;
            margin: auto;
            margin-top: 60px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.4);
            backdrop-filter: blur(10px);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #fff;
            text-shadow: 0 0 10px rgba(255,255,255,0.2);
        }

        label {
            font-weight: 500;
            color: #ddd;
        }

        .form-control {
            background: rgba(255,255,255,0.1);
            color: #fff;
            border: none;
        }

        .form-control:focus {
            background: rgba(255,255,255,0.15);
            color: #fff;
            box-shadow: 0 0 0 0.2rem rgba(255,255,255,0.2);
        }

        .btn-primary {
            background-color: #6c5ce7;
            border: none;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: scale(1.03);
            background-color: #a29bfe;
        }
    </style>
</head>
<body>

<div class="glass-form">
    <h2>📘 Edit Enrollment</h2>
    <form action="update_enrollment.php" method="post">
        <input type="hidden" name="id" value="<?= $id ?>">

        <div class="mb-3">
            <label>Student</label>
            <select name="student_id" class="form-control" required>
                <?php
                $students = mysqli_query($conn, "SELECT id, name FROM students");
                while ($s = mysqli_fetch_assoc($students)) {
                    $selected = $s['id'] == $row['student_id'] ? 'selected' : '';
                    echo "<option value='{$s['id']}' $selected>{$s['name']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Course</label>
            <select name="course_id" class="form-control" required>
                <?php
                $courses = mysqli_query($conn, "SELECT id, title FROM courses");
                while ($c = mysqli_fetch_assoc($courses)) {
                    $selected = $c['id'] == $row['course_id'] ? 'selected' : '';
                    echo "<option value='{$c['id']}' $selected>{$c['title']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Grade</label>
            <input type="text" name="grade" class="form-control" value="<?= htmlspecialchars($row['grade']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Enrollment Date</label>
            <input type="date" name="enrollment_date" class="form-control" value="<?= $row['enrollment_date'] ?>" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">💾 Update Enrollment</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
