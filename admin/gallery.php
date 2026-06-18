<?php
require_once __DIR__ . '/../config/config.php';
require_admin();
$categories = ['Campus', 'Events', 'Workshops', 'Industrial Visits'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_csrf($_POST['csrf_token'] ?? '')) {
        set_flash('Invalid request token.');
    } else {
        $type = $_POST['media_type'];
        $mediaFile = '';
        $mediaUrl = '';
        if ($type === 'image' && !empty($_FILES['media_file']['name'])) {
            $mediaFile = upload_file($_FILES['media_file'], __DIR__ . '/../uploads/gallery');
        }
        if ($type === 'video') {
            $mediaUrl = sanitize_url($_POST['media_url']);
        }
        $stmt = $pdo->prepare('INSERT INTO gallery (title, category, media_type, media_file, media_url, description, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())');
        $stmt->execute([$_POST['title'], $_POST['category'], $type, $mediaFile, $mediaUrl, $_POST['description']]);
        set_flash('Gallery item added successfully.');
    }
    header('Location: gallery.php');
    exit;
}
if (!empty($_GET['delete']) && validate_csrf($_GET['token'] ?? '')) {
    $stmt = $pdo->prepare('DELETE FROM gallery WHERE id = ?');
    $stmt->execute([$_GET['delete']]);
    set_flash('Gallery item deleted successfully.');
    header('Location: gallery.php');
    exit;
}
$items = $pdo->query('SELECT * FROM gallery ORDER BY created_at DESC')->fetchAll();
require_once __DIR__ . '/../includes/admin_header.php';
?>
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card shadow-sm border-0 p-4">
            <h3>Gallery</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?= e($item['title']) ?></td>
                            <td><?= e($item['category']) ?></td>
                            <td><?= e(ucfirst($item['media_type'])) ?></td>
                            <td>
                                <a href="<?= e(site_url('admin/gallery.php?delete=' . $item['id'] . '&token=' . csrf_token())) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete gallery item?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card shadow-sm border-0 p-4">
            <h3>Add Gallery Item</h3>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>" />
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select name="category" class="form-select" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= e($category) ?>"><?= e($category) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Media Type</label>
                    <select name="media_type" id="mediaType" class="form-select" required>
                        <option value="image">Image</option>
                        <option value="video">Video</option>
                    </select>
                </div>
                <div class="mb-3" id="imageField">
                    <label class="form-label">Image Upload</label>
                    <input type="file" name="media_file" class="form-control" />
                </div>
                <div class="mb-3 d-none" id="videoField">
                    <label class="form-label">Video URL</label>
                    <input type="url" name="media_url" class="form-control" placeholder="https://www.youtube.com/embed/..." />
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="3" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Add Gallery Item</button>
            </form>
        </div>
    </div>
</div>
<script>
    $('#mediaType').on('change', function() {
        if (this.value === 'video') {
            $('#imageField').addClass('d-none');
            $('#videoField').removeClass('d-none');
        } else {
            $('#videoField').addClass('d-none');
            $('#imageField').removeClass('d-none');
        }
    });
</script>
<?php require_once __DIR__ . '/../includes/admin_footer.php';
