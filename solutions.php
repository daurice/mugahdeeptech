<?php
require_once __DIR__ . '/includes/functions.php';
$meta = page_meta('Solutions', 'AI solutions for customer support, fraud detection, forecasting, inventory, sales intelligence, HR, documents, recommendations, and maintenance.');
include __DIR__ . '/includes/header.php';
$solutions = ['Customer Support AI', 'Fraud Detection', 'Demand Forecasting', 'Inventory Optimization', 'Sales Intelligence', 'HR Automation', 'Document Intelligence', 'Recommendation Engines', 'Predictive Maintenance'];
?>
<section class="page-hero"><div class="container"><p class="eyebrow">Solutions</p><h1>Deployable AI systems for revenue, risk, and operations.</h1><p>Each solution is tailored to your data maturity, compliance needs, and operational workflow.</p></div></section>
<section class="section-pad">
    <div class="container">
        <div class="row g-4">
            <?php foreach ($solutions as $solution): ?>
                <div class="col-md-6 col-lg-4"><div class="glass-card h-100"><span class="tag">AI Solution</span><h2><?= e($solution); ?></h2><p>Design, prototype, integrate, and scale a practical solution that improves performance and gives leaders clearer decisions.</p></div></div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
