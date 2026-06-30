<?php
$meta=['title'=>'Business AI Academy | Mugah DeepTech','description'=>'Practical animated AI, analytics, automation, marketing, and digital business learning for entrepreneurs and teams.'];
require_once __DIR__.'/../includes/business-header.php';
require_once __DIR__.'/../includes/academy-cms-renderer.php';
render_cms_page($pdo,'business_home','business');
include __DIR__.'/../includes/business-footer.php';
