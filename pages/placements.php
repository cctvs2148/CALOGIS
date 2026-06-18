<?php
$page = 'placements';
require_once __DIR__ . '/../includes/header.php';
$placements = $pdo->query('SELECT * FROM placements ORDER BY id DESC')->fetchAll();
?>
<section class="container py-5">
    <div class="row mb-4">
        <div class="col-lg-8">
            <h1 class="fw-bold">Placements</h1>
            <p class="text-muted">Our graduates join leading logistics firms with strong salary packages and training-ready skills.</p>
        </div>
    </div>
    <div class="row gy-4">
        <?php foreach ($placements as $placement): ?>
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <img src="<?= e(site_url('uploads/events/' . $placement['logo'])) ?>" alt="<?= e($placement['recruiter_name']) ?>" width="80" />
                            <div>
                                <h5 class="mb-0"><?= e($placement['recruiter_name']) ?></h5>
                                <small class="text-muted">Package: <?= e($placement['package_details']) ?></small>
                            </div>
                        </div>
                        <p class="text-muted"><?= e($placement['placement_statistics']) ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php require_once __DIR__ . '/../includes/footer.php';
