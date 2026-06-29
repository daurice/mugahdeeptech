<?php
declare(strict_types=1);

require_once __DIR__ . '/functions.php';

function kids_url(string $path = ''): string { return site_url('kids/' . ltrim($path, '/')); }
function kids_courses(PDO $pdo, bool $publishedOnly = true): array {
    $sql = 'SELECT c.*, COUNT(DISTINCT l.id) lesson_count FROM kids_courses c LEFT JOIN kids_lessons l ON l.course_id=c.id';
    if ($publishedOnly) $sql .= " WHERE c.status='Published'";
    $sql .= ' GROUP BY c.id ORDER BY c.sort_order,c.id';
    return $pdo->query($sql)->fetchAll();
}
function kids_course(PDO $pdo, int $id): ?array { $s=$pdo->prepare('SELECT * FROM kids_courses WHERE id=? LIMIT 1');$s->execute([$id]);return $s->fetch()?:null; }
function kids_course_slug(PDO $pdo, string $slug): ?array { $s=$pdo->prepare('SELECT * FROM kids_courses WHERE slug=? LIMIT 1');$s->execute([$slug]);return $s->fetch()?:null; }
function kids_lessons(PDO $pdo, int $courseId, bool $publishedOnly=true): array { $sql='SELECT * FROM kids_lessons WHERE course_id=?'.($publishedOnly?" AND status='Published'":'').' ORDER BY sort_order,id';$s=$pdo->prepare($sql);$s->execute([$courseId]);return $s->fetchAll(); }
function kids_lesson(PDO $pdo, int $id): ?array { $s=$pdo->prepare('SELECT l.*,c.title course_title,c.slug course_slug,c.theme_color,c.icon course_icon FROM kids_lessons l JOIN kids_courses c ON c.id=l.course_id WHERE l.id=? LIMIT 1');$s->execute([$id]);return $s->fetch()?:null; }
function kids_activities(PDO $pdo, int $lessonId): array { $s=$pdo->prepare("SELECT a.*,b.name badge_name,b.icon badge_icon FROM kids_activities a LEFT JOIN badges b ON b.id=a.badge_id WHERE a.lesson_id=? AND a.status='Published' ORDER BY a.sort_order,a.id");$s->execute([$lessonId]);return $s->fetchAll(); }
function kids_activity(PDO $pdo, int $id): ?array { $s=$pdo->prepare('SELECT a.*,c.title course_title,c.theme_color,l.title lesson_title,b.name badge_name,b.icon badge_icon FROM kids_activities a JOIN kids_courses c ON c.id=a.course_id LEFT JOIN kids_lessons l ON l.id=a.lesson_id LEFT JOIN badges b ON b.id=a.badge_id WHERE a.id=? LIMIT 1');$s->execute([$id]);return $s->fetch()?:null; }
function kids_quiz(PDO $pdo, int $lessonId): ?array { $s=$pdo->prepare("SELECT q.*,b.name badge_name,b.icon badge_icon FROM kids_quizzes q LEFT JOIN badges b ON b.id=q.badge_id WHERE q.lesson_id=? AND q.status='Published' LIMIT 1");$s->execute([$lessonId]);$q=$s->fetch();if(!$q)return null;$s=$pdo->prepare('SELECT * FROM kids_quiz_questions WHERE quiz_id=? ORDER BY sort_order,id');$s->execute([$q['id']]);$q['questions']=$s->fetchAll();return $q; }
function kids_json(?string $json, array $fallback=[]): array { $data=json_decode((string)$json,true);return is_array($data)?$data:$fallback; }
function kids_learning_blocks(array $lesson): array { return kids_json($lesson['learning_blocks'] ?? '', [['title'=>'Discover','text'=>$lesson['story_text'] ?? '']]); }
function kids_progress(PDO $pdo, int $learnerId, int $courseId): array { $s=$pdo->prepare("SELECT COUNT(*) FROM kids_lessons WHERE course_id=? AND status='Published'");$s->execute([$courseId]);$total=(int)$s->fetchColumn();$s=$pdo->prepare("SELECT COUNT(DISTINCT lesson_id) FROM learner_progress WHERE learner_id=? AND course_id=? AND status='completed' AND lesson_id IS NOT NULL");$s->execute([$learnerId,$courseId]);$done=(int)$s->fetchColumn();return ['done'=>$done,'total'=>$total,'percent'=>$total?(int)round($done*100/$total):0]; }
function mark_kids_progress(PDO $pdo,int $learnerId,int $courseId,?int $lessonId,?int $activityId,int $score=100): void {
    $s=$pdo->prepare("SELECT id FROM learner_progress WHERE learner_id=? AND course_id=? AND lesson_id <=> ? AND activity_id <=> ? LIMIT 1");$s->execute([$learnerId,$courseId,$lessonId,$activityId]);$id=$s->fetchColumn();
    if($id){$pdo->prepare("UPDATE learner_progress SET status='completed',score=?,completed_at=NOW() WHERE id=?")->execute([$score,$id]);}
    else{$pdo->prepare("INSERT INTO learner_progress (learner_id,course_id,lesson_id,activity_id,status,score,completed_at) VALUES (?,?,?,?,'completed',?,NOW())")->execute([$learnerId,$courseId,$lessonId,$activityId,$score]);}
}
function award_kids_badge(PDO $pdo,int $learnerId,?int $badgeId): void { if($badgeId) $pdo->prepare('INSERT IGNORE INTO learner_badges (learner_id,badge_id) VALUES (?,?)')->execute([$learnerId,$badgeId]); }
function kids_animation(string $type): string {
    $faces=['computer'=>'🖥️','code'=>'🧩','safety'=>'🛡️','robotics'=>'⚙️','creative'=>'🎨','robot'=>'🤖'];$icon=$faces[$type]??'🤖';
    return '<div class="kids-visual-stage" aria-label="Animated learning visual"><span class="orbit orbit-one">✨</span><span class="orbit orbit-two">💡</span><div class="kids-bot"><span class="bot-antenna"></span><span class="bot-face">'.$icon.'</span><span class="bot-shadow"></span></div><div class="data-bubble bubble-a">01</div><div class="data-bubble bubble-b">ABC</div></div>';
}
function kids_admin_upload(string $field): ?string {
    if(empty($_FILES[$field]['tmp_name']) || !is_uploaded_file($_FILES[$field]['tmp_name'])) return null;
    $allowed=['image/jpeg'=>'jpg','image/png'=>'png','image/gif'=>'gif','image/webp'=>'webp','video/mp4'=>'mp4','application/json'=>'json'];
    $mime=(new finfo(FILEINFO_MIME_TYPE))->file($_FILES[$field]['tmp_name']);if(!isset($allowed[$mime]) || (int)$_FILES[$field]['size']>8*1024*1024) throw new RuntimeException('Upload a JPG, PNG, GIF, WebP, MP4, or Lottie JSON under 8 MB.');
    $dir=dirname(__DIR__).'/assets/uploads/kids';if(!is_dir($dir))mkdir($dir,0755,true);$name=bin2hex(random_bytes(8)).'.'.$allowed[$mime];if(!move_uploaded_file($_FILES[$field]['tmp_name'],$dir.'/'.$name))throw new RuntimeException('The media upload could not be saved.');return 'assets/uploads/kids/'.$name;
}
