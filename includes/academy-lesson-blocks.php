<?php
declare(strict_types=1);
require_once __DIR__.'/academy-cms-functions.php';
function render_managed_lesson_content(PDO $pdo,string $pathway,int $lessonId): void {
  $s=$pdo->prepare('SELECT c.*,a.name avatar_name,a.role avatar_role,a.animation_url,am.file_path avatar_path,n.file_path narration_path FROM lesson_content_settings c LEFT JOIN avatars a ON a.id=c.avatar_id LEFT JOIN media_library am ON am.id=a.media_id LEFT JOIN media_library n ON n.id=c.narration_media_id WHERE c.pathway=? AND c.lesson_id=? AND c.is_active=1');$s->execute([$pathway,$lessonId]);$settings=$s->fetch();
  $s=$pdo->prepare('SELECT b.*,m.file_path,m.file_type,m.alt_text FROM lesson_blocks b LEFT JOIN media_library m ON m.id=b.media_id WHERE b.pathway=? AND b.lesson_id=? AND b.is_active=1 ORDER BY b.sort_order,b.id');$s->execute([$pathway,$lessonId]);$blocks=$s->fetchAll();if(!$settings&&!$blocks)return;
  echo '<section class="managed-lesson-content"><div class="managed-content-head">';
  if($settings&&!empty($settings['avatar_path']))echo '<img src="'.e(site_url($settings['avatar_path'])).'" alt="'.e($settings['avatar_name']).'">';
  elseif($settings&&!empty($settings['animation_url']))echo '<lottie-player src="'.e($settings['animation_url']).'" loop autoplay></lottie-player>';
  if($settings)echo '<div><small>ASSIGNED LEARNING GUIDE</small><h2>'.e($settings['avatar_name']??'Academy Guide').'</h2><p>'.e($settings['avatar_role']??'Lesson facilitator').'</p></div>';
  echo '</div>';
  if($settings&&!empty($settings['narration_path']))echo '<div class="managed-audio"><b>Voice narration</b><audio controls preload="metadata" src="'.e(site_url($settings['narration_path'])).'"></audio></div>';
  foreach($blocks as $b){echo '<article class="managed-block managed-'.$b['block_type'].'">';if($b['title'])echo '<h3>'.e($b['title']).'</h3>';if($b['body_text'])echo '<p>'.nl2br(e($b['body_text'])).'</p>';if($b['file_path'])echo cms_media($b,'managed-block-media');if($b['button_text']&&$b['button_link'])echo '<a class="managed-block-btn" href="'.e($b['button_link']).'">'.e($b['button_text']).'</a>';echo '</article>';}
  echo '</section>';
}