<?php
session_start();

if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit();
}

include './db/db.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "✅ Student deleted successfully.";
    } else {
        $_SESSION['message'] = "❌ Failed to delete student.";
    }

    $stmt->close();
} else {
    $_SESSION['message'] = "⚠️ Invalid student ID.";
}

header("Location: students.php");
exit();
?>
