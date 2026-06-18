<?php
require_once __DIR__ . '/../config/config.php';
require_admin();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_csrf($_POST['csrf_token'] ?? '')) {
        set_flash('Invalid request token.');
    } else {
        $banner = $_POST['existing_banner'] ?? '';
        if (!empty($_FILES['banner']['name'])) {
            $uploaded = upload_file($_FILES['banner'], __DIR__ . '/../uploads/events');
            if ($uploaded) {
                $banner = $uploaded;
            }
        }
        if (!empty($_POST['id'])) {
            $stmt = $pdo->prepare('UPDATE events SET title=?, event_date=?, banner=?, description=?, updated_at=NOW() WHERE id=?');
            $stmt->execute([$_POST['title'], $_POST['event_date'], $banner, $_POST['description'], $_POST['id']]);
            set_flash('Event updated successfully.');
        } else {
            $stmt = $pdo->prepare('INSERT INTO events (title, event_date, banner, description, created_at) VALUES (?, ?, ?, ?, NOW())');
            $stmt->execute([$_POST['title'], $_POST['event_date'], $banner, $_POST['description']]);
            set_flash('Event added successfully.');
        }
    }
    header('Location: events.php');
    exit;
}
if (!empty($_GET['delete']) && validate_csrf($_GET['token'] ?? '')) {
    $stmt = $pdo->prepare('DELETE FROM events WHERE id = ?');
    $stmt->execute([$_GET['delete']]);
    set_flash('Event deleted successfully.');
    header('Location: events.php');
    exit;
}
$events = $pdo->query('SELECT * FROM events ORDER BY event_date DESC')->fetchAll();
$edit = null;
if (!empty($_GET['edit'])) {
    $stmt = $pdo->prepare('SELECT * FROM events WHERE id = ? LIMIT 1');
    $stmt->execute([$_GET['edit']]);
    $edit = $stmt->fetch();
}
require_once __DIR__ . '/../includes/admin_header.php';
?>
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card shadow-sm border-0 p-4">
            <h3>Events</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($events as $event): ?>
                        <tr>
                            <td><?= e($event['title']) ?></td>
                            <td><?= e($event['event_date']) ?></td>
                            <td>
                                <a href="<?= e(site_url('admin/events.php?edit=' . $event['id'])) ?>" class="btn btn-sm btn-secondary">Edit</a>
                                <a href="<?= e(site_url('admin/events.php?delete=' . $event['id'] . '&token=' . csrf_token())) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete event?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card shadow-sm border-0 p-4">
            <h3><?= $edit ? 'Edit Event' : 'Add Event' ?></h3>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>" />
                <input type="hidden" name="id" value="<?= e($edit['id'] ?? '') ?>" />
                <input type="hidden" name="existing_banner" value="<?= e($edit['banner'] ?? '') ?>" />
                <div class="mb-3">
                    <label class="form-label">Event Title</label>
                    <input type="text" name="title" class="form-control" value="<?= e($edit['title'] ?? '') ?>" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">Event Date</label>
                    <input type="date" name="event_date" class="form-control" value="<?= e($edit['event_date'] ?? '') ?>" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">Event Banner</label>
                    <input type="file" name="banner" class="form-control" <?= $edit ? '' : 'required' ?> />
                    <?php if (!empty($edit['banner'])): ?>
                        <img src="<?= e(site_url('uploads/events/' . $edit['banner'])) ?>" class="img-thumbnail mt-2" width="120" />
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="5" class="form-control" required><?= e($edit['description'] ?? '') ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary"><?= $edit ? 'Update Event' : 'Add Event' ?></button>
            </form>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/admin_footer.php';
