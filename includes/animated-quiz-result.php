<?php
function animated_quiz_result(?array $result): string
{
    if (!$result) { return ''; }
    $class = $result['passed'] ? 'passed' : 'retry';
    $label = $result['passed'] ? 'Passed' : 'Keep improving';
    return '<div class="quiz-result-anim '.$class.'" data-quiz-result="'.($result['passed'] ? 'passed' : 'retry').'"><div class="quiz-score-orb"><strong data-count="'.(int)$result['percent'].'">0</strong><span>%</span></div><div><span>'.e($label).'</span><h2>'.(int)$result['score'].' / '.(int)$result['total'].' correct</h2><p>'.($result['passed'] ? 'Excellent work. Your result has been saved and certificate eligibility will be checked.' : 'Review the explanations below, then retake when ready.').'</p></div></div>';
}