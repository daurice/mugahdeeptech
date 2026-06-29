<?php
$meta = ['title' => 'AI Kids Academy | Mugah DeepTech', 'description' => 'Fun, animated lessons that help kids learn coding, AI, creativity, and problem-solving.'];
require_once __DIR__ . '/../includes/kids-header.php';
$courses = kids_courses($pdo);
?>
<section class="kids-hero">
  <div class="hero-shape shape-one"></div><div class="hero-shape shape-two"></div>
  <div class="kids-container hero-grid">
    <div class="hero-copy reveal">
      <span class="kids-kicker">🌟 Learn • Play • Create</span>
      <h1>AI Kids <span>Academy</span></h1>
      <p>Fun, animated lessons that help kids learn coding, AI, creativity, and problem-solving.</p>
      <div class="hero-actions">
        <a class="kids-btn primary" href="<?= kids_url('course.php?slug=ai-for-beginners') ?>">Start Learning <span>→</span></a>
        <a class="kids-btn secondary" href="<?= kids_url('courses.php') ?>">View Courses</a>
        <a class="text-link" href="<?= kids_url('parents.php') ?>">Parent/Guardian Info</a>
      </div>
      <div class="trust-row"><span>✓ Safe & private</span><span>✓ Beginner friendly</span><span>✓ Learn at your pace</span></div>
    </div>
    <div class="hero-art reveal" data-delay="150">
      <div class="hero-art-card">
        <div class="art-stars">✦ <i>✦</i> ✦</div>
        <div class="avatar amani"><span class="avatar-hair"></span><span class="avatar-face">😊</span><span class="avatar-body">💻</span></div>
        <div class="avatar robo"><span class="robot-ear"></span><span class="robot-screen">•ᴗ•</span><span class="robot-body">AI</span></div>
        <span class="speech speech-one">Let’s teach Robo! 🍎</span><span class="speech speech-two">Pattern found! ✨</span>
        <div class="learning-floor"></div>
      </div>
      <div class="floating-chip chip-code">{ code }</div><div class="floating-chip chip-idea">💡 Big idea!</div>
    </div>
  </div>
  <div class="scroll-cue">Scroll to explore <span>↓</span></div>
</section>
<section class="kids-section" id="courses"><div class="kids-container">
  <div class="section-heading reveal"><div><span class="kids-kicker">Pick an adventure</span><h2>Six ways to grow your tech superpowers</h2></div><a class="round-link" href="<?= kids_url('courses.php') ?>">See all →</a></div>
  <div class="course-grid">
  <?php foreach ($courses as $i => $course): ?>
    <article class="kids-course-card reveal" style="--card-color:<?= e($course['theme_color']) ?>" data-delay="<?= ($i % 3) * 80 ?>">
      <div class="course-icon"><span><?= e($course['icon']) ?></span><i></i></div>
      <div class="course-tags"><span><?= e($course['age_group'] === 'All' ? 'All ages' : 'Ages ' . $course['age_group']) ?></span><span><?= e($course['difficulty']) ?></span></div>
      <h3><?= e($course['title']) ?></h3><p><?= e($course['short_description']) ?></p>
      <div class="course-bottom"><span>⏱ <?= e($course['duration']) ?></span><a href="<?= kids_url('course.php?slug=' . urlencode($course['slug'])) ?>">Start <b>→</b></a></div>
    </article>
  <?php endforeach; ?>
  </div>
</div></section>
<section class="story-band"><div class="kids-container story-grid">
  <div class="story-visual reveal"><?= kids_animation('robot') ?></div>
  <div class="story-copy reveal"><span class="kids-kicker light">Today’s story</span><h2>Meet Amani and Robo</h2><p>Amani has a curious question: can a robot learn to recognize fruit? Show Robo examples, test its guesses, and discover how AI learns patterns.</p><ul class="check-list"><li><span>1</span> Watch a tiny animated story</li><li><span>2</span> Try a hands-on matching game</li><li><span>3</span> Earn your AI Explorer badge</li></ul><a class="kids-btn sunny" href="<?= kids_url('course.php?slug=ai-for-beginners') ?>">Begin the story ✨</a></div>
</div></section>
<section class="kids-section soft-section"><div class="kids-container">
  <div class="section-heading centered reveal"><div><span class="kids-kicker">Learning that feels like play</span><h2>Tap, try, think, and celebrate</h2></div></div>
  <div class="feature-row"><article class="feature-card reveal"><span>🧲</span><h3>Match & move</h3><p>Drag ideas into place and see instant, friendly feedback.</p></article><article class="feature-card reveal"><span>🃏</span><h3>Flip & discover</h3><p>Animated flashcards turn new words into memorable ideas.</p></article><article class="feature-card reveal"><span>🏅</span><h3>Earn badges</h3><p>Every finished challenge adds a bright milestone to your journey.</p></article></div>
</div></section>
<section class="guardian-strip"><div class="kids-container guardian-inner"><div><span>🛡️</span><div><h2>Built with children’s safety in mind</h2><p>No public chat, minimal data, and clear guidance for parents and guardians.</p></div></div><a class="kids-btn secondary" href="<?= kids_url('parents.php') ?>">Read our safety promise</a></div></section>
<?php include __DIR__ . '/../includes/kids-footer.php'; ?>
