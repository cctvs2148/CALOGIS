<?php
require_once __DIR__ . '/../config/config.php';
$adminName = $_SESSION['admin_name'] ?? 'Administrator';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Panel - Logistics College</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="icon" href="<?= e(site_url('assets/images/favicon.ico')) ?>" />
    <link href="<?= e(site_url('assets/css/style.css')) ?>" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="<?= e(site_url('admin/dashboard.php')) ?>">
            <img src="<?= e(site_url('assets/images/logo.png')) ?>" alt="Admin" class="me-2 site-logo-admin" />
            Logistics College Admin
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="adminMenu">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="<?= e(site_url('admin/dashboard.php')) ?>">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= e(site_url('admin/courses.php')) ?>">Courses</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= e(site_url('admin/placements.php')) ?>">Placements</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= e(site_url('admin/events.php')) ?>">Events</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= e(site_url('admin/blogs.php')) ?>">Blog</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= e(site_url('admin/blog_categories.php')) ?>">Categories</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= e(site_url('admin/gallery.php')) ?>">Gallery</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= e(site_url('admin/testimonials.php')) ?>">Testimonials</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= e(site_url('admin/admissions.php')) ?>">Admissions</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= e(site_url('admin/contact_messages.php')) ?>">Contacts</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= e(site_url('admin/hero.php')) ?>">Hero</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= e(site_url('admin/settings.php')) ?>">Settings</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= e(site_url('admin/seo.php')) ?>">SEO</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= e(site_url('admin/logout.php')) ?>">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container py-4">
    <?php if ($flash = flash_message()): ?>
        <div class="alert alert-success"><?= e($flash) ?></div>
    <?php endif; ?>
