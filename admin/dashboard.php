<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_admin();
$total = (int) $pdo->query('SELECT COUNT(*) FROM inquiries')->fetchColumn();
$unread = (int) $pdo->query('SELECT COUNT(*) FROM inquiries WHERE is_read = 0')->fetchColumn();
$latest = $pdo->query('SELECT id, full_name, email, service, created_at, is_read FROM inquiries ORDER BY created_at DESC LIMIT 6')->fetchAll();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard | Mugah DeepTech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="admin-page">
<div class="admin-shell">
    <aside><a class="brand-mark" href="../index.php"><img class="logo-mark" src="../assets/images/mugah-deeptech-logo.svg" alt="" aria-hidden="true"><span class="brand-text">Mugah DeepTech</span></a><nav><a class="active" href="dashboard.php">Dashboard</a><a href="inquiries.php">Inquiries</a><a href="logout.php">Logout</a></nav></aside>
    <main>
        <div class="admin-top"><div><p class="eyebrow">Admin</p><h1>Dashboard</h1></div><a class="btn btn-outline-light" href="logout.php">Logout</a></div>
        <div class="row g-4 mb-4">
            <div class="col-md-4"><div class="glass-card stat-admin"><span>Total Inquiries</span><strong><?= $total; ?></strong></div></div>
            <div class="col-md-4"><div class="glass-card stat-admin"><span>Unread Inquiries</span><strong><?= $unread; ?></strong></div></div>
            <div class="col-md-4"><div class="glass-card stat-admin"><span>Latest Inquiries</span><strong><?= count($latest); ?></strong></div></div>
        </div>
        <div class="glass-card">
            <div class="d-flex justify-content-between align-items-center mb-3"><h2>Latest Inquiries</h2><a href="inquiries.php">View all</a></div>
            <div class="table-responsive"><table class="table table-dark table-hover align-middle"><thead><tr><th>Name</th><th>Email</th><th>Service</th><th>Status</th><th>Date</th></tr></thead><tbody>
                <?php foreach ($latest as $item): ?><tr><td><?= e($item['full_name']); ?></td><td><?= e($item['email']); ?></td><td><?= e($item['service']); ?></td><td><?= $item['is_read'] ? 'Read' : 'Unread'; ?></td><td><?= date('M d, Y H:i', strtotime($item['created_at'])); ?></td></tr><?php endforeach; ?>
            </tbody></table></div>
        </div>
    </main>
</div>
</body>
</html>
