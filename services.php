<?php
require_once __DIR__ . '/includes/functions.php';
$meta = page_meta('Services', 'AI strategy, data analytics, dashboards, machine learning, generative AI, automation, data engineering, and training services.');
include __DIR__ . '/includes/header.php';
$descriptions = [
    'AI Strategy' => 'AI opportunity mapping, board advisory, governance, operating models, and implementation roadmaps.',
    'Data Analytics' => 'Commercial analytics, KPI design, forecasting, segmentation, and decision intelligence.',
    'Business Intelligence Dashboards' => 'Executive dashboards, operational scorecards, self-service BI, and reporting modernization.',
    'Machine Learning Solutions' => 'Predictive models, optimization engines, classification systems, and production model workflows.',
    'Generative AI Assistants' => 'Secure assistants for support, knowledge management, sales, research, and internal operations.',
    'Business Process Automation' => 'Workflow automation, approvals, document routing, integrations, and productivity systems.',
    'Data Engineering' => 'Pipelines, warehouses, lakehouses, data quality, integration, and scalable analytics foundations.',
    'AI Training & Workshops' => 'Executive briefings, team enablement, prompt engineering, analytics fluency, and AI adoption programs.',
];
?>
<section class="page-hero"><div class="container"><p class="eyebrow">Services</p><h1>AI and data services for serious business outcomes.</h1><p>We advise, design, build, and train so intelligence becomes embedded in the way your organization works.</p></div></section>
<section class="section-pad">
    <div class="container">
        <div class="row g-4">
            <?php foreach ($descriptions as $name => $desc): ?>
                <div class="col-md-6"><div class="glass-card service-card h-100"><?= service_visual($name); ?><h2><?= e($name); ?></h2><p><?= e($desc); ?></p><a href="<?= site_url('contact.php'); ?>">Discuss this service</a></div></div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
