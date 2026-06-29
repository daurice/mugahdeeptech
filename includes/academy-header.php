<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/lms-functions.php';
$meta = $meta ?? page_meta('Mugah DeepTech Academy', 'Learn AI, data analytics, machine learning, generative AI, and automation with Mugah DeepTech Academy.');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($meta['title']); ?></title>
    <meta name="description" content="<?= e($meta['description']); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <link rel="stylesheet" href="<?= site_url('assets/css/style.css'); ?>">
</head>
<body class="academy-body">
<nav class="navbar navbar-expand-lg fixed-top nav-glass academy-nav">
    <div class="container">
        <a class="navbar-brand brand-mark" href="<?= academy_url('index.php'); ?>"><img class="logo-mark" src="<?= site_url('assets/images/mugah-deeptech-logo.svg'); ?>" alt="" aria-hidden="true"><span class="brand-text">Mugah DeepTech Academy</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#academyNav"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="academyNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                <li class="nav-item"><a class="nav-link" href="<?= site_url('index.php'); ?>">Main Site</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= academy_url('courses.php'); ?>">Courses</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= site_url('kids/index.php'); ?>">Kids Academy</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= site_url('business/index.php'); ?>">Business Academy</a></li>
                <?php if (learner_logged_in()): ?>
                    <li class="nav-item"><a class="nav-link" href="<?= academy_url('dashboard.php'); ?>">Dashboard</a></li>
                    <li class="nav-item"><a class="btn btn-outline-light btn-sm" href="<?= academy_url('logout.php'); ?>">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="<?= academy_url('login.php'); ?>">Login</a></li>
                    <li class="nav-item"><a class="btn btn-premium btn-sm" href="<?= academy_url('register.php'); ?>">Join Academy</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<main>