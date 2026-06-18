<?php
$page = 'blog';
require_once __DIR__ . '/../includes/header.php';
$blogs = $pdo->query('SELECT b.*, c.name as category_name FROM blogs b LEFT JOIN blog_categories c ON b.category_id = c.id ORDER BY b.created_at DESC')->fetchAll();
?>
<section class="container py-5">
    <div class="row mb-4">
        <div class="col-lg-8">
            <h1 class="fw-bold">Blog</h1>
            <p class="text-muted">Insights, logistics trends and academic updates from our campus community.</p>
        </div>
    </div>
    <div class="row gy-4">
        <?php foreach ($blogs as $blog): ?>
            <div class="col-md-6">
                <div class="card shadow-sm border-0 h-100">
                    <img src="<?= e(site_url('uploads/blogs/' . $blog['featured_image'])) ?>" class="card-img-top" alt="<?= e($blog['title']) ?>" />
                    <div class="card-body">
                        <small class="text-muted"><?= e($blog['category_name'] ?: 'General') ?> · <?= e(date('F d, Y', strtotime($blog['created_at']))) ?></small>
                        <h5 class="card-title mt-2"><?= e($blog['title']) ?></h5>
                        <p class="card-text text-muted"><?= e(substr(strip_tags($blog['content']), 0, 120)) ?>...</p>
                        <a href="<?= e(site_url('pages/blog_detail.php?slug=' . urlencode($blog['slug']))) ?>" class="text-primary">Read More</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php require_once __DIR__ . '/../includes/footer.php';
