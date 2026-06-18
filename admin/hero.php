<?php
require_once __DIR__ . '/../config/config.php';
require_admin();
$hero = $pdo->query('SELECT * FROM hero_sections ORDER BY id DESC LIMIT 1')->fetch();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_csrf($_POST['csrf_token'] ?? '')) {
        set_flash('Invalid request token.');
    } else {
        $bgImage = $hero['background_image'] ?? '';
        if (!empty($_FILES['background_image']['name'])) {
            $uploaded = upload_file($_FILES['background_image'], __DIR__ . '/../uploads/events');
            if ($uploaded) {
                $bgImage = $uploaded;
            }
        }
        if ($hero) {
            $stmt = $pdo->prepare('UPDATE hero_sections SET background_image=?, main_heading=?, sub_heading=?, button_text_1=?, button_link_1=?, button_text_2=?, button_link_2=?, video_url=?, updated_at=NOW() WHERE id=?');
            $stmt->execute([$bgImage, $_POST['main_heading'], $_POST['sub_heading'], $_POST['button_text_1'], $_POST['button_link_1'], $_POST['button_text_2'], $_POST['button_link_2'], $_POST['video_url'], $hero['id']]);
            set_flash('Hero section updated successfully.');
        } else {
            $stmt = $pdo->prepare('INSERT INTO hero_sections (background_image, main_heading, sub_heading, button_text_1, button_link_1, button_text_2, button_link_2, video_url, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())');
            $stmt->execute([$bgImage, $_POST['main_heading'], $_POST['sub_heading'], $_POST['button_text_1'], $_POST['button_link_1'], $_POST['button_text_2'], $_POST['button_link_2'], $_POST['video_url']]);
            set_flash('Hero section saved successfully.');
        }
    }
    header('Location: hero.php');
    exit;
}
require_once __DIR__ . '/../includes/admin_header.php';
?>
<div class="card shadow-sm border-0 p-4">
    <h3>Hero Section</h3>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>" />
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Main Heading</label>
                <input type="text" name="main_heading" class="form-control" value="<?= e($hero['main_heading'] ?? '') ?>" required />
            </div>
            <div class="col-md-6">
                <label class="form-label">Sub Heading</label>
                <input type="text" name="sub_heading" class="form-control" value="<?= e($hero['sub_heading'] ?? '') ?>" required />
            </div>
            <div class="col-md-6">
                <label class="form-label">Button Text 1</label>
                <input type="text" name="button_text_1" class="form-control" value="<?= e($hero['button_text_1'] ?? '') ?>" />
            </div>
            <div class="col-md-6">
                <label class="form-label">Button Link 1</label>
                <input type="url" name="button_link_1" class="form-control" value="<?= e($hero['button_link_1'] ?? '') ?>" />
            </div>
            <div class="col-md-6">
                <label class="form-label">Button Text 2</label>
                <input type="text" name="button_text_2" class="form-control" value="<?= e($hero['button_text_2'] ?? '') ?>" />
            </div>
            <div class="col-md-6">
                <label class="form-label">Button Link 2</label>
                <input type="url" name="button_link_2" class="form-control" value="<?= e($hero['button_link_2'] ?? '') ?>" />
            </div>
            <div class="col-12">
                <label class="form-label">Background Image</label>
                <input type="file" name="background_image" class="form-control" />
                <?php if (!empty($hero['background_image'])): ?>
                    <img src="<?= e(site_url('uploads/events/' . $hero['background_image'])) ?>" class="img-thumbnail mt-2" width="180" />
                <?php endif; ?>
            </div>
            <div class="col-12">
                <label class="form-label">Video URL</label>
                <input type="url" name="video_url" class="form-control" value="<?= e($hero['video_url'] ?? '') ?>" placeholder="https://www.youtube.com/embed/..." />
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Save Hero Section</button>
        </div>
    </form>
</div>
<?php require_once __DIR__ . '/../includes/admin_footer.php';
