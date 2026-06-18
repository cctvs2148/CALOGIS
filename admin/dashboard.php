<?php
require_once __DIR__ . '/../config/config.php';
require_admin();
$stats = [
    'admissions' => $pdo->query('SELECT COUNT(*) FROM admissions')->fetchColumn(),
    'courses' => $pdo->query('SELECT COUNT(*) FROM courses')->fetchColumn(),
    'blogs' => $pdo->query('SELECT COUNT(*) FROM blogs')->fetchColumn(),
    'events' => $pdo->query('SELECT COUNT(*) FROM events')->fetchColumn(),
];
$recentAdmissions = $pdo->query('SELECT * FROM admissions ORDER BY created_at DESC LIMIT 5')->fetchAll();
require_once __DIR__ . '/../includes/admin_header.php';
?>
<div class="row g-4">
    <?php foreach ($stats as $label => $value): ?>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 p-4 h-100">
                <h6 class="text-uppercase text-muted mb-2"><?= e(ucfirst($label)) ?></h6>
                <h2 class="fw-bold mb-0"><?= e($value) ?></h2>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<div class="row mt-4">
    <div class="col-lg-6">
        <div class="card shadow-sm border-0 p-4">
            <h5 class="mb-3">Recent Admissions</h5>
            <div class="list-group">
                <?php foreach ($recentAdmissions as $app): ?>
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong><?= e($app['name']) ?></strong>
                                <div class="text-muted small"><?= e($app['course_interested']) ?> · <?= e($app['status']) ?></div>
                            </div>
                            <span class="badge bg-primary"><?= e(date('M j', strtotime($app['created_at']))) ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/admin_footer.php';
