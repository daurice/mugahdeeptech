<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$meta = page_meta('Insights', 'Insights on AI strategy, data analytics, machine learning, automation, and digital transformation.');
$stmt = $pdo->query('SELECT title, category, excerpt, created_at FROM blog_posts WHERE published = 1 ORDER BY created_at DESC');
$posts = $stmt->fetchAll();
include __DIR__ . '/includes/header.php';
?>
<section class="page-hero"><div class="container"><p class="eyebrow">Insights</p><h1>Executive ideas on AI, data, and automation.</h1><p>Practical thinking for leaders building intelligent organizations.</p></div></section>
<section class="section-pad">
    <div class="container">
        <div class="row g-4">
            <?php foreach ($posts as $post): ?>
                <div class="col-md-6 col-lg-4"><article class="glass-card h-100"><span class="tag"><?= e($post['category']); ?></span><h2><?= e($post['title']); ?></h2><p><?= e($post['excerpt']); ?></p><small><?= date('M d, Y', strtotime($post['created_at'])); ?></small></article></div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
