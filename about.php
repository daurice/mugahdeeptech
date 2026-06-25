<?php
require_once __DIR__ . '/includes/functions.php';
$meta = page_meta('About', 'Learn about Mugah DeepTech, a Nairobi-based AI and data consulting company building intelligent businesses.');
include __DIR__ . '/includes/header.php';
?>
<section class="page-hero">
    <div class="container">
        <p class="eyebrow">About Mugah DeepTech</p>
        <h1>We help leaders turn AI ambition into operating advantage.</h1>
        <p>Mugah DeepTech is an AI, data, and automation consulting company based in Nairobi, Kenya. We partner with ambitious organizations to modernize decision-making, streamline operations, and build intelligent products.</p>
    </div>
</section>
<section class="section-pad">
    <div class="container">
        <div class="row g-4 align-items-stretch">
            <div class="col-lg-6"><div class="glass-card h-100"><h2>Our Mission</h2><p>To make advanced AI and data capabilities practical, trusted, and commercially valuable for organizations across Africa and global markets.</p></div></div>
            <div class="col-lg-6"><div class="glass-card h-100"><h2>How We Work</h2><p>We combine executive strategy, modern data architecture, secure engineering, and hands-on team enablement so solutions survive beyond the pilot stage.</p></div></div>
        </div>
    </div>
</section>
<section class="section-pad surface-band">
    <div class="container">
        <div class="section-head"><p class="eyebrow">Principles</p><h2>Premium consulting with practical delivery discipline.</h2></div>
        <div class="row g-4">
            <?php foreach (['Business-first AI', 'Secure by design', 'Measurable ROI', 'Human adoption', 'Governed data', 'Long-term capability'] as $item): ?>
                <div class="col-md-4"><div class="glass-card h-100"><h3><?= e($item); ?></h3><p>Every engagement is shaped by strategic clarity, technical rigor, and the realities of implementation.</p></div></div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
