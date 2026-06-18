<?php
$page = 'admissions';
require_once __DIR__ . '/../includes/header.php';
$statusMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_csrf($_POST['csrf_token'] ?? '')) {
        $statusMessage = 'Invalid submission token. Please try again.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO admissions (name, mobile, email, city, state, course_interested, qualification, message, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())');
        $stmt->execute([
            $_POST['name'],
            $_POST['mobile'],
            $_POST['email'],
            $_POST['city'],
            $_POST['state'],
            $_POST['course_interested'],
            $_POST['qualification'],
            $_POST['message'],
            'New',
        ]);
        $statusMessage = 'Your application has been submitted successfully. Our team will contact you soon.';
    }
}
$courses = $pdo->query('SELECT name FROM courses ORDER BY name ASC')->fetchAll(PDO::FETCH_COLUMN);
?>
<section class="container py-5">
    <div class="row mb-4">
        <div class="col-lg-8">
            <h1 class="fw-bold">Admissions</h1>
            <p class="text-muted">Apply for our logistics and supply chain management programs. Complete the form below and our admissions team will follow up.</p>
            <?php if ($statusMessage): ?>
                <div class="alert alert-success"><?= e($statusMessage) ?></div>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <form method="POST" class="row g-3 shadow-sm rounded p-4 bg-white">
                <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>" />
                <div class="col-md-6">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" required />
                </div>
                <div class="col-md-6">
                    <label class="form-label">Mobile</label>
                    <input type="text" name="mobile" class="form-control" required />
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required />
                </div>
                <div class="col-md-6">
                    <label class="form-label">City</label>
                    <input type="text" name="city" class="form-control" required />
                </div>
                <div class="col-md-6">
                    <label class="form-label">State</label>
                    <input type="text" name="state" class="form-control" required />
                </div>
                <div class="col-md-6">
                    <label class="form-label">Course Interested</label>
                    <select name="course_interested" class="form-select" required>
                        <option value="">Select Course</option>
                        <?php foreach ($courses as $course): ?>
                            <option value="<?= e($course) ?>"><?= e($course) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Qualification</label>
                    <input type="text" name="qualification" class="form-control" required />
                </div>
                <div class="col-12">
                    <label class="form-label">Message</label>
                    <textarea name="message" rows="4" class="form-control"></textarea>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Submit Application</button>
                </div>
            </form>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/../includes/footer.php';
