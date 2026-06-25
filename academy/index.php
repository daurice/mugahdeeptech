<?php
require_once __DIR__ . '/../includes/academy-header.php';
$courses = get_courses($pdo);
?>
<section class="academy-hero">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <p class="eyebrow">Mugah DeepTech Academy</p>
                <h1>Learn AI. Master Data. Build Intelligent Solutions.</h1>
                <p>Practical AI, analytics, machine learning, generative AI, and automation training for African learners, SMEs, professionals, students, and business leaders.</p>
                <div class="d-flex flex-wrap gap-3 mt-4"><a class="btn btn-premium btn-lg" href="courses.php">Explore Courses</a><a class="btn btn-outline-light btn-lg" href="register.php">Create Account</a></div>
            </div>
            <div class="col-lg-5"><div class="academy-orb-card"><span>AI</span><span>Data</span><span>ML</span><span>Automation</span><strong><?= count($courses); ?> Courses</strong></div></div>
        </div>
    </div>
</section>
<section class="section-pad"><div class="container"><div class="section-head"><p class="eyebrow">Learning Tracks</p><h2>Build skills that turn strategy into delivery.</h2></div><div class="row g-4">
<?php foreach (array_slice($courses,0,6) as $course): ?><div class="col-md-6 col-lg-4"><article class="glass-card academy-course-card h-100"><span class="tag"><?= e($course['category_name']); ?></span><h3><?= e($course['title']); ?></h3><p><?= e($course['short_description']); ?></p><div class="course-meta"><span><?= e($course['level']); ?></span><span><?= e($course['duration']); ?></span></div><a class="btn btn-outline-light w-100 mt-3" href="course.php?slug=<?= e($course['slug']); ?>">View Course</a></article></div><?php endforeach; ?>
</div></div></section>
<?php include __DIR__ . '/../includes/academy-footer.php'; ?>