<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<style>
    .navbar-custom {
        background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
    }

    .navbar-custom .nav-link {
        color: #f1f1f1;
        transition: color 0.3s ease, transform 0.2s ease;
    }

    .navbar-custom .nav-link:hover {
        color: #00d4ff;
        transform: scale(1.05);
    }

    .navbar-brand {
        font-weight: bold;
        color: #ffffff;
        text-shadow: 0 0 4px #00d4ff;
    }

    .navbar-toggler {
        border-color: #ffffff;
    }

    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba%28 255, 255, 255, 0.7 %29)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/ %3E%3C/svg%3E");
    }

    .profile-pic-small {
        width: 30px;
        height: 30px;
        object-fit: cover;
        border-radius: 50%;
        margin-right: 8px;
        border: 2px solid #ffffff66;
    }

    .profile-pic-large {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #ffffffaa;
        margin-bottom: 10px;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom px-4">
    <a class="navbar-brand" href="./index.php">Training System</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="mainNavbar">
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="students.php">Students</a></li>
            <li class="nav-item"><a class="nav-link" href="courses.php">Courses</a></li>
            <li class="nav-item"><a class="nav-link" href="enrollments.php">Enrollments</a></li>
            <li class="nav-item"><a class="nav-link" href="API.php">API</a></li>

            <?php if (isset($_SESSION["username"])): ?>
                <?php if ($_SESSION["role"] === "admin"): ?>
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Admin Panel</a></li>
                    <li class="nav-item"><a class="nav-link" href="login_logs.php">Login Logs</a></li>
                    <li class="nav-item"><a class="nav-link" href="failed_logins.php">Failed Logins</a></li>
                <?php endif; ?>

                <?php
                    $pic = $_SESSION["profile_pic"] ?? 'default.png';
                    $picWithTimestamp = "uploads/profile_pics/" . $pic . "?v=" . time();
                    $username = htmlspecialchars($_SESSION["username"]);
                    $role = htmlspecialchars($_SESSION["role"]);
                ?>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?= $picWithTimestamp ?>" alt="Profile" class="profile-pic-small">
                        <?= $username ?> (<?= $role ?>)
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li class="text-center p-3">
                            <img src="<?= $picWithTimestamp ?>" alt="Profile" class="profile-pic-large">
                            <h6 class="mb-0"><?= $username ?></h6>
                            <small class="text-muted"><?= ucfirst($role) ?></small>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="profile.php"><i class="bi bi-person"></i> My Profile</a></li>
                        <li><a class="dropdown-item" href="settings.php"><i class="bi bi-gear"></i> Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                    </ul>
                </li>
            <?php else: ?>
                <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
