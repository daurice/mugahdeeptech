<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf($_POST['csrf_token'] ?? null)) {
    $id = (int) ($_POST['id'] ?? 0);
    $action = $_POST['action'] ?? '';
    if ($id > 0 && $action === 'toggle') {
        $stmt = $pdo->prepare('UPDATE inquiries SET is_read = 1 - is_read WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }
    if ($id > 0 && $action === 'delete') {
        $stmt = $pdo->prepare('DELETE FROM inquiries WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }
    header('Location: inquiries.php');
    exit;
}

$inquiries = $pdo->query('SELECT * FROM inquiries ORDER BY created_at DESC')->fetchAll();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inquiries | Mugah DeepTech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="admin-page">
<div class="admin-shell">
    <aside><a class="brand-mark" href="../index.php"><img class="logo-mark" src="../assets/images/mugah-deeptech-logo.svg" alt="" aria-hidden="true"><span class="brand-text">Mugah DeepTech</span></a><nav><a href="dashboard.php">Dashboard</a><a class="active" href="inquiries.php">Inquiries</a><a href="logout.php">Logout</a></nav></aside>
    <main>
        <div class="admin-top"><div><p class="eyebrow">Admin</p><h1>Inquiries</h1></div></div>
        <div class="row g-4">
            <?php foreach ($inquiries as $item): ?>
                <div class="col-lg-6">
                    <article class="glass-card inquiry-card <?= $item['is_read'] ? '' : 'unread'; ?>">
                        <div class="d-flex justify-content-between gap-3"><div><span class="tag"><?= $item['is_read'] ? 'Read' : 'Unread'; ?></span><h2><?= e($item['full_name']); ?></h2></div><small><?= date('M d, Y H:i', strtotime($item['created_at'])); ?></small></div>
                        <p><?= nl2br(e($item['message'])); ?></p>
                        <div class="inquiry-meta"><span><?= e($item['email']); ?></span><span><?= e($item['phone']); ?></span><span><?= e($item['company']); ?></span><span><?= e($item['service']); ?></span></div>
                        <form method="post" class="d-flex gap-2 mt-3">
                            <input type="hidden" name="csrf_token" value="<?= e(csrf_token()); ?>">
                            <input type="hidden" name="id" value="<?= (int) $item['id']; ?>">
                            <button class="btn btn-outline-light btn-sm" name="action" value="toggle" type="submit">Mark <?= $item['is_read'] ? 'Unread' : 'Read'; ?></button>
                            <button class="btn btn-danger btn-sm" name="action" value="delete" type="submit" onclick="return confirm('Delete this inquiry?')">Delete</button>
                        </form>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</div>
</body>
</html>
