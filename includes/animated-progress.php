<?php
function animated_progress_ring(int $percent, string $label = 'Progress'): string
{
    $p = max(0, min(100, $percent));
    return '<div class="progress-ring" style="--progress:'.$p.'"><div><strong data-count="'.$p.'">0</strong><span>%</span></div><small>'.e($label).'</small></div>';
}