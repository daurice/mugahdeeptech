<?php
require_once __DIR__ . '/../includes/kids-header.php';
$activity=kids_activity($pdo,(int)($_GET['id']??0));
if(!$activity){http_response_code(404);exit('Activity not found.');}
$config=kids_json($activity['config_json']); $saved=false;
if($_SERVER['REQUEST_METHOD']==='POST'&&verify_csrf($_POST['csrf_token']??null)&&learner_logged_in()){
  mark_kids_progress($pdo,learner_id(),(int)$activity['course_id'],(int)$activity['lesson_id'],(int)$activity['id'],(int)($_POST['score']??100));
  award_kids_badge($pdo,learner_id(),$activity['badge_id']?(int)$activity['badge_id']:null); $saved=true;
}
?>
<section class="activity-page" data-activity="<?=e($activity['activity_type'])?>">
  <div class="activity-heading"><a class="back-link" href="<?=kids_url('lesson.php?id='.(int)$activity['lesson_id'])?>">← Back to lesson</a><span class="kids-kicker">Play & practice</span><h1><?=e($activity['title'])?></h1><p><?=e($activity['instructions'])?></p></div>
  <div class="play-card">
  <?php if($activity['activity_type']==='matching'): ?>
    <div class="match-game" data-match-game><div class="match-items"><?php foreach($config['pairs']??[] as $i=>$pair):?><button draggable="true" data-match="<?=$i?>"><?=e($pair['item'])?></button><?php endforeach?></div><div class="match-targets"><?php foreach($config['pairs']??[] as $i=>$pair):?><div data-target="<?=$i?>"><span>Drop here</span><b><?=e($pair['match'])?></b></div><?php endforeach?></div></div>
  <?php elseif($activity['activity_type']==='flashcards'): ?>
    <div class="flashcard-deck"><?php foreach($config['cards']??[] as $card):?><button class="flashcard" type="button"><span class="flash-front"><small>Tap to flip</small><?=e($card['front'])?></span><span class="flash-back"><?=e($card['back'])?></span></button><?php endforeach?></div>
  <?php elseif($activity['activity_type']==='coding'): ?>
    <div class="coding-game" data-solution='<?=e(json_encode($config['solution']??[]))?>'><div class="robot-map"><span class="mini-robo">🤖</span><i></i><i></i><span class="goal">🍎</span></div><div class="command-bank"><?php $commands=$config['commands']??[];shuffle($commands);foreach($commands as $command):?><button draggable="true"><?=e($command)?></button><?php endforeach?></div><div class="code-sequence" data-code-drop><span>Drop commands here in order</span></div><button class="kids-btn primary run-code" type="button">▶ Run my code</button></div>
  <?php endif; ?>
  </div>
  <div class="activity-success <?=$saved?'show':''?>" role="dialog" aria-modal="true" aria-label="Activity complete"><div><span class="reward-badge"><?=e($activity['badge_icon']?:'🏅')?></span><h2>Brilliant work!</h2><p>You completed the activity<?= $activity['badge_name']?' and unlocked the '.e($activity['badge_name']).' badge!':'!'?></p><?php if(!learner_logged_in()):?><p class="save-hint">Play complete! Join with a grown-up to save this badge.</p><a class="kids-btn primary" href="<?=kids_url('join.php')?>">Save my badges</a><?php else:?><form method="post"><input type="hidden" name="csrf_token" value="<?=e(csrf_token())?>"><input type="hidden" name="score" value="100"><button class="kids-btn primary">Save my badge</button></form><?php endif?><a class="kids-btn secondary" href="<?=kids_url('lesson.php?id='.(int)$activity['lesson_id'])?>">Back to lesson</a></div></div>
</section>
<?php include __DIR__.'/../includes/kids-footer.php';?>
