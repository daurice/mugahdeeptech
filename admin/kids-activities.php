<?php
$adminTitle='Kids Activities';
require_once __DIR__.'/../includes/kids-admin-header.php';
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'&&verify_csrf($_POST['csrf_token']??null)){
 try{
  $id=(int)($_POST['id']??0);
  if(($_POST['action']??'')==='delete'){$pdo->prepare('DELETE FROM kids_activities WHERE id=?')->execute([$id]);header('Location: kids-activities.php');exit;}
  $config=trim((string)$_POST['config_json']);
  if(!is_array(json_decode($config,true)))throw new RuntimeException('Configuration must be valid JSON.');
  $lesson=kids_lesson($pdo,(int)$_POST['lesson_id']);
  if(!$lesson)throw new RuntimeException('Choose a lesson.');
  $data=[(int)$lesson['course_id'],(int)$lesson['id'],trim((string)$_POST['title']),trim((string)$_POST['instructions']),$_POST['activity_type'],$config,(int)$_POST['badge_id']?:null,$_POST['status']==='Draft'?'Draft':'Published',(int)$_POST['sort_order']];
  if($id){$data[]=$id;$pdo->prepare('UPDATE kids_activities SET course_id=?,lesson_id=?,title=?,instructions=?,activity_type=?,config_json=?,badge_id=?,status=?,sort_order=? WHERE id=?')->execute($data);}
  else{$pdo->prepare('INSERT INTO kids_activities (course_id,lesson_id,title,instructions,activity_type,config_json,badge_id,status,sort_order) VALUES (?,?,?,?,?,?,?,?,?)')->execute($data);}
  header('Location: kids-activities.php?saved=1');exit;
 }catch(Throwable $e){$error=$e->getMessage();}
}
$edit=null;
if(!empty($_GET['edit'])){$s=$pdo->prepare('SELECT * FROM kids_activities WHERE id=?');$s->execute([(int)$_GET['edit']]);$edit=$s->fetch()?:null;}
$lessons=$pdo->query('SELECT l.id,l.title,c.title course_title FROM kids_lessons l JOIN kids_courses c ON c.id=l.course_id ORDER BY c.sort_order,l.sort_order')->fetchAll();
$badges=$pdo->query('SELECT * FROM badges ORDER BY name')->fetchAll();
$all=$pdo->query('SELECT a.*,l.title lesson_title,b.name badge_name FROM kids_activities a JOIN kids_lessons l ON l.id=a.lesson_id LEFT JOIN badges b ON b.id=a.badge_id ORDER BY a.id DESC')->fetchAll();
$sample='{"pairs":[{"item":"🍎 Apple","match":"Round + red"},{"item":"🍌 Banana","match":"Long + yellow"}]}';
?>
<div class="admin-top"><div><p class="eyebrow">Kids Academy</p><h1>Interactive Activities</h1></div><a class="btn btn-premium" href="?new=1">Add activity</a></div>
<?php if($error):?><div class="alert alert-danger"><?=e($error)?></div><?php endif?>
<?php if($edit||isset($_GET['new'])):?><form class="glass-card kids-admin-form mb-4" method="post">
<input type="hidden" name="csrf_token" value="<?=e(csrf_token())?>"><input type="hidden" name="id" value="<?=(int)($edit['id']??0)?>">
<label>Lesson<select class="form-select" name="lesson_id"><?php foreach($lessons as $l):?><option value="<?=(int)$l['id']?>" <?=(int)($edit['lesson_id']??0)===(int)$l['id']?'selected':''?>><?=e($l['course_title'].' — '.$l['title'])?></option><?php endforeach?></select></label>
<label>Type<select class="form-select" name="activity_type"><?php foreach(['matching','flashcards','coding','quiz'] as $v):?><option <?=($edit['activity_type']??'matching')===$v?'selected':''?>><?=$v?></option><?php endforeach?></select></label>
<label>Title<input class="form-control" name="title" value="<?=e($edit['title']??'')?>" required></label>
<label>Reward badge<select class="form-select" name="badge_id"><option value="0">No badge</option><?php foreach($badges as $b):?><option value="<?=(int)$b['id']?>" <?=(int)($edit['badge_id']??0)===(int)$b['id']?'selected':''?>><?=e($b['icon'].' '.$b['name'])?></option><?php endforeach?></select></label>
<label class="wide">Instructions<textarea class="form-control" name="instructions" required><?=e($edit['instructions']??'')?></textarea></label>
<label class="wide">Activity JSON<textarea class="form-control font-monospace" name="config_json" required><?=e($edit['config_json']??$sample)?></textarea><small class="media-note">Use pairs for matching, cards with front/back for flashcards, or commands and solution arrays for coding.</small></label>
<label>Sort order<input class="form-control" type="number" name="sort_order" value="<?=(int)($edit['sort_order']??1)?>"></label><label>Status<select class="form-select" name="status"><option>Published</option><option <?=($edit['status']??'')==='Draft'?'selected':''?>>Draft</option></select></label>
<div class="wide"><button class="btn btn-premium">Save activity</button> <a class="btn btn-outline-light" href="kids-activities.php">Cancel</a></div></form><?php endif?>
<div class="glass-card table-responsive"><table class="table table-dark"><tr><th>Activity</th><th>Lesson</th><th>Type</th><th>Reward</th><th></th></tr><?php foreach($all as $row):?><tr><td><?=e($row['title'])?></td><td><?=e($row['lesson_title'])?></td><td><?=e($row['activity_type'])?></td><td><?=e($row['badge_name']??'—')?></td><td><a class="btn btn-sm btn-outline-light" href="?edit=<?=(int)$row['id']?>">Edit</a><form class="d-inline" method="post"><input type="hidden" name="csrf_token" value="<?=e(csrf_token())?>"><input type="hidden" name="id" value="<?=(int)$row['id']?>"><button class="btn btn-sm btn-danger" name="action" value="delete">Delete</button></form></td></tr><?php endforeach?></table></div>
<?php require_once __DIR__.'/../includes/kids-admin-footer.php';?>
