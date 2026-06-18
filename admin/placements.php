<?php
require_once __DIR__ . '/../config/config.php';
require_admin();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_csrf($_POST['csrf_token'] ?? '')) {
        set_flash('Invalid request token.');
    } else {
        if (!empty($_POST['id'])) {
            $stmt = $pdo->prepare('UPDATE placements SET recruiter_name=?, logo=?, package_details=?, placement_statistics=?, updated_at=NOW() WHERE id=?');
            $logo = $_POST['existing_logo'];
            if (!empty($_FILES['logo']['name'])) {
                $uploaded = upload_file($_FILES['logo'], __DIR__ . '/../uploads/events');
                if ($uploaded) {
                    $logo = $uploaded;
                }
            }
            $stmt->execute([$_POST['recruiter_name'], $logo, $_POST['package_details'], $_POST['placement_statistics'], $_POST['id']]);
            set_flash('Placement updated successfully.');
        } else {
            $stmt = $pdo->prepare('INSERT INTO placements (recruiter_name, logo, package_details, placement_statistics, created_at) VALUES (?, ?, ?, ?, NOW())');
            $logo = upload_file($_FILES['logo'], __DIR__ . '/../uploads/events');
            $stmt->execute([$_POST['recruiter_name'], $logo, $_POST['package_details'], $_POST['placement_statistics']]);
            set_flash('Placement added successfully.');
        }
    }
    header('Location: placements.php');
    exit;
}
if (!empty($_GET['delete']) && validate_csrf($_GET['token'] ?? '')) {
    $stmt = $pdo->prepare('DELETE FROM placements WHERE id = ?');
    $stmt->execute([$_GET['delete']]);
    set_flash('Placement removed successfully.');
    header('Location: placements.php');
    exit;
}
$placements = $pdo->query('SELECT * FROM placements ORDER BY id DESC')->fetchAll();
$edit = null;
if (!empty($_GET['edit'])) {
    $stmt = $pdo->prepare('SELECT * FROM placements WHERE id = ? LIMIT 1');
    $stmt->execute([$_GET['edit']]);
    $edit = $stmt->fetch();
}
require_once __DIR__ . '/../includes/admin_header.php';
?>
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card shadow-sm border-0 p-4">
            <h3 class="mb-3">Placements</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Recruiter</th>
                        <th>Package</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($placements as $placement): ?>
                        <tr>
                            <td><?= e($placement['recruiter_name']) ?></td>
                            <td><?= e($placement['package_details']) ?></td>
                            <td>
                                <a href="<?= e(site_url('admin/placements.php?edit=' . $placement['id'])) ?>" class="btn btn-sm btn-secondary">Edit</a>
                                <a href="<?= e(site_url('admin/placements.php?delete=' . $placement['id'] . '&token=' . csrf_token())) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete placement?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card shadow-sm border-0 p-4">
            <h3><?= $edit ? 'Edit Placement' : 'Add Placement' ?></h3>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>" />
                <input type="hidden" name="id" value="<?= e($edit['id'] ?? '') ?>" />
                <input type="hidden" name="existing_logo" value="<?= e($edit['logo'] ?? '') ?>" />
                <div class="mb-3">
                    <label class="form-label">Recruiter Name</label>
                    <input type="text" name="recruiter_name" class="form-control" value="<?= e($edit['recruiter_name'] ?? '') ?>" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">Recruiter Logo</label>
                    <input type="file" name="logo" class="form-control" <?= $edit ? '' : 'required' ?> />
                    <?php if (!empty($edit['logo'])): ?>
                        <img src="<?= e(site_url('uploads/events/' . $edit['logo'])) ?>" class="img-thumbnail mt-2" width="100" />
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label class="form-label">Package Details</label>
                    <input type="text" name="package_details" class="form-control" value="<?= e($edit['package_details'] ?? '') ?>" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">Placement Statistics</label>
                    <textarea name="placement_statistics" rows="4" class="form-control" required><?= e($edit['placement_statistics'] ?? '') ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary"><?= $edit ? 'Update' : 'Create' ?></button>
            </form>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/admin_footer.php';
