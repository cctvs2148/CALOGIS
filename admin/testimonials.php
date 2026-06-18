<?php
require_once __DIR__ . '/../config/config.php';
require_admin();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_csrf($_POST['csrf_token'] ?? '')) {
        set_flash('Invalid request token.');
    } else {
        $photo = '';
        if (!empty($_FILES['photo']['name'])) {
            $photo = upload_file($_FILES['photo'], __DIR__ . '/../uploads/gallery');
        }
        if (!empty($_POST['id'])) {
            $stmt = $pdo->prepare('UPDATE testimonials SET student_name=?, course=?, photo=?, rating=?, review=?, updated_at=NOW() WHERE id=?');
            $stmt->execute([$_POST['student_name'], $_POST['course'], $photo ?: $_POST['existing_photo'], $_POST['rating'], $_POST['review'], $_POST['id']]);
            set_flash('Testimonial updated successfully.');
        } else {
            $stmt = $pdo->prepare('INSERT INTO testimonials (student_name, course, photo, rating, review, created_at) VALUES (?, ?, ?, ?, ?, NOW())');
            $stmt->execute([$_POST['student_name'], $_POST['course'], $photo, $_POST['rating'], $_POST['review']]);
            set_flash('Testimonial added successfully.');
        }
    }
    header('Location: testimonials.php');
    exit;
}
if (!empty($_GET['delete']) && validate_csrf($_GET['token'] ?? '')) {
    $stmt = $pdo->prepare('DELETE FROM testimonials WHERE id = ?');
    $stmt->execute([$_GET['delete']]);
    set_flash('Testimonial deleted successfully.');
    header('Location: testimonials.php');
    exit;
}
$testimonials = $pdo->query('SELECT * FROM testimonials ORDER BY id DESC')->fetchAll();
$edit = null;
if (!empty($_GET['edit'])) {
    $stmt = $pdo->prepare('SELECT * FROM testimonials WHERE id = ? LIMIT 1');
    $stmt->execute([$_GET['edit']]);
    $edit = $stmt->fetch();
}
require_once __DIR__ . '/../includes/admin_header.php';
?>
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm p-4">
            <h3>Testimonials</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Rating</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($testimonials as $item): ?>
                        <tr>
                            <td><?= e($item['student_name']) ?></td>
                            <td><?= e($item['course']) ?></td>
                            <td><?= e($item['rating']) ?></td>
                            <td>
                                <a href="<?= e(site_url('admin/testimonials.php?edit=' . $item['id'])) ?>" class="btn btn-sm btn-secondary">Edit</a>
                                <a href="<?= e(site_url('admin/testimonials.php?delete=' . $item['id'] . '&token=' . csrf_token())) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete testimonial?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm p-4">
            <h3><?= $edit ? 'Edit Testimonial' : 'Add Testimonial' ?></h3>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>" />
                <input type="hidden" name="id" value="<?= e($edit['id'] ?? '') ?>" />
                <input type="hidden" name="existing_photo" value="<?= e($edit['photo'] ?? '') ?>" />
                <div class="mb-3">
                    <label class="form-label">Student Name</label>
                    <input type="text" name="student_name" class="form-control" value="<?= e($edit['student_name'] ?? '') ?>" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">Course</label>
                    <input type="text" name="course" class="form-control" value="<?= e($edit['course'] ?? '') ?>" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">Photo</label>
                    <input type="file" name="photo" class="form-control" <?= $edit ? '' : 'required' ?> />
                    <?php if (!empty($edit['photo'])): ?>
                        <img src="<?= e(site_url('uploads/gallery/' . $edit['photo'])) ?>" class="img-thumbnail mt-2" width="100" />
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label class="form-label">Rating</label>
                    <input type="number" name="rating" class="form-control" value="<?= e($edit['rating'] ?? '') ?>" min="1" max="5" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">Review</label>
                    <textarea name="review" rows="4" class="form-control" required><?= e($edit['review'] ?? '') ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary"><?= $edit ? 'Update' : 'Add' ?></button>
            </form>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/admin_footer.php';
