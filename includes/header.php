<?php
require_once __DIR__ . '/functions.php';
$meta = $meta ?? page_meta('AI & Data Consulting', 'Mugah DeepTech helps organizations in Nairobi and beyond grow with AI, data analytics, automation, and machine learning.');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($meta['title']); ?></title>
    <meta name="description" content="<?= e($meta['description']); ?>">
    <meta name="keywords" content="AI consulting Nairobi, data analytics Kenya, machine learning, business automation, dashboards, digital transformation">
    <meta name="author" content="Mugah DeepTech">
    <meta property="og:title" content="<?= e($meta['title']); ?>">
    <meta property="og:description" content="<?= e($meta['description']); ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://www.mugahdeeptech.net/">
    <link rel="canonical" href="https://www.mugahdeeptech.net<?= e($_SERVER['REQUEST_URI'] ?? '/'); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= site_url('assets/css/style.css'); ?>">
</head>
<body>
<nav class="navbar navbar-expand-lg fixed-top nav-glass">
    <div class="container">
        <a class="navbar-brand brand-mark" href="<?= site_url('index.php'); ?>">
            <img class="logo-mark" src="<?= site_url('assets/images/mugah-deeptech-logo.svg'); ?>" alt="" aria-hidden="true"><span class="brand-text">Mugah DeepTech</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                <li class="nav-item"><a class="nav-link <?= is_active('index.php'); ?>" href="<?= site_url('index.php'); ?>">Home</a></li>
                <li class="nav-item"><a class="nav-link <?= is_active('about.php'); ?>" href="<?= site_url('about.php'); ?>">About</a></li>
                <li class="nav-item"><a class="nav-link <?= is_active('services.php'); ?>" href="<?= site_url('services.php'); ?>">Services</a></li>
                <li class="nav-item"><a class="nav-link <?= is_active('solutions.php'); ?>" href="<?= site_url('solutions.php'); ?>">Solutions</a></li>
                <li class="nav-item"><a class="nav-link <?= is_active('industries.php'); ?>" href="<?= site_url('industries.php'); ?>">Industries</a></li>
                <li class="nav-item"><a class="nav-link <?= is_active('case-studies.php'); ?>" href="<?= site_url('case-studies.php'); ?>">Case Studies</a></li>
                <li class="nav-item"><a class="nav-link <?= is_active('insights.php'); ?>" href="<?= site_url('insights.php'); ?>">Insights</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= site_url('academy/index.php'); ?>">Academy</a></li>
                <li class="nav-item ms-lg-2"><a class="btn btn-premium btn-sm" href="<?= site_url('contact.php'); ?>">Book Consultation</a></li>
            </ul>
        </div>
    </div>
</nav>
<main>
