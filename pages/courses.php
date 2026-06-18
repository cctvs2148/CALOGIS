<?php
$page = 'courses';
require_once __DIR__ . '/../includes/header.php';
$courses = $pdo->query('SELECT * FROM courses ORDER BY id DESC')->fetchAll();
?>
<section class="container py-5">
    <div class="row mb-4">
        <div class="col-lg-8">
            <h1 class="fw-bold">Our Courses</h1>
            <p class="text-muted">Choose from specialized logistics and supply chain programs designed for careers in transportation, warehousing, procurement and distribution operations.</p>
        </div>
    </div>
    <div class="row gy-4">
        <?php foreach ($courses as $course): ?>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="row g-0 align-items-center">
                        <div class="col-md-5">
                            <img src="<?= e(site_url('uploads/courses/' . $course['image'])) ?>" alt="<?= e($course['name']) ?>" class="img-fluid rounded-start" />
                        </div>
                        <div class="col-md-7">
                            <div class="card-body">
                                <h5 class="card-title"><?= e($course['name']) ?></h5>
                                <p class="text-muted mb-2">Duration: <?= e($course['duration']) ?></p>
                                <p class="mb-2"><strong>Fees:</strong> <?= e($course['fees']) ?></p>
                                <p class="text-muted mb-2"><strong>Eligibility:</strong> <?= e($course['eligibility']) ?></p>
                                <p class="text-smaller mb-2"><?= e(substr($course['description'], 0, 120)) ?>...</p>
                                <p class="text-muted small"><strong>Career Opportunities:</strong> <?= e($course['career_opportunities']) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php require_once __DIR__ . '/../includes/footer.php';
