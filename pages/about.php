<?php
$page = 'about';
require_once __DIR__ . '/../includes/header.php';
$chairman = get_setting($pdo, 'chairman_message', 'Our chairman believes in transformational logistics education.');
$principal = get_setting($pdo, 'principal_message', 'Our principal leads academic excellence and industry alignment.');
$vision = get_setting($pdo, 'vision_statement', 'To shape future leaders in the global supply chain sector.');
$mission = get_setting($pdo, 'mission_statement', 'Deliver practical logistics training with real-world placement support.');
$infrastructure = get_setting($pdo, 'infrastructure_description', 'A modern campus with smart classrooms, labs and simulation centers.');
$partnerships = get_setting($pdo, 'industry_partnerships', 'Supply chain companies, logistics providers and transport firms.');
?>
<section class="container py-5">
    <div class="row align-items-center mb-5">
        <div class="col-lg-6">
            <h1 class="fw-bold">About Logistics College</h1>
            <p class="lead text-muted">A premium college for logistics and supply chain management with a student-centered approach and strong employer relationships.</p>
        </div>
        <div class="col-lg-6"><img src="<?= e(site_url('assets/images/about-campus.svg')) ?>" alt="About college" class="img-fluid rounded shadow-sm" /></div>
    </div>

    <div class="row gy-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-4">
                <h5>Chairman Message</h5>
                <p class="text-muted"><?= e($chairman) ?></p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-4">
                <h5>Principal Message</h5>
                <p class="text-muted"><?= e($principal) ?></p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-4">
                <h5>Vision</h5>
                <p class="text-muted"><?= e($vision) ?></p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-4">
                <h5>Mission</h5>
                <p class="text-muted"><?= e($mission) ?></p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-4">
                <h5>Infrastructure</h5>
                <p class="text-muted"><?= e($infrastructure) ?></p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-4">
                <h5>Industry Partnerships</h5>
                <p class="text-muted"><?= e($partnerships) ?></p>
            </div>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/../includes/footer.php';
