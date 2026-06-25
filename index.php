<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$meta = page_meta('AI That Drives Business Growth', 'Premium AI and data consulting for strategy, analytics, automation, dashboards, machine learning, and digital transformation.');
$services = service_options();
$industries = ['Finance', 'Healthcare', 'Agriculture', 'Retail', 'Manufacturing', 'Education', 'Government', 'NGOs', 'Telecommunications'];
$caseStudies = get_recent_case_studies($pdo);
include __DIR__ . '/includes/header.php';
?>
<section class="hero ai-grid">
    <canvas id="particleCanvas" aria-hidden="true"></canvas>
    <div class="container hero-content">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <p class="eyebrow">Nairobi AI & Data Consulting</p>
                <h1>AI That Drives Business Growth</h1>
                <p class="hero-copy">We help organizations use Artificial Intelligence, Data Analytics, Automation, and Machine Learning to increase revenue, reduce costs, improve decisions, and scale intelligently.</p>
                <div class="d-flex flex-wrap gap-3 mt-4">
                    <a class="btn btn-premium btn-lg" href="<?= site_url('contact.php'); ?>">Book Consultation</a>
                    <a class="btn btn-outline-light btn-lg" href="<?= site_url('solutions.php'); ?>">View Solutions</a>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="dashboard-preview reveal">
                    <div class="dash-top"><span></span><span></span><span></span></div>
                    <div class="dash-grid">
                        <div class="metric-card"><small>Revenue Lift</small><strong>+32%</strong><div class="mini-line"></div></div>
                        <div class="metric-card"><small>Automation ROI</small><strong>4.8x</strong><div class="mini-bars"><i></i><i></i><i></i><i></i></div></div>
                        <div class="chart-card"><div class="chart-wave"></div></div>
                        <div class="metric-card accent"><small>Decision Speed</small><strong>68%</strong><div class="pulse-dot"></div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-pad">
    <div class="container">
        <div class="section-head">
            <p class="eyebrow">Services</p>
            <h2>Enterprise-grade intelligence, delivered practically.</h2>
            <p>From strategy to deployed models, we turn data into measurable operating advantage.</p>
        </div>
        <div class="row g-4">
            <?php foreach ($services as $service): ?>
                <div class="col-md-6 col-lg-3">
                    <div class="glass-card service-card compact h-100 reveal">
                        <?= service_visual($service); ?>
                        <h3><?= e($service); ?></h3>
                        <p>Executive-ready consulting, architecture, implementation, and enablement tailored to your business context.</p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section-pad surface-band">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5">
                <p class="eyebrow">Industries</p>
                <h2>Built for complex, high-impact sectors.</h2>
                <p>We design AI systems that respect operational reality, governance, local markets, and measurable value creation.</p>
                <a class="btn btn-outline-light mt-3" href="<?= site_url('industries.php'); ?>">Explore Industries</a>
            </div>
            <div class="col-lg-7">
                <div class="industry-cloud">
                    <?php foreach ($industries as $industry): ?>
                        <span><?= e($industry); ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-pad">
    <div class="container">
        <div class="stats-strip reveal">
            <div><strong data-count="42">0</strong><span>AI & analytics projects shaped</span></div>
            <div><strong data-count="18">0</strong><span>Industries advised</span></div>
            <div><strong data-count="35">0</strong><span>Average workflow hours saved weekly</span></div>
            <div><strong data-count="99">0</strong><span>Decision confidence focus</span></div>
        </div>
    </div>
</section>

<section class="section-pad surface-band">
    <div class="container">
        <div class="section-head">
            <p class="eyebrow">Case Studies</p>
            <h2>Proof, not theatre.</h2>
        </div>
        <div class="row g-4">
            <?php foreach ($caseStudies as $case): ?>
                <div class="col-md-4">
                    <article class="glass-card h-100 reveal">
                        <span class="tag"><?= e($case['industry']); ?></span>
                        <h3><?= e($case['title']); ?></h3>
                        <p><?= e($case['summary']); ?></p>
                        <strong class="result"><?= e($case['result_metric']); ?></strong>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section-pad">
    <div class="container">
        <div class="section-head">
            <p class="eyebrow">Process</p>
            <h2>A clear path from ambition to adoption.</h2>
        </div>
        <div class="timeline">
            <?php foreach (['Discover value levers', 'Design the data and AI roadmap', 'Build pilots with measurable ROI', 'Deploy, train, and govern at scale'] as $i => $step): ?>
                <div class="timeline-item reveal"><span>0<?= $i + 1; ?></span><h3><?= e($step); ?></h3><p>Each phase aligns leaders, data, technology, and teams around outcomes that matter.</p></div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section-pad surface-band">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4"><div class="quote-card">“Mugah DeepTech helped us convert scattered reporting into executive dashboards our teams actually use.”<span>Operations Director</span></div></div>
            <div class="col-lg-4"><div class="quote-card">“Their AI roadmap was grounded, commercial, and clear enough for board approval.”<span>Financial Services CEO</span></div></div>
            <div class="col-lg-4"><div class="quote-card">“The automation work reduced manual processing and gave managers visibility we never had.”<span>Retail Group Lead</span></div></div>
        </div>
    </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
