<?php
session_start();
include './db/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION["username"];

    $full_name = mysqli_real_escape_string($conn, trim($_POST["full_name"]));
    $email = mysqli_real_escape_string($conn, trim($_POST["email"]));
    $new_password = $_POST["new_password"];
    $profile_pic = $_FILES["profile_pic"];

    $update_password_sql = "";
    if (!empty($new_password)) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_password_sql = ", password = '$hashed_password'";
    }

    $uploadDir = "uploads/profile_pics/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $pic_name = $_SESSION["profile_pic"] ?? 'default.png';
    if ($profile_pic["size"] > 0 && $profile_pic["error"] == 0) {
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $ext = strtolower(pathinfo($profile_pic["name"], PATHINFO_EXTENSION));

        if (in_array($ext, $allowed_ext)) {
            $new_pic_name = uniqid("profile_") . "." . $ext;
            $upload_path = $uploadDir . $new_pic_name;

            
            if ($pic_name !== 'default.png' && file_exists($uploadDir . $pic_name)) {
                unlink($uploadDir . $pic_name);
            }

            if (move_uploaded_file($profile_pic["tmp_name"], $upload_path)) {
                $pic_name = $new_pic_name;
            }
        }
    }

    $sql = "UPDATE users SET 
                full_name = '$full_name', 
                email = '$email', 
                profile_pic = '$pic_name'
                $update_password_sql
            WHERE username = '$username'";

    if (mysqli_query($conn, $sql)) {
        $_SESSION["success"] = "Settings updated successfully!";
        $_SESSION["profile_pic"] = $pic_name;
        $_SESSION["full_name"] = $full_name;
        $_SESSION["email"] = $email;
    } else {
        $_SESSION["error"] = "Error updating settings: " . mysqli_error($conn);
    }

    header("Location: settings.php");
    exit();
}
?>
