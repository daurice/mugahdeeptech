<?php
function animated_dashboard(string $mode = 'analytics'): string
{
    $title = $mode === 'powerbi' ? 'Dashboard KPIs loading' : 'Data becomes insight';
    return '<div class="learning-animation dashboard-anim" data-aos="fade-up"><div class="anim-copy"><span>Animated concept</span><h3>'.e($title).'</h3><p>Raw rows are cleaned, grouped, and transformed into charts leaders can use for decisions.</p></div><div class="data-transform"><div class="raw-table"><i></i><i></i><i></i><i></i></div><div class="flow-arrow">?</div><div class="mini-dashboard"><div class="kpi-count" data-count="87">0</div><div class="dash-bars"><b></b><b></b><b></b><b></b></div><svg viewBox="0 0 180 70"><path class="svc-line" d="M8 58C34 30 55 45 82 24C112 2 132 30 170 12"/></svg></div></div></div>';
}