<?php
require_once __DIR__ . '/../includes/kids-header.php';
$lesson = kids_lesson($pdo, (int)($_GET['id'] ?? 0));
if (!$lesson) { http_response_code(404); exit('Lesson not found.'); }
$courseLessons = kids_lessons($pdo, (int)$lesson['course_id']);
$activities = kids_activities($pdo, (int)$lesson['id']);
$quiz = kids_quiz($pdo, (int)$lesson['id']);
$index = 0;
foreach ($courseLessons as $i=>$row) if ((int)$row['id'] === (int)$lesson['id']) $index=$i;
$prev=$courseLessons[$index-1]??null; $next=$courseLessons[$index+1]??null;
if ($_SERVER['REQUEST_METHOD']==='POST' && verify_csrf($_POST['csrf_token']??null) && learner_logged_in()) {
    mark_kids_progress($pdo,learner_id(),(int)$lesson['course_id'],(int)$lesson['id'],null);
    header('Location: lesson.php?id='.(int)$lesson['id'].'&complete=1'); exit;
}
$percent=count($courseLessons)?(int)round(($index+1)*100/count($courseLessons)):0;
?>
<div class="lesson-top">
  <a class="kids-brand" href="<?= kids_url('index.php') ?>"><span class="brand-bot">🤖</span><span>AI Kids <b>Academy</b></span></a>
  <div><span>Lesson <?= $index+1 ?> of <?= count($courseLessons) ?></span><div class="lesson-progress"><i style="width:<?= $percent ?>%"></i></div></div>
  <a class="close-lesson" href="<?= kids_url('course.php?slug='.urlencode($lesson['course_slug'])) ?>">×</a>
</div>
<article class="animated-lesson">
  <header class="lesson-title"><div><span class="kids-kicker"><?= e($lesson['course_icon']) ?> <?= e($lesson['course_title']) ?></span><h1><?= e($lesson['title']) ?></h1><p>⏱ <?= e($lesson['duration']) ?></p></div><button class="narrate-btn" type="button" data-narration="<?= e($lesson['narration_text']) ?>">🔊 Listen to this lesson</button></header>
  <section class="teacher-story"><div class="teacher-avatar"><div class="teacher-head">😊</div><div class="teacher-body">AMANI</div><span class="teacher-wave">👋</span></div><div class="story-bubble"><span>Story time</span><h2><?= e($lesson['story_title'] ?: $lesson['title']) ?></h2><p><?= nl2br(e($lesson['story_text'])) ?></p></div></section>
  <?php if ($lesson['animation_type']==='lottie' && $lesson['animation_source']): ?>
    <div class="external-animation"><lottie-player src="<?= e($lesson['animation_source']) ?>" background="transparent" speed="1" loop autoplay></lottie-player></div>
  <?php elseif ($lesson['animation_type']==='video' && ($lesson['media_path']||$lesson['animation_source'])): ?>
    <video class="lesson-video" controls preload="metadata" src="<?= e($lesson['media_path']?site_url($lesson['media_path']):$lesson['animation_source']) ?>"></video>
  <?php elseif ($lesson['animation_type']==='image' && $lesson['media_path']): ?>
    <img class="lesson-image" src="<?= e(site_url($lesson['media_path'])) ?>" alt="Lesson illustration">
  <?php else: ?><?= kids_animation($lesson['animation_type']) ?><?php endif; ?>
  <section class="learning-steps"><div class="section-heading centered"><div><span class="kids-kicker">Let’s break it down</span><h2>Three bright ideas</h2></div></div><div class="step-grid">
  <?php foreach (kids_learning_blocks($lesson) as $i=>$block): ?><article class="step-card reveal"><span><?= ['👀','🧠','✨','🚀'][$i%4] ?></span><small>Step <?= $i+1 ?></small><h3><?= e((string)($block['title']??'Discover')) ?></h3><p><?= e((string)($block['text']??'')) ?></p></article><?php endforeach; ?>
  </div></section>
  <?php if ($activities): ?><section class="activity-preview"><span class="kids-kicker">Now you try</span><h2>Choose an activity</h2><div class="activity-grid"><?php foreach ($activities as $activity): ?><a class="activity-card" href="<?= kids_url('activity.php?id='.(int)$activity['id']) ?>"><span><?= ['matching'=>'🧲','flashcards'=>'🃏','coding'=>'🧩','quiz'=>'❓'][$activity['activity_type']]??'🎯' ?></span><div><small><?= e(ucfirst($activity['activity_type'])) ?></small><h3><?= e($activity['title']) ?></h3><p><?= e($activity['instructions']) ?></p></div><b>Play →</b></a><?php endforeach; ?></div></section><?php endif; ?>
  <section class="lesson-finish"><div><span>⭐</span><h2>Great exploring!</h2><p><?= learner_logged_in()?'Mark this lesson complete to save your star.':'You can play freely. Join with a grown-up to save stars and badges.' ?></p></div><?php if (learner_logged_in()): ?><form method="post"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><button class="kids-btn primary">Mark lesson complete ✓</button></form><?php else: ?><a class="kids-btn primary" href="<?= kids_url('join.php') ?>">Save my progress</a><?php endif; ?><?php if ($quiz): ?><a class="kids-btn secondary" href="<?= kids_url('quiz.php?lesson='.(int)$lesson['id']) ?>">Take the quiz ❓</a><?php endif; ?></section>
  <nav class="lesson-nav"><?php if ($prev): ?><a href="<?= kids_url('lesson.php?id='.(int)$prev['id']) ?>">← <span>Back<small><?= e($prev['title']) ?></small></span></a><?php else: ?><span></span><?php endif; ?><?php if ($next): ?><a class="next" href="<?= kids_url('lesson.php?id='.(int)$next['id']) ?>"><span>Next<small><?= e($next['title']) ?></small></span> →</a><?php else: ?><a class="next" href="<?= kids_url('course.php?slug='.urlencode($lesson['course_slug'])) ?>"><span>Course map<small>See your adventure</small></span> →</a><?php endif; ?></nav>
</article>
<?php include __DIR__ . '/../includes/kids-footer.php'; ?>
