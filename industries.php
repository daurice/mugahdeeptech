<?php
require_once __DIR__ . '/includes/functions.php';
$meta = page_meta('Industries', 'AI, analytics, automation, and digital transformation for finance, healthcare, agriculture, retail, manufacturing, education, government, NGOs, and telecoms.');
include __DIR__ . '/includes/header.php';
$industries = ['Finance', 'Healthcare', 'Agriculture', 'Retail', 'Manufacturing', 'Education', 'Government', 'NGOs', 'Telecommunications'];
?>
<section class="page-hero"><div class="container"><p class="eyebrow">Industries</p><h1>DeepTech strategy for high-impact sectors.</h1><p>We adapt AI and data systems to the language, risks, and economics of each industry.</p></div></section>
<section class="section-pad">
    <div class="container">
        <div class="row g-4">
            <?php foreach ($industries as $industry): ?>
                <div class="col-md-6 col-lg-4"><div class="glass-card h-100"><h2><?= e($industry); ?></h2><p>Analytics, automation, forecasting, intelligence workflows, and governance designed for real-world teams and measurable outcomes.</p></div></div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
