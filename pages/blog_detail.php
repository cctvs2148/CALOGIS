<?php
$page = 'blog';
require_once __DIR__ . '/../includes/header.php';
$slug = $_GET['slug'] ?? '';
$stmt = $pdo->prepare('SELECT b.*, c.name as category_name FROM blogs b LEFT JOIN blog_categories c ON b.category_id = c.id WHERE b.slug = ? LIMIT 1');
$stmt->execute([$slug]);
$blog = $stmt->fetch();
if (!$blog) {
    header('Location: ' . site_url('pages/blog.php'));
    exit;
}
?>
<section class="container py-5">
    <div class="row mb-4">
        <div class="col-lg-8">
            <small class="text-muted"><?= e($blog['category_name'] ?: 'General') ?> · <?= e(date('F d, Y', strtotime($blog['created_at']))) ?></small>
            <h1 class="fw-bold mt-2"><?= e($blog['title']) ?></h1>
            <p class="text-muted"><?= e($blog['seo_description']) ?></p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-10">
            <img src="<?= e(site_url('uploads/blogs/' . $blog['featured_image'])) ?>" class="img-fluid rounded shadow-sm mb-4" alt="<?= e($blog['title']) ?>" />
            <div class="blog-content text-muted"><?= $blog['content'] ?></div>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/../includes/footer.php';
