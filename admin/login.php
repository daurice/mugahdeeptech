<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';
$error = '';

if (!empty($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? null)) {
        $error = 'Security check failed.';
    } else {
        $email = trim((string) ($_POST['email'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');
        $stmt = $pdo->prepare('SELECT id, name, email, password_hash, role FROM users WHERE email = :email AND role IN ("admin","editor") LIMIT 1');
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['admin_id'] = (int) $user['id'];
            $_SESSION['admin_name'] = $user['name'];
            $_SESSION['admin_role'] = $user['role'];
            header('Location: dashboard.php');
            exit;
        }

        $error = 'Invalid email or password.';
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login | Mugah DeepTech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="admin-auth">
    <form class="glass-card login-card" method="post">
        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()); ?>">
        <a class="brand-mark mb-4" href="../index.php"><img class="logo-mark" src="../assets/images/mugah-deeptech-logo.svg" alt="" aria-hidden="true"><span class="brand-text">Mugah DeepTech</span></a>
        <h1>Admin Login</h1>
        <?php if ($error): ?><div class="alert alert-danger"><?= e($error); ?></div><?php endif; ?>
        <label>Email</label>
        <input class="form-control mb-3" type="email" name="email" required>
        <label>Password</label>
        <input class="form-control mb-4" type="password" name="password" required>
        <button class="btn btn-premium w-100" type="submit">Login</button>
    </form>
</body>
</html>
