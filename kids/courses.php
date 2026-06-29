<?php
$meta = ['title' => 'Kids Courses | AI Kids Academy', 'description' => 'Explore beginner courses in AI, coding, internet safety, robotics, computers, and digital creativity.'];
require_once __DIR__ . '/../includes/kids-header.php';
$courses = kids_courses($pdo);
$age = (string)($_GET['age'] ?? 'All');
?>
<section class="page-banner"><div class="kids-container">
  <span class="kids-kicker">Choose your next quest</span>
  <h1>Learning adventures for every curious mind</h1>
  <p>All courses are beginner-friendly, short, animated, and made for learning one joyful step at a time.</p>
  <div class="filter-pills" role="group" aria-label="Filter by age"><a class="<?= $age === 'All' ? 'active' : '' ?>" href="courses.php">All ages</a><?php foreach (['6-8','9-12','13-15'] as $group): ?><a class="<?= $age === $group ? 'active' : '' ?>" href="?age=<?= e($group) ?>">Ages <?= e($group) ?></a><?php endforeach; ?></div>
</div></section>
<section class="kids-section"><div class="kids-container"><div class="course-grid">
<?php foreach ($courses as $course): if ($age !== 'All' && $course['age_group'] !== $age && $course['age_group'] !== 'All') continue; ?>
  <article class="kids-course-card reveal" style="--card-color:<?= e($course['theme_color']) ?>">
    <div class="course-icon"><span><?= e($course['icon']) ?></span><i></i></div>
    <div class="course-tags"><span><?= e($course['age_group'] === 'All' ? 'All ages' : 'Ages ' . $course['age_group']) ?></span><span><?= e($course['difficulty']) ?></span></div>
    <h2><?= e($course['title']) ?></h2><p><?= e($course['short_description']) ?></p>
    <div class="course-bottom"><span>⏱ <?= e($course['duration']) ?></span><a href="<?= kids_url('course.php?slug=' . urlencode($course['slug'])) ?>">Start <b>→</b></a></div>
  </article>
<?php endforeach; ?>
</div></div></section>
<?php include __DIR__ . '/../includes/kids-footer.php'; ?>
