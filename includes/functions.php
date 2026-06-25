<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    $sessionPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . '.sessions';
    if (!is_dir($sessionPath)) {
        mkdir($sessionPath, 0755, true);
    }
    session_save_path($sessionPath);
    session_start();
}

function site_url(string $path = ''): string
{
    $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    $base = $base === '/' ? '' : $base;
    return $base . '/' . ltrim($path, '/');
}

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function current_page(): string
{
    return basename($_SERVER['SCRIPT_NAME']);
}

function is_active(string $file): string
{
    return current_page() === $file ? 'active' : '';
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function verify_csrf(?string $token): bool
{
    return is_string($token) && hash_equals($_SESSION['csrf_token'] ?? '', $token);
}

function require_admin(): void
{
    if (empty($_SESSION['admin_id'])) {
        header('Location: login.php');
        exit;
    }
}

function service_options(): array
{
    return [
        'AI Strategy',
        'Data Analytics',
        'Business Intelligence Dashboards',
        'Machine Learning Solutions',
        'Generative AI Assistants',
        'Business Process Automation',
        'Data Engineering',
        'AI Training & Workshops',
    ];
}

function service_visual(string $service): string
{
    $slug = strtolower((string) preg_replace('/[^a-z0-9]+/i', '-', $service));
    $key = strtolower($service);
    $accentMap = [
        'ai strategy' => '#3B82F6',
        'data analytics' => '#10B981',
        'business intelligence dashboards' => '#7C3AED',
        'machine learning solutions' => '#60A5FA',
        'generative ai assistants' => '#A78BFA',
        'business process automation' => '#34D399',
        'data engineering' => '#38BDF8',
        'ai training & workshops' => '#F59E0B',
    ];
    $accent = $accentMap[$key] ?? '#3B82F6';
    $gradient = 'svc-' . $slug . '-g';
    $radial = 'svc-' . $slug . '-r';
    $variant = 'generic';

    switch ($key) {
        case 'ai strategy':
            $variant = 'strategy';
            $body = '<path class="svc-line" d="M56 150C86 98 122 116 153 82C185 46 226 60 257 92C286 122 329 117 365 60" stroke="url(#' . $gradient . ')" stroke-width="4" stroke-linecap="round"/>
                <g class="svc-nodes"><circle cx="56" cy="150" r="6" fill="#3B82F6"/><circle cx="153" cy="82" r="7" fill="#10B981"/><circle cx="257" cy="92" r="6" fill="#7C3AED"/><circle cx="365" cy="60" r="7" fill="#FFFFFF"/></g>
                <g class="svc-target"><circle cx="318" cy="136" r="34" stroke="rgba(255,255,255,0.18)" stroke-width="2"/><circle cx="318" cy="136" r="21" stroke="url(#' . $gradient . ')" stroke-width="3"/><circle class="svc-core" cx="318" cy="136" r="7" fill="' . $accent . '"/></g>
                <path d="M82 174H214" stroke="white" stroke-opacity="0.16" stroke-width="3" stroke-linecap="round"/>';
            break;
        case 'data analytics':
            $variant = 'analytics';
            $body = '<g class="svc-bars"><rect x="62" y="124" width="18" height="45" rx="8" fill="#3B82F6"/><rect x="94" y="91" width="18" height="78" rx="8" fill="#10B981"/><rect x="126" y="109" width="18" height="60" rx="8" fill="#7C3AED"/><rect x="158" y="66" width="18" height="103" rx="8" fill="#60A5FA"/><rect x="190" y="82" width="18" height="87" rx="8" fill="#34D399"/></g>
                <path class="svc-line" d="M60 104C101 85 123 105 158 76C191 49 226 59 254 88C287 122 329 103 368 68" stroke="url(#' . $gradient . ')" stroke-width="4" stroke-linecap="round"/>
                <g class="svc-nodes"><circle cx="158" cy="76" r="5" fill="#FFFFFF"/><circle cx="254" cy="88" r="5" fill="#10B981"/><circle cx="368" cy="68" r="5" fill="#7C3AED"/></g>';
            break;
        case 'business intelligence dashboards':
            $variant = 'dashboard';
            $body = '<g class="svc-panels"><rect x="54" y="48" width="132" height="98" rx="16" fill="rgba(255,255,255,0.055)" stroke="rgba(255,255,255,0.14)"/><rect x="208" y="48" width="158" height="46" rx="14" fill="rgba(59,130,246,0.13)" stroke="rgba(59,130,246,0.28)"/><rect x="208" y="108" width="70" height="58" rx="14" fill="rgba(124,58,237,0.13)" stroke="rgba(124,58,237,0.28)"/><rect x="296" y="108" width="70" height="58" rx="14" fill="rgba(16,185,129,0.12)" stroke="rgba(16,185,129,0.28)"/></g>
                <path class="svc-line" d="M76 116L102 92L128 105L164 68" stroke="url(#' . $gradient . ')" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                <g class="svc-bars"><rect x="226" y="70" width="54" height="8" rx="4" fill="#3B82F6"/><rect x="226" y="126" width="16" height="24" rx="6" fill="#7C3AED"/><rect x="250" y="138" width="16" height="12" rx="6" fill="#A78BFA"/><rect x="314" y="122" width="34" height="34" rx="17" fill="#10B981"/></g>';
            break;
        case 'machine learning solutions':
            $variant = 'machine-learning';
            $body = '<g class="svc-network svc-nodes"><path d="M94 64L178 48L252 82L326 54M94 64L166 126L252 82M166 126L254 158L326 54M178 48L166 126M252 82L254 158" stroke="url(#' . $gradient . ')" stroke-width="2.4" stroke-opacity="0.72"/><circle cx="94" cy="64" r="9" fill="#3B82F6"/><circle cx="178" cy="48" r="7" fill="#FFFFFF"/><circle cx="252" cy="82" r="10" fill="#7C3AED"/><circle cx="326" cy="54" r="8" fill="#10B981"/><circle cx="166" cy="126" r="10" fill="#60A5FA"/><circle cx="254" cy="158" r="8" fill="#34D399"/></g>
                <path class="svc-line" d="M54 174H366" stroke="rgba(255,255,255,0.18)" stroke-width="3" stroke-linecap="round"/>';
            break;
        case 'generative ai assistants':
            $variant = 'assistant';
            $body = '<g class="svc-chat"><rect x="56" y="58" width="138" height="78" rx="22" fill="rgba(59,130,246,0.14)" stroke="rgba(59,130,246,0.32)"/><rect x="226" y="82" width="136" height="78" rx="22" fill="rgba(124,58,237,0.14)" stroke="rgba(124,58,237,0.32)"/><path d="M92 88H158M92 108H136M260 112H326M260 132H306" stroke="white" stroke-opacity="0.5" stroke-width="5" stroke-linecap="round"/></g>
                <g class="svc-spark"><path d="M206 48L214 68L235 76L214 84L206 104L198 84L177 76L198 68L206 48Z" fill="url(#' . $gradient . ')"/><circle class="svc-core" cx="334" cy="58" r="7" fill="#10B981"/><circle cx="78" cy="156" r="5" fill="#FFFFFF"/></g>';
            break;
        case 'business process automation':
            $variant = 'automation';
            $body = '<g class="svc-flow"><rect x="48" y="76" width="78" height="58" rx="17" fill="rgba(59,130,246,0.14)" stroke="rgba(59,130,246,0.34)"/><rect x="171" y="76" width="78" height="58" rx="17" fill="rgba(124,58,237,0.14)" stroke="rgba(124,58,237,0.34)"/><rect x="294" y="76" width="78" height="58" rx="17" fill="rgba(16,185,129,0.14)" stroke="rgba(16,185,129,0.34)"/><path class="svc-line" d="M126 105H171M249 105H294" stroke="url(#' . $gradient . ')" stroke-width="5" stroke-linecap="round"/><path d="M158 94L171 105L158 116M281 94L294 105L281 116" stroke="white" stroke-opacity="0.62" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/></g>
                <g class="svc-gear"><circle cx="210" cy="162" r="21" stroke="url(#' . $gradient . ')" stroke-width="5"/><circle cx="210" cy="162" r="7" fill="' . $accent . '"/></g>';
            break;
        case 'data engineering':
            $variant = 'engineering';
            $body = '<g class="svc-pipeline"><ellipse cx="82" cy="62" rx="38" ry="16" fill="rgba(59,130,246,0.18)" stroke="rgba(59,130,246,0.38)"/><path d="M44 62V137C44 146 61 154 82 154C103 154 120 146 120 137V62" fill="rgba(59,130,246,0.08)" stroke="rgba(59,130,246,0.28)"/><ellipse cx="82" cy="137" rx="38" ry="16" stroke="rgba(59,130,246,0.38)"/><ellipse cx="338" cy="62" rx="38" ry="16" fill="rgba(16,185,129,0.18)" stroke="rgba(16,185,129,0.38)"/><path d="M300 62V137C300 146 317 154 338 154C359 154 376 146 376 137V62" fill="rgba(16,185,129,0.08)" stroke="rgba(16,185,129,0.28)"/><ellipse cx="338" cy="137" rx="38" ry="16" stroke="rgba(16,185,129,0.38)"/></g>
                <path class="svc-line" d="M120 108C166 64 212 152 300 108" stroke="url(#' . $gradient . ')" stroke-width="5" stroke-linecap="round"/>
                <g class="svc-nodes"><circle cx="178" cy="91" r="6" fill="#FFFFFF"/><circle cx="236" cy="125" r="6" fill="#7C3AED"/></g>';
            break;
        case 'ai training & workshops':
            $variant = 'training';
            $body = '<g class="svc-workshop"><rect x="70" y="44" width="210" height="104" rx="18" fill="rgba(255,255,255,0.055)" stroke="rgba(255,255,255,0.16)"/><path class="svc-line" d="M98 118L132 90L166 104L206 72L246 84" stroke="url(#' . $gradient . ')" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/><path d="M116 164H234" stroke="rgba(255,255,255,0.22)" stroke-width="5" stroke-linecap="round"/><circle cx="314" cy="82" r="18" fill="rgba(245,158,11,0.18)" stroke="rgba(245,158,11,0.38)"/><circle cx="336" cy="132" r="15" fill="rgba(59,130,246,0.16)" stroke="rgba(59,130,246,0.34)"/><circle cx="300" cy="144" r="13" fill="rgba(16,185,129,0.16)" stroke="rgba(16,185,129,0.34)"/></g>
                <g class="svc-nodes"><circle cx="132" cy="90" r="5" fill="#FFFFFF"/><circle cx="206" cy="72" r="5" fill="#10B981"/><circle cx="246" cy="84" r="5" fill="#F59E0B"/></g>';
            break;
        default:
            $body = '<path class="svc-line" d="M52 150C88 92 122 119 156 82C197 38 238 71 273 54C318 32 350 62 382 34" stroke="url(#' . $gradient . ')" stroke-width="4" stroke-linecap="round"/><g class="svc-nodes"><circle cx="156" cy="82" r="5" fill="#FFFFFF"/><circle cx="273" cy="54" r="5" fill="#10B981"/><circle cx="350" cy="62" r="5" fill="#7C3AED"/></g>';
    }

    return '<div class="service-visual service-visual-' . e($variant) . '" aria-hidden="true" style="--service-accent:' . e($accent) . '">
        <svg viewBox="0 0 420 210" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Animated ' . e($service) . ' service visual">
            <defs>
                <linearGradient id="' . e($gradient) . '" x1="32" y1="22" x2="390" y2="196" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#3B82F6" stop-opacity="0.95"/>
                    <stop offset="0.55" stop-color="#7C3AED" stop-opacity="0.72"/>
                    <stop offset="1" stop-color="#10B981" stop-opacity="0.82"/>
                </linearGradient>
                <radialGradient id="' . e($radial) . '" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(304 78) rotate(127) scale(160 92)">
                    <stop stop-color="' . e($accent) . '" stop-opacity="0.34"/>
                    <stop offset="1" stop-color="#050505" stop-opacity="0"/>
                </radialGradient>
            </defs>
            <rect x="1" y="1" width="418" height="208" rx="22" fill="url(#' . e($radial) . ')" stroke="rgba(255,255,255,0.08)"/>
            <g class="svc-grid">
                <path d="M44 48H376M44 92H376M44 136H376M44 180H376" stroke="white" stroke-opacity="0.055"/>
                <path d="M80 30V184M144 30V184M208 30V184M272 30V184M336 30V184" stroke="white" stroke-opacity="0.045"/>
            </g>
            ' . $body . '
        </svg>
    </div>';
}
function page_meta(string $title, string $description): array
{
    return ['title' => $title . ' | Mugah DeepTech', 'description' => $description];
}

function get_recent_case_studies(PDO $pdo, int $limit = 3): array
{
    $stmt = $pdo->prepare('SELECT title, slug, industry, summary, result_metric FROM case_studies WHERE published = 1 ORDER BY created_at DESC LIMIT :limit');
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function get_recent_posts(PDO $pdo, int $limit = 3): array
{
    $stmt = $pdo->prepare('SELECT title, slug, excerpt, category, created_at FROM blog_posts WHERE published = 1 ORDER BY created_at DESC LIMIT :limit');
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}
