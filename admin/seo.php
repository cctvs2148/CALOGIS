<?php
require_once __DIR__ . '/../config/config.php';
require_admin();
$pages = [
    'home' => 'Home',
    'about' => 'About',
    'courses' => 'Courses',
    'placements' => 'Placements',
    'events' => 'Events',
    'gallery' => 'Gallery',
    'blog' => 'Blog',
    'admissions' => 'Admissions',
    'contact' => 'Contact',
];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (validate_csrf($_POST['csrf_token'] ?? '')) {
        $stmt = $pdo->prepare('REPLACE INTO seo_settings (page, meta_title, meta_description, meta_keywords) VALUES (?, ?, ?, ?)');
        foreach ($pages as $pageKey => $label) {
            $stmt->execute([$pageKey, $_POST[$pageKey . '_title'] ?? '', $_POST[$pageKey . '_description'] ?? '', $_POST[$pageKey . '_keywords'] ?? '']);
        }
        set_flash('SEO metadata updated successfully.');
    }
    header('Location: seo.php');
    exit;
}
$seoValues = [];
$stmt = $pdo->query('SELECT * FROM seo_settings');
foreach ($stmt->fetchAll() as $row) {
    $seoValues[$row['page']] = $row;
}
require_once __DIR__ . '/../includes/admin_header.php';
?>
<div class="card shadow-sm border-0 p-4">
    <h3>SEO Settings</h3>
    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>" />
        <?php foreach ($pages as $pageKey => $label): ?>
            <div class="mb-4">
                <h5><?= e($label) ?></h5>
                <div class="mb-3">
                    <label class="form-label">Meta Title</label>
                    <input type="text" name="<?= e($pageKey . '_title') ?>" class="form-control" value="<?= e($seoValues[$pageKey]['meta_title'] ?? '') ?>" />
                </div>
                <div class="mb-3">
                    <label class="form-label">Meta Description</label>
                    <textarea name="<?= e($pageKey . '_description') ?>" rows="2" class="form-control"><?= e($seoValues[$pageKey]['meta_description'] ?? '') ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Meta Keywords</label>
                    <input type="text" name="<?= e($pageKey . '_keywords') ?>" class="form-control" value="<?= e($seoValues[$pageKey]['meta_keywords'] ?? '') ?>" />
                </div>
            </div>
        <?php endforeach; ?>
        <button type="submit" class="btn btn-primary">Save SEO Metadata</button>
    </form>
</div>
<?php require_once __DIR__ . '/../includes/admin_footer.php';
