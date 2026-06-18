<?php
$page = 'gallery';
require_once __DIR__ . '/../includes/header.php';
$categories = ['Campus', 'Events', 'Workshops', 'Industrial Visits'];
$selected = $_GET['category'] ?? 'Campus';
$selected = in_array($selected, $categories, true) ? $selected : 'Campus';
$stmt = $pdo->prepare('SELECT * FROM gallery WHERE category = ? ORDER BY id DESC');
$stmt->execute([$selected]);
$galleryItems = $stmt->fetchAll();
?>
<section class="container py-5">
    <div class="row mb-4">
        <div class="col-lg-8">
            <h1 class="fw-bold">Gallery</h1>
            <p class="text-muted">Browse our campus life, training sessions, industrial visits and events through photos and videos.</p>
        </div>
    </div>

    <div class="mb-4">
        <?php foreach ($categories as $category): ?>
            <a href="<?= e(site_url('pages/gallery.php?category=' . urlencode($category))) ?>" class="btn btn-sm <?= $selected === $category ? 'btn-primary' : 'btn-outline-primary' ?> me-2 mb-2"><?= e($category) ?></a>
        <?php endforeach; ?>
    </div>

    <div class="row gy-4">
        <?php foreach ($galleryItems as $item): ?>
            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <?php if ($item['media_type'] === 'video'): ?>
                        <div class="ratio ratio-16x9">
                            <iframe src="<?= e($item['media_url']) ?>" allowfullscreen></iframe>
                        </div>
                    <?php else: ?>
                        <img src="<?= e(site_url('uploads/gallery/' . $item['media_file'])) ?>" class="card-img-top" alt="<?= e($item['title']) ?>" />
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= e($item['title']) ?></h5>
                        <p class="text-muted mb-0"><?= e($item['description']) ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php require_once __DIR__ . '/../includes/footer.php';
