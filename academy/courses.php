<?php
require_once __DIR__ . '/../includes/academy-header.php';
$courses = get_courses($pdo);
$categories = academy_categories();
?>
<section class="page-hero academy-page-hero"><div class="container"><p class="eyebrow">Course Catalog</p><h1>Choose your AI and data learning path.</h1><p>Beginner-friendly courses with practical examples for African businesses, careers, and digital transformation projects.</p></div></section>
<section class="section-pad"><div class="container"><div class="industry-cloud mb-4"><?php foreach ($categories as $cat): ?><span><?= e($cat); ?></span><?php endforeach; ?></div><div class="row g-4">
<?php foreach ($courses as $course): ?><div class="col-md-6 col-lg-4"><article class="glass-card academy-course-card h-100"><span class="tag"><?= e($course['category_name']); ?></span><h2><?= e($course['title']); ?></h2><p><?= e($course['short_description']); ?></p><div class="course-meta"><span><?= e($course['level']); ?></span><span><?= (int)$course['lesson_count']; ?> lessons</span><span><?= e($course['duration']); ?></span></div><a class="btn btn-premium w-100 mt-3" href="course.php?slug=<?= e($course['slug']); ?>">Start Learning</a></article></div><?php endforeach; ?>
</div></div></section>
<?php include __DIR__ . '/../includes/academy-footer.php'; ?>