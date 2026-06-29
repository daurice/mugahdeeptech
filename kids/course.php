<?php
require_once __DIR__ . '/../includes/kids-header.php';
$course = kids_course_slug($pdo, (string)($_GET['slug'] ?? ''));
if (!$course) { http_response_code(404); exit('Course not found.'); }
$lessons = kids_lessons($pdo, (int)$course['id']);
$progress = learner_logged_in() ? kids_progress($pdo, learner_id(), (int)$course['id']) : ['percent'=>0,'done'=>0,'total'=>count($lessons)];
?>
<section class="course-hero" style="--course-color:<?= e($course['theme_color']) ?>"><div class="kids-container course-hero-grid">
  <div><a class="back-link" href="courses.php">← All courses</a><div class="course-tags"><span><?= e($course['age_group'] === 'All' ? 'All ages' : 'Ages ' . $course['age_group']) ?></span><span><?= e($course['difficulty']) ?></span></div><h1><span><?= e($course['icon']) ?></span> <?= e($course['title']) ?></h1><p><?= e($course['description']) ?></p><div class="hero-actions"><a class="kids-btn primary" href="<?= $lessons ? kids_url('lesson.php?id=' . (int)$lessons[0]['id']) : '#lessons' ?>">Start first lesson →</a><?php if (!learner_logged_in()): ?><a class="kids-btn secondary" href="<?= kids_url('join.php') ?>">Save my progress</a><?php endif; ?></div></div>
  <div class="course-progress-card"><span class="big-course-icon"><?= e($course['icon']) ?></span><h2>Your adventure</h2><div class="big-progress"><i style="width:<?= $progress['percent'] ?>%"></i></div><p><b><?= $progress['done'] ?></b> of <b><?= $progress['total'] ?></b> lessons complete</p><div class="course-facts"><span>⏱ <?= e($course['duration']) ?></span><span>🌱 Beginner</span><span>🏅 Badge rewards</span></div></div>
</div></section>
<section class="kids-section"><div class="kids-container two-col"><div>
  <span class="kids-kicker">Your lesson map</span><h2 id="lessons">Small steps, big discoveries</h2>
  <div class="lesson-list"><?php if (!$lessons): ?><div class="empty-card">New animated lessons are coming soon. Check back for your next adventure!</div><?php endif; ?><?php foreach ($lessons as $i=>$lesson): ?><a class="lesson-item reveal" href="<?= kids_url('lesson.php?id='.(int)$lesson['id']) ?>"><span class="lesson-number"><?= $i+1 ?></span><div><small><?= e($lesson['duration']) ?></small><h3><?= e($lesson['title']) ?></h3><p><?= e($lesson['story_title'] ?: 'A new learning adventure') ?></p></div><b>→</b></a><?php endforeach; ?></div>
  </div><aside class="outcomes-card"><span>🎒</span><h2>What you’ll learn</h2><ul><?php foreach (preg_split('/\r?\n/', (string)$course['learning_outcomes']) as $outcome): if (trim($outcome) !== ''): ?><li>✓ <?= e(trim($outcome)) ?></li><?php endif; endforeach; ?></ul><div class="safe-note"><b>🛡️ Safe learning</b><p>Ask a parent, guardian, or teacher whenever something online feels confusing.</p></div></aside>
</div></section>
<?php include __DIR__ . '/../includes/kids-footer.php'; ?>
