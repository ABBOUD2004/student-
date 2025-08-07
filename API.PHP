<?php
$search = $_GET['search'] ?? '';
$users = [];
if ($search !== '') {
    $json = file_get_contents('https://jsonplaceholder.typicode.com/users');
    $allUsers = json_decode($json, true);
    foreach ($allUsers as $user) {
        if (stripos($user['name'], $search) !== false) {
            $users[] = $user;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>User Search API</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #a1c4fd, #c2e9fb);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .glass-box {
            background: rgba(255, 255, 255, 0.85);
            border-radius: 20px;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .card-user {
            background: #ffffffee;
            border: none;
            border-radius: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-user:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .card-title {
            color: #2c3e50;
            font-weight: 600;
        }

        .form-control, .btn {
            border-radius: 30px;
        }

        .icon {
            margin-right: 6px;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <?php include './navbar.php'; ?>

    <div class="container py-5">
        <div class="row justify-content-center mb-4">
            <div class="col-md-8 glass-box">
                <h2 class="mb-4 text-center">🔍 Search Users from API</h2>
                <form method="GET" class="input-group shadow-sm">
                    <input type="text" name="search" class="form-control" placeholder="Enter user name..." value="<?= htmlspecialchars($search) ?>" />
                    <button class="btn btn-primary px-4" type="submit">Search</button>
                </form>
            </div>
        </div>

        <?php if ($search !== ''): ?>
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <h5 class="text-muted mb-3">
                        Showing results for: "<strong><?= htmlspecialchars($search) ?></strong>"
                    </h5>

                    <?php if (count($users) === 0): ?>
                        <div class="alert alert-warning">😕 No users found.</div>
                    <?php else: ?>
                        <?php foreach ($users as $user): ?>
                            <div class="card card-user mb-4">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($user['name']) ?></h5>
                                    <ul class="list-unstyled mb-0">
                                        <li><span class="icon">👤</span><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></li>
                                        <li><span class="icon">📧</span><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></li>
                                        <li><span class="icon">📞</span><strong>Phone:</strong> <?= htmlspecialchars($user['phone']) ?></li>
                                        <li><span class="icon">🌐</span><strong>Website:</strong> 
                                            <a href="http://<?= htmlspecialchars($user['website']) ?>" target="_blank"><?= htmlspecialchars($user['website']) ?></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
