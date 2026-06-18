<?php
$require_path = __DIR__ . '/../config/config.php';
require_once $require_path;
$siteTitle = get_setting($pdo, 'site_title', 'Logistics College Management System - CAIIHM Logistics College');
$shortName = 'CAIIHM Logistics College';
// Collapse accidental duplicates of the short name inside the full title (e.g. "... CAIIHM Logistics College CAIIHM Logistics College")
$siteTitle = preg_replace('/(' . preg_quote($shortName, '/') . ')(\s*\1)+/i', '$1', $siteTitle);
$siteTitle = trim(preg_replace('/\s+/', ' ', $siteTitle));
$displayShort = (stripos($siteTitle, $shortName) === false) ? $shortName : '';
$siteDescription = get_setting($pdo, 'site_description', 'Premium Logistics & Supply Chain Management College');
$seo = get_seo($pdo, $page ?? 'home');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="<?= e($seo['meta_description'] ?: $siteDescription) ?>" />
    <meta name="keywords" content="<?= e($seo['meta_keywords'] ?: 'logistics, supply chain, management, education, college') ?>" />
    <title><?= e($seo['meta_title'] ?: $siteTitle) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="icon" href="<?= e(site_url('assets/images/favicon.ico')) ?>" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?= e(site_url('assets/images/apple-touch-icon.png')) ?>" />
    <link href="<?= e(site_url('assets/css/style.css')) ?>" rel="stylesheet" />
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary d-flex align-items-center" href="<?= e(site_url('')) ?>">
            <img src="<?= e(site_url('assets/images/logo.jpeg')) ?>" alt="<?= e($siteTitle) ?>" class="me-2 site-logo" />
            <span class="site-title-short"><?= e($shortName) ?></span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item"><a class="nav-link" href="<?= e(site_url('')) ?>">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= e(site_url('pages/about.php')) ?>">About</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= e(site_url('pages/courses.php')) ?>">Courses</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= e(site_url('pages/placements.php')) ?>">Placements</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= e(site_url('pages/events.php')) ?>">Events</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= e(site_url('pages/gallery.php')) ?>">Gallery</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= e(site_url('pages/blog.php')) ?>">Blog</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= e(site_url('pages/admissions.php')) ?>">Admissions</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= e(site_url('pages/contact.php')) ?>">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>
<main class="site-content">