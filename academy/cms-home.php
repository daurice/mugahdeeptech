<?php
$meta=['title'=>'Mugah DeepTech Academy | Choose Your Learning Path','description'=>'Kids, Business, and General Academy pathways for practical AI, data, coding, automation, and digital skills.'];
require_once __DIR__.'/../includes/academy-header.php';
require_once __DIR__.'/../includes/academy-cms-renderer.php';
render_cms_page($pdo,'academy_home','general');
include __DIR__.'/../includes/academy-footer.php';
