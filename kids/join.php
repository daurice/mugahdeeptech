<?php
require_once __DIR__.'/../includes/kids-header.php';
$errors=[];$values=['name'=>'','guardian_email'=>'','age_group'=>'9-12'];
if($_SERVER['REQUEST_METHOD']==='POST'){
  foreach($values as $k=>$v)$values[$k]=trim((string)($_POST[$k]??$v));$password=(string)($_POST['password']??'');
  if(!verify_csrf($_POST['csrf_token']??null))$errors[]='Please refresh and try again.';
  if(strlen($values['name'])<2)$errors[]='Add the learner’s first name or nickname.';
  if(!filter_var($values['guardian_email'],FILTER_VALIDATE_EMAIL))$errors[]='Add a valid guardian email.';
  if(!in_array($values['age_group'],['6-8','9-12','13-15'],true))$errors[]='Choose an age group.';
  if(strlen($password)<8)$errors[]='Use at least 8 password characters.';
  if(empty($_POST['consent']))$errors[]='A parent or guardian must confirm consent.';
  if(!$errors){try{$pdo->beginTransaction();$pdo->prepare('INSERT INTO learners (full_name,email,phone,password_hash) VALUES (?,?,NULL,?)')->execute([$values['name'],$values['guardian_email'],password_hash($password,PASSWORD_DEFAULT)]);$id=(int)$pdo->lastInsertId();$pdo->prepare('INSERT INTO kids_guardian_profiles (learner_id,guardian_email,age_group) VALUES (?,?,?)')->execute([$id,$values['guardian_email'],$values['age_group']]);$pdo->commit();$_SESSION['learner_id']=$id;$_SESSION['learner_name']=$values['name'];header('Location: progress.php');exit;}catch(PDOException $e){if($pdo->inTransaction())$pdo->rollBack();$errors[]='That guardian email already has an account. Use Learner Login instead.';}}
}
?>
<section class="join-page"><form class="join-card" method="post"><input type="hidden" name="csrf_token" value="<?=e(csrf_token())?>"><span class="join-mascot">🤖</span><span class="kids-kicker">Grown-up help needed</span><h1>Create a learner profile</h1><p>We keep it simple: learner name, age group, and a guardian email.</p><?php if($errors):?><div class="form-errors"><?=e(implode(' ',$errors))?></div><?php endif?><label>Learner’s first name or nickname<input name="name" value="<?=e($values['name'])?>" autocomplete="given-name" required></label><label>Parent or guardian email<input type="email" name="guardian_email" value="<?=e($values['guardian_email'])?>" autocomplete="email" required></label><label>Age group<select name="age_group"><?php foreach(['6-8','9-12','13-15'] as $group):?><option value="<?=$group?>" <?=$values['age_group']===$group?'selected':''?>>Ages <?=$group?></option><?php endforeach?></select></label><label>Family password<input type="password" name="password" minlength="8" autocomplete="new-password" required></label><label class="consent"><input type="checkbox" name="consent" value="1" required><span>I am the learner’s parent/guardian and consent to this learning profile.</span></label><button class="kids-btn primary" type="submit">Begin safely →</button><small>Already registered? <a href="<?=site_url('academy/login.php')?>">Learner Login</a></small></form></section>
<?php include __DIR__.'/../includes/kids-footer.php';?>
