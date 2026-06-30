<?php
declare(strict_types=1);
require_once __DIR__.'/functions.php';

function cms_sections(PDO $pdo,string $pageKey,bool $active=true): array {
  $sql='SELECT s.*,m.file_path,m.file_type,m.alt_text,a.name avatar_name,a.role avatar_role,a.animation_url avatar_animation,am.file_path avatar_path FROM site_sections s LEFT JOIN media_library m ON m.id=s.media_id LEFT JOIN avatars a ON a.id=s.avatar_id LEFT JOIN media_library am ON am.id=a.media_id WHERE s.page_key=?'.($active?' AND s.is_active=1':'').' ORDER BY s.sort_order,s.id';
  $stmt=$pdo->prepare($sql);$stmt->execute([$pageKey]);$rows=$stmt->fetchAll();
  foreach($rows as &$row){$stmt=$pdo->prepare('SELECT c.*,m.file_path,m.file_type,m.alt_text FROM section_components c LEFT JOIN media_library m ON m.id=c.media_id WHERE c.section_id=?'.($active?' AND c.is_active=1':'').' ORDER BY c.sort_order,c.id');$stmt->execute([(int)$row['id']]);$row['components']=$stmt->fetchAll();}
  return $rows;
}
function cms_pathways(PDO $pdo,bool $active=true): array { return $pdo->query('SELECT p.*,m.file_path,m.file_type,m.alt_text FROM academy_pathways p LEFT JOIN media_library m ON m.id=p.media_id'.($active?' WHERE p.is_active=1':'').' ORDER BY p.sort_order,p.id')->fetchAll(); }
function cms_setting(PDO $pdo,string $key,string $fallback=''): string { $s=$pdo->prepare("SELECT setting_value FROM settings WHERE setting_group='academy' AND setting_key=? LIMIT 1");$s->execute([$key]);$v=$s->fetchColumn();return $v===false?$fallback:(string)$v; }
function cms_json(?string $json,array $fallback=[]): array { $data=json_decode((string)$json,true);return is_array($data)?$data:$fallback; }
function cms_media(array $item,string $class='cms-media'): string { if(empty($item['file_path']))return '';$src=site_url($item['file_path']);$alt=e($item['alt_text']??$item['title']??'Academy media');$type=$item['file_type']??'image';if($type==='video')return '<video class="'.e($class).'" autoplay muted loop playsinline src="'.e($src).'"></video>';if($type==='lottie')return '<lottie-player class="'.e($class).'" src="'.e($src).'" background="transparent" speed="1" loop autoplay></lottie-player>';return '<img class="'.e($class).'" src="'.e($src).'" alt="'.$alt.'">'; }
function cms_admin_upload(string $field): ?array {
  if(empty($_FILES[$field]['tmp_name'])||!is_uploaded_file($_FILES[$field]['tmp_name']))return null;
  $allowed=['image/jpeg'=>['jpg','image'],'image/png'=>['png','image'],'image/webp'=>['webp','image'],'image/gif'=>['gif','gif'],'video/mp4'=>['mp4','video'],'application/json'=>['json','lottie'],'audio/mpeg'=>['mp3','audio'],'audio/wav'=>['wav','audio'],'application/pdf'=>['pdf','pdf'],'text/csv'=>['csv','template'],'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'=>['xlsx','template'],'application/vnd.openxmlformats-officedocument.wordprocessingml.document'=>['docx','template']];
  $mime=(new finfo(FILEINFO_MIME_TYPE))->file($_FILES[$field]['tmp_name']);if(!isset($allowed[$mime])||(int)$_FILES[$field]['size']>20*1024*1024)throw new RuntimeException('Upload an approved image, GIF, MP4, Lottie JSON, audio, PDF, Word, Excel, or CSV file under 20 MB.');
  [$ext,$type]=$allowed[$mime];$dir=dirname(__DIR__).'/assets/uploads/academy';if(!is_dir($dir))mkdir($dir,0755,true);$name=bin2hex(random_bytes(12)).'.'.$ext;if(!move_uploaded_file($_FILES[$field]['tmp_name'],$dir.'/'.$name))throw new RuntimeException('Upload could not be saved.');return ['path'=>'assets/uploads/academy/'.$name,'type'=>$type,'mime'=>$mime,'size'=>(int)$_FILES[$field]['size']];
}
function cms_course_cards(PDO $pdo,string $pathway): array {
  if($pathway==='Kids')$base="SELECT c.id,c.title,c.slug,c.short_description description,c.age_group audience,c.difficulty level,c.duration,c.icon,c.theme_color accent,c.status,c.sort_order FROM kids_courses c";
  elseif($pathway==='Business')$base="SELECT c.id,c.title,c.slug,c.short_description description,c.target_role audience,c.level,c.duration,c.icon,c.accent_color accent,c.status,c.sort_order FROM business_courses c";
  else $base="SELECT c.id,c.title,c.slug,c.short_description description,c.target_audience audience,c.level,c.duration,'◈' icon,'#38bdf8' accent,c.status,c.id sort_order FROM lms_courses c";
  $sql='SELECT x.*,d.category,d.animation_url,d.price_type,d.price,d.button_text,d.is_active card_active,COALESCE(d.sort_order,x.sort_order) display_order,m.file_path,m.file_type,m.alt_text FROM ('.$base.') x LEFT JOIN course_card_settings d ON d.pathway=? AND d.course_id=x.id LEFT JOIN media_library m ON m.id=d.media_id WHERE x.status="Published" AND COALESCE(d.is_active,1)=1 ORDER BY display_order,x.id';$s=$pdo->prepare($sql);$s->execute([$pathway]);return $s->fetchAll();
}
function cms_media_options(PDO $pdo): array { return $pdo->query('SELECT * FROM media_library WHERE is_active=1 ORDER BY created_at DESC')->fetchAll(); }
function cms_avatar_options(PDO $pdo): array { return $pdo->query('SELECT a.*,m.file_path FROM avatars a LEFT JOIN media_library m ON m.id=a.media_id WHERE a.is_active=1 ORDER BY a.learner_type,a.sort_order')->fetchAll(); }
