<?php
require_once __DIR__ . '/../config/config.php';
require_admin();
$id = $_GET['id'] ?? null;
$isEdit = !empty($id);
$course = ['name' => '', 'duration' => '', 'eligibility' => '', 'fees' => '', 'description' => '', 'career_opportunities' => '', 'image' => ''];
if ($isEdit) {
    $stmt = $pdo->prepare('SELECT * FROM courses WHERE id = ? LIMIT 1');
    $stmt->execute([$id]);
    $course = $stmt->fetch() ?: $course;
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_csrf($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid request token.';
    } else {
        $image = $course['image'];
        if (!empty($_FILES['image']['name'])) {
            $uploaded = upload_file($_FILES['image'], __DIR__ . '/../uploads/courses');
            if ($uploaded) {
                $image = $uploaded;
            }
        }
        if ($isEdit) {
            $stmt = $pdo->prepare('UPDATE courses SET name=?, duration=?, eligibility=?, fees=?, description=?, career_opportunities=?, image=? WHERE id=?');
            $stmt->execute([$_POST['name'], $_POST['duration'], $_POST['eligibility'], $_POST['fees'], $_POST['description'], $_POST['career_opportunities'], $image, $id]);
            set_flash('Course updated successfully.');
        } else {
            $stmt = $pdo->prepare('INSERT INTO courses (name, image, duration, eligibility, fees, description, career_opportunities, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())');
            $stmt->execute([$_POST['name'], $image, $_POST['duration'], $_POST['eligibility'], $_POST['fees'], $_POST['description'], $_POST['career_opportunities']]);
            set_flash('Course added successfully.');
        }
        header('Location: courses.php');
        exit;
    }
}
require_once __DIR__ . '/../includes/admin_header.php';
?>
<div class="card shadow-sm border-0 p-4">
    <h3><?= $isEdit ? 'Edit Course' : 'Add Course' ?></h3>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= e($error) ?></div>
    <?php endif; ?>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>" />
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Course Name</label>
                <input type="text" name="name" class="form-control" value="<?= e($course['name']) ?>" required />
            </div>
            <div class="col-md-6">
                <label class="form-label">Duration</label>
                <input type="text" name="duration" class="form-control" value="<?= e($course['duration']) ?>" required />
            </div>
            <div class="col-md-6">
                <label class="form-label">Eligibility</label>
                <input type="text" name="eligibility" class="form-control" value="<?= e($course['eligibility']) ?>" required />
            </div>
            <div class="col-md-6">
                <label class="form-label">Fees</label>
                <input type="text" name="fees" class="form-control" value="<?= e($course['fees']) ?>" required />
            </div>
            <div class="col-12">
                <label class="form-label">Course Image</label>
                <input type="file" name="image" class="form-control" <?= $isEdit ? '' : 'required' ?> />
                <?php if ($isEdit && $course['image']): ?>
                    <img src="<?= e(site_url('uploads/courses/' . $course['image'])) ?>" class="img-thumbnail mt-2" width="150" />
                <?php endif; ?>
            </div>
            <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="description" rows="4" class="form-control" required><?= e($course['description']) ?></textarea>
            </div>
            <div class="col-12">
                <label class="form-label">Career Opportunities</label>
                <textarea name="career_opportunities" rows="3" class="form-control" required><?= e($course['career_opportunities']) ?></textarea>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Update Course' : 'Create Course' ?></button>
            <a href="<?= e(site_url('admin/courses.php')) ?>" class="btn btn-secondary">Back to Courses</a>
        </div>
    </form>
</div>
<?php require_once __DIR__ . '/../includes/admin_footer.php';
