<?php
$meta=['title'=>'AI Kids Academy | Mugah DeepTech','description'=>'Fun, safe, animated learning in AI, coding, creativity, digital literacy, robotics, and problem-solving.'];
require_once __DIR__.'/../includes/kids-header.php';
require_once __DIR__.'/../includes/academy-cms-renderer.php';
render_cms_page($pdo,'kids_home','kids');
include __DIR__.'/../includes/kids-footer.php';
