<?php
$cmsAdminTitle='Academy Settings';require_once __DIR__.'/../includes/cms-admin-header.php';
if($_SERVER['REQUEST_METHOD']==='POST'&&verify_csrf($_POST['csrf_token']??null)){
 foreach($_POST['setting']??[] as $id=>$value){$pdo->prepare('UPDATE settings SET setting_value=? WHERE id=?')->execute([is_array($value)?'1':trim((string)$value),(int)$id]);}
 header('Location: academy-settings.php?saved=1');exit;
}
$rows=$pdo->query("SELECT * FROM settings WHERE setting_group='academy' ORDER BY label")->fetchAll();
?>
<div class="admin-top"><div><p class="eyebrow">Academy CMS</p><h1>Theme & Settings</h1></div></div>
<?php if(isset($_GET['saved'])):?><div class="alert alert-success">Settings saved.</div><?php endif?>
<form class="glass-card" method="post"><input type="hidden" name="csrf_token" value="<?=e(csrf_token())?>"><div class="cms-form">
<?php foreach($rows as $row):?><label class="<?=$row['input_type']==='textarea'?'wide':''?>"><?=e($row['label'])?><?php if($row['input_type']==='textarea'):?><textarea class="form-control" name="setting[<?=(int)$row['id']?>]"><?=e($row['setting_value'])?></textarea><?php elseif($row['input_type']==='boolean'):?><select class="form-select" name="setting[<?=(int)$row['id']?>]"><option value="1" <?=$row['setting_value']==='1'?'selected':''?>>Enabled</option><option value="0" <?=$row['setting_value']==='0'?'selected':''?>>Disabled</option></select><?php else:?><input class="form-control" type="<?=$row['input_type']==='color'?'color':'text'?>" name="setting[<?=(int)$row['id']?>]" value="<?=e($row['setting_value'])?>"><?php endif?><small class="cms-help"><?=e($row['description'])?></small></label><?php endforeach?>
<div class="wide"><button class="btn btn-premium">Save settings</button></div></div></form>
<?php require_once __DIR__.'/../includes/cms-admin-footer.php';?>