<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$meta = page_meta('Case Studies', 'AI, automation, and analytics case studies from Mugah DeepTech.');
$stmt = $pdo->query('SELECT title, industry, summary, result_metric, created_at FROM case_studies WHERE published = 1 ORDER BY created_at DESC');
$cases = $stmt->fetchAll();
include __DIR__ . '/includes/header.php';
?>
<section class="page-hero"><div class="container"><p class="eyebrow">Case Studies</p><h1>Selected transformation stories.</h1><p>Representative examples of how AI, analytics, and automation create measurable business value.</p></div></section>
<section class="section-pad">
    <div class="container">
        <div class="row g-4">
            <?php foreach ($cases as $case): ?>
                <div class="col-md-6 col-lg-4"><article class="glass-card h-100"><span class="tag"><?= e($case['industry']); ?></span><h2><?= e($case['title']); ?></h2><p><?= e($case['summary']); ?></p><strong class="result"><?= e($case['result_metric']); ?></strong></article></div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
