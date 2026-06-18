<?php
$page = 'events';
require_once __DIR__ . '/../includes/header.php';
$events = $pdo->query('SELECT * FROM events ORDER BY event_date DESC')->fetchAll();
?>
<section class="container py-5">
    <div class="row mb-4">
        <div class="col-lg-8">
            <h1 class="fw-bold">Campus Events</h1>
            <p class="text-muted">Explore upcoming workshops, logistics conferences, and industry engagements hosted by our college.</p>
        </div>
    </div>
    <div class="row gy-4">
        <?php foreach ($events as $event): ?>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <img src="<?= e(site_url('uploads/events/' . $event['banner'])) ?>" class="card-img-top" alt="<?= e($event['title']) ?>" />
                    <div class="card-body">
                        <h5><?= e($event['title']) ?></h5>
                        <p class="text-muted mb-2">Date: <?= e(date('F d, Y', strtotime($event['event_date']))) ?></p>
                        <p class="mb-0"><?= e(substr($event['description'], 0, 120)) ?>...</p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php require_once __DIR__ . '/../includes/footer.php';
