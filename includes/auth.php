<?php
declare(strict_types=1);
require_once __DIR__ . '/functions.php';

function learner_logged_in(): bool { return !empty($_SESSION['learner_id']); }
function learner_id(): int { return (int)($_SESSION['learner_id'] ?? 0); }
function require_learner(): void { if (!learner_logged_in()) { header('Location: login.php'); exit; } }
function academy_url(string $path=''): string { return site_url('academy/' . ltrim($path, '/')); }