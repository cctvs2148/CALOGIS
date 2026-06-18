<?php
require_once __DIR__ . '/../config/config.php';
require_admin();
if (!empty($_GET['delete']) && validate_csrf($_GET['token'] ?? '')) {
    $stmt = $pdo->prepare('DELETE FROM courses WHERE id = ?');
    $stmt->execute([$_GET['delete']]);
    set_flash('Course deleted successfully.');
    header('Location: courses.php');
    exit;
}
$courses = $pdo->query('SELECT * FROM courses ORDER BY id DESC')->fetchAll();
require_once __DIR__ . '/../includes/admin_header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Courses</h3>
    <a href="<?= e(site_url('admin/course_form.php')) ?>" class="btn btn-primary">Add Course</a>
</div>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Name</th>
            <th>Duration</th>
            <th>Fees</th>
            <th>Eligibility</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($courses as $course): ?>
            <tr>
                <td><?= e($course['name']) ?></td>
                <td><?= e($course['duration']) ?></td>
                <td><?= e($course['fees']) ?></td>
                <td><?= e($course['eligibility']) ?></td>
                <td>
                    <a href="<?= e(site_url('admin/course_form.php?id=' . $course['id'])) ?>" class="btn btn-sm btn-secondary">Edit</a>
                    <a href="<?= e(site_url('admin/courses.php?delete=' . $course['id'] . '&token=' . csrf_token())) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this course?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php require_once __DIR__ . '/../includes/admin_footer.php';
