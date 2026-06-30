<?php
require_once __DIR__.'/../includes/kids-header.php';
$lesson=kids_lesson($pdo,(int)($_GET['lesson']??0)); if(!$lesson){http_response_code(404);exit('Lesson not found.');}
$quiz=kids_quiz($pdo,(int)$lesson['id']); if(!$quiz)exit('Quiz coming soon.'); $result=null;
if($_SERVER['REQUEST_METHOD']==='POST'&&verify_csrf($_POST['csrf_token']??null)){
  $correct=0;$feedback=[];
  foreach($quiz['questions'] as $q){$answer=(string)($_POST['q'.$q['id']]??'');$ok=hash_equals((string)$q['correct_answer'],$answer);if($ok)$correct++;$feedback[$q['id']]=['ok'=>$ok,'explanation'=>$q['explanation']];}
  $total=count($quiz['questions']);$score=$total?(int)round($correct*100/$total):0;$result=['score'=>$score,'passed'=>$score>=(int)$quiz['pass_mark'],'feedback'=>$feedback];
  if(learner_logged_in()){$pdo->prepare('INSERT INTO academy_quiz_attempts (pathway,learner_id,quiz_id,lesson_id,score,total_questions,passed,answers_json) VALUES ("Kids",?,?,?,?,?,?,?)')->execute([learner_id(),(int)$quiz['id'],(int)$lesson['id'],$score,$total,$result['passed']?1:0,json_encode($_POST)]);if($result['passed']){mark_kids_progress($pdo,learner_id(),(int)$lesson['course_id'],(int)$lesson['id'],null,$score);award_kids_badge($pdo,learner_id(),$quiz['badge_id']?(int)$quiz['badge_id']:null);}}
}
?>
<section class="quiz-page"><div class="activity-heading"><a class="back-link" href="<?=kids_url('lesson.php?id='.(int)$lesson['id'])?>">← Back to lesson</a><span class="kids-kicker">Quick brain boost</span><h1><?=e($quiz['title'])?></h1><p>Choose the best answer. You can always try again.</p></div>
<?php if($result):?><div class="quiz-result <?=$result['passed']?'passed':'retry'?>"><span><?=$result['passed']?'🏆':'🌱'?></span><h2><?=$result['passed']?'You did it!':'Good try—keep growing!'?></h2><strong><?=$result['score']?>%</strong><p><?=$result['passed']?'You unlocked a bright new learning star.':'Review the friendly hints below, then try once more.'?></p></div><?php endif?>
<form class="quiz-form" method="post"><input type="hidden" name="csrf_token" value="<?=e(csrf_token())?>"><?php foreach($quiz['questions'] as $i=>$q):$options=kids_json($q['options_json']);?><fieldset class="quiz-card"><legend><span><?=$i+1?></span><?=e($q['question'])?></legend><?php foreach($options as $option):?><label><input type="radio" name="q<?=(int)$q['id']?>" value="<?=e((string)$option)?>" required><span><?=e((string)$option)?></span></label><?php endforeach?><?php if($result):?><p class="answer-hint <?=$result['feedback'][$q['id']]['ok']?'correct':'wrong'?>"><?=$result['feedback'][$q['id']]['ok']?'✓ Great thinking!':'💡 '.e($result['feedback'][$q['id']]['explanation'])?></p><?php endif?></fieldset><?php endforeach?><button class="kids-btn primary" type="submit"><?=$result?'Try again':'Check my answers'?> →</button></form></section>
<?php include __DIR__.'/../includes/kids-footer.php';?>
