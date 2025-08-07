<?php
session_start();
if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "admin") {
        header("Location: login.php");
        exit();
}
include './db/db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $student_id = isset($_POST['student_id']) ? intval($_POST['student_id']) : 0;
        $course_id = isset($_POST['course_id']) ? intval($_POST['course_id']) : 0;
        $grade = isset($_POST['grade']) ? trim($_POST['grade']) : '';
        $enrollment_date = isset($_POST['enrollment_date']) ? $_POST['enrollment_date'] : '';
        if ($student_id > 0 && $course_id > 0 && !empty($grade) && !empty($enrollment_date)) {
                
                $stmt = $conn->prepare("INSERT INTO enrollments (student_id, course_id, grade, enrollment_date) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("iiss", $student_id, $course_id, $grade, $enrollment_date);
                
                if ($stmt->execute()) {
                        
                        header("Location: enrollments.php?success=1");
                        exit();
                } else {
                        
                        echo "<h4 style='color:red; text-align:center;'> Database Error: " . $stmt->error . "</h4>";
                }
                $stmt->close();
        } else {
                echo "<h4 style='color:red; text-align:center;'> Please fill all fields correctly.</h4>";
        }
} else {
        echo "<h4 style='color:red; text-align:center;'> Invalid request method.</h4>";
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <title>Add Enrollment</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
        <style>
                body {
                        background: linear-gradient(to right, #d9afd9, #97d9e1);
                        font-family: 'Segoe UI', sans-serif;
                }

                .form-card {
                        background: rgba(255, 255, 255, 0.85);
                        border-radius: 15px;
                        padding: 40px;
                        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
                        backdrop-filter: blur(10px);
                }

                label i {
                        color: #0d6efd;
                        margin-right: 6px;
                }

                .btn-success {
                        background: linear-gradient(45deg, #198754, #28a745);
                        border: none;
                }

                .btn-success:hover {
                        background: linear-gradient(45deg, #157347, #218838);
                }
        </style>
</head>

<body>

        <div class="container d-flex justify-content-center align-items-center" style="min-height: 90vh;">
                <div class="col-md-8 col-lg-6 form-card">
                        <h2 class="text-center mb-4">📚 Add Enrollment</h2>

                        <form action="insert_enrollment.php" method="post">

                                <div class="mb-3">
                                        <label><i class="bi bi-person-fill"></i>Student</label>
                                        <select name="student_id" class="form-select" required>
                                                <option value="" disabled selected>Select Student</option>
                                                <?php
                                                $students = mysqli_query($conn, "SELECT id, name FROM students");
                                                while ($s = mysqli_fetch_assoc($students)) {
                                                        echo "<option value='{$s['id']}'>" . htmlspecialchars($s['name']) . "</option>";
                                                }
                                                ?>
                                        </select>
                                </div>

                                <div class="mb-3">
                                        <label><i class="bi bi-journal-text"></i>Course</label>
                                        <select name="course_id" class="form-select" required>
                                                <option value="" disabled selected>Select Course</option>
                                                <?php
                                                $courses = mysqli_query($conn, "SELECT id, title FROM courses");
                                                while ($c = mysqli_fetch_assoc($courses)) {
                                                        echo "<option value='{$c['id']}'>" . htmlspecialchars($c['title']) . "</option>";
                                                }
                                                ?>
                                        </select>
                                </div>

                                <div class="mb-3">
                                        <label><i class="bi bi-bar-chart-fill"></i>Grade</label>
                                        <input type="text" name="grade" class="form-control"
                                                placeholder="e.g. A, B+, 95..." required>
                                </div>

                                <div class="mb-3">
                                        <label><i class="bi bi-calendar2-week"></i>Enrollment Date</label>
                                        <input type="date" name="enrollment_date" class="form-control" required>
                                </div>

                                <div class="text-end">
                                        <button type="submit" class="btn btn-success px-4">Save</button>
                                        <a href="enrollments.php" class="btn btn-outline-secondary ms-2">Cancel</a>
                                </div>
                        </form>
                </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>