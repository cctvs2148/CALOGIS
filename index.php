<<<<<<< HEAD
<?php
$page = 'home';
require_once __DIR__ . '/includes/header.php';

$hero = $pdo->query('SELECT * FROM hero_sections ORDER BY id DESC LIMIT 1')->fetch() ?: [];
$courses = $pdo->query('SELECT * FROM courses ORDER BY id DESC LIMIT 4')->fetchAll() ?: [];
$events = $pdo->query('SELECT * FROM events ORDER BY event_date DESC LIMIT 3')->fetchAll() ?: [];
$blogs = $pdo->query('SELECT * FROM blogs ORDER BY created_at DESC LIMIT 3')->fetchAll() ?: [];
$testimonials = $pdo->query('SELECT * FROM testimonials ORDER BY id DESC LIMIT 3')->fetchAll() ?: [];
$stats = [
    'courses' => $pdo->query('SELECT COUNT(*) FROM courses')->fetchColumn(),
    'events' => $pdo->query('SELECT COUNT(*) FROM events')->fetchColumn(),
    'blogs' => $pdo->query('SELECT COUNT(*) FROM blogs')->fetchColumn(),
    'gallery' => $pdo->query('SELECT COUNT(*) FROM gallery')->fetchColumn(),
];
?>
<section class="hero-section position-relative overflow-hidden" style="background: url('<?= e(!empty($hero['background_image']) ? site_url('uploads/events/' . $hero['background_image']) : site_url('assets/images/hero.svg')) ?>') center/cover no-repeat;">
    <div class="hero-overlay"></div>
    <div class="hero-layer hero-layer--far"></div>
    <div class="hero-layer hero-layer--mid"></div>
    <div class="hero-layer hero-layer--near"></div>
    <div class="hero-globe">
        <div class="hero-globe__sphere"></div>
        <div class="hero-globe__ring hero-globe__ring--x"></div>
        <div class="hero-globe__ring hero-globe__ring--y"></div>
        <div class="hero-globe__ring hero-globe__ring--z"></div>
    </div>
    <div class="hero-paths">
        <div class="hero-path hero-path--one"></div>
        <div class="hero-path hero-path--two"></div>
        <div class="hero-path hero-path--three"></div>
    </div>
    <div class="hero-transport-icons">
        <div class="hero-icon hero-icon--truck" data-depth="0.9" style="top: 14%; left: 12%;"></div>
        <div class="hero-icon hero-icon--container" data-depth="0.7" style="top: 28%; left: 72%;"></div>
        <div class="hero-icon hero-icon--plane" data-depth="1.3" style="top: 10%; left: 52%;"></div>
        <div class="hero-icon hero-icon--ship" data-depth="0.8" style="top: 70%; left: 62%;"></div>
        <div class="hero-icon hero-icon--crane" data-depth="0.6" style="top: 38%; left: 24%;"></div>
        <div class="hero-icon hero-icon--drone" data-depth="1.1" style="top: 18%; left: 86%;"></div>
        <div class="hero-icon hero-icon--warehouse" data-depth="0.5" style="top: 58%; left: 34%;"></div>
        <div class="hero-icon hero-icon--forklift" data-depth="0.8" style="top: 48%; left: 84%;"></div>
    </div>
    <div class="container hero-content py-5 text-white">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <span class="badge bg-warning text-dark mb-3">Logistics & Supply Chain</span>
                <h1 class="display-5 fw-bold mb-3"><?= e($hero['main_heading'] ?? 'Advance Your Career in Logistics & Supply Chain Management') ?></h1>
                <p class="lead mb-4"><?= e($hero['sub_heading'] ?? 'Top-rated college focused on modern logistics education, placements, and industry partnerships.') ?></p>
                <div class="d-flex gap-3 flex-wrap">
                    <?php if (!empty($hero['button_text_1'])): ?>
                        <a href="<?= e($hero['button_link_1'] ?? site_url('pages/admissions.php')) ?>" class="btn btn-warning btn-lg text-dark"><?= e($hero['button_text_1']) ?></a>
                    <?php endif; ?>
                    <?php if (!empty($hero['button_text_2'])): ?>
                        <a href="<?= e($hero['button_link_2'] ?? site_url('pages/contact.php')) ?>" class="btn btn-outline-light btn-lg"><?= e($hero['button_text_2']) ?></a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-5 text-center">
                <?php if (!empty($hero['video_url'])): ?>
                    <div class="ratio ratio-16x9 shadow-lg rounded">
                        <iframe src="<?= e($hero['video_url']) ?>" title="Intro Video" allowfullscreen></iframe>
                    </div>
                <?php else: ?>
                    <img src="<?= e(site_url('assets/images/hero.svg')) ?>" class="img-fluid rounded shadow-lg" alt="Logistics overview" />
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<section class="container py-5">
    <div class="row text-center mb-4">
        <div class="col-md-3">
            <div class="stats-card p-4 shadow-sm rounded bg-white">
                <h2 class="display-6 text-primary"><?= e($stats['courses']) ?></h2>
                <p class="mb-0 text-muted">Courses</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card p-4 shadow-sm rounded bg-white">
                <h2 class="display-6 text-primary"><?= e($stats['events']) ?></h2>
                <p class="mb-0 text-muted">Events</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card p-4 shadow-sm rounded bg-white">
                <h2 class="display-6 text-primary"><?= e($stats['blogs']) ?></h2>
                <p class="mb-0 text-muted">Blog Posts</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card p-4 shadow-sm rounded bg-white">
                <h2 class="display-6 text-primary"><?= e($stats['gallery']) ?></h2>
                <p class="mb-0 text-muted">Gallery Items</p>
            </div>
        </div>
    </div>

    <div class="row align-items-center mb-5">
        <div class="col-lg-6">
            <img src="<?= e(site_url('assets/images/about-campus.svg')) ?>" alt="About logistics college" class="img-fluid rounded shadow-sm" />
        </div>
        <div class="col-lg-6">
            <h2 class="fw-bold">Modern Logistics Education with Career-Focused Training</h2>
            <p class="text-muted">Our college offers specialized courses in logistics and supply chain operations, preparing students for high-demand roles across freight, warehousing, procurement and transport management.</p>
            <a href="<?= e(site_url('pages/about.php')) ?>" class="btn btn-primary">Learn More</a>
        </div>
    </div>

    <h3 class="mb-4">Featured Courses</h3>
    <div class="row gy-4">
        <?php if (!empty($courses)): ?>
            <?php foreach ($courses as $course): ?>
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="<?= e(site_url('uploads/courses/' . $course['image'])) ?>" class="card-img-top" alt="<?= e($course['name']) ?>" />
                        <div class="card-body">
                            <h5 class="card-title"><?= e($course['name']) ?></h5>
                            <p class="card-text text-muted mb-2">Duration: <?= e($course['duration']) ?></p>
                            <p class="card-text"><?= e(substr($course['description'], 0, 100)) ?>...</p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-secondary rounded-4">No featured courses are available right now. Please check back soon.</div>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="bg-light py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3>Upcoming Events</h3>
                <p class="text-muted">Stay connected with seminars, industry drives, and campus workshops.</p>
            </div>
            <a href="<?= e(site_url('pages/events.php')) ?>" class="btn btn-outline-primary">View All Events</a>
        </div>
        <div class="row gy-4">
            <?php if (!empty($events)): ?>
                <?php foreach ($events as $event): ?>
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm border-0">
                            <img src="<?= e(site_url('uploads/events/' . $event['banner'])) ?>" class="card-img-top" alt="<?= e($event['title']) ?>" />
                            <div class="card-body">
                                <h5><?= e($event['title']) ?></h5>
                                <p class="text-muted mb-2"><?= e(date('F j, Y', strtotime($event['event_date']))) ?></p>
                                <p class="mb-0"><?= e(substr($event['description'], 0, 120)) ?>...</p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-secondary rounded-4">No upcoming events are scheduled yet. Check back for future workshops and seminars.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3>Student Testimonials</h3>
            <p class="text-muted">Hear from students who completed courses and entered successful logistics careers.</p>
        </div>
        <a href="<?= e(site_url('pages/about.php')) ?>" class="btn btn-outline-primary">Our Story</a>
    </div>
    <div class="row gy-4">
        <?php if (!empty($testimonials)): ?>
            <?php foreach ($testimonials as $testimony): ?>
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 p-4 h-100">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <img src="<?= e(site_url('uploads/gallery/' . $testimony['photo'])) ?>" alt="<?= e($testimony['student_name']) ?>" class="rounded-circle" width="64" height="64" />
                            <div>
                                <h6 class="mb-0"><?= e($testimony['student_name']) ?></h6>
                                <small class="text-muted"><?= e($testimony['course']) ?></small>
                            </div>
                        </div>
                        <p class="mb-3">"<?= e($testimony['review']) ?>"</p>
                        <div class="text-warning">
                            <?= str_repeat('★', min(5, max(0, (int)$testimony['rating']))) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-secondary rounded-4">Student testimonials are coming soon. Explore our programs and success stories in the meantime.</div>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="bg-primary text-white py-5">
    <div class="container text-center">
        <h2 class="fw-bold">Build Your Future in Logistics</h2>
        <p class="lead">Apply today and join a career-focused logistics college with strong industry ties.</p>
        <a href="<?= e(site_url('pages/admissions.php')) ?>" class="btn btn-warning btn-lg text-dark">Apply Now</a>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php';
=======
<?php
$page = 'home';
require_once __DIR__ . '/includes/header.php';

$hero = $pdo->query('SELECT * FROM hero_sections ORDER BY id DESC LIMIT 1')->fetch() ?: [];
$courses = $pdo->query('SELECT * FROM courses ORDER BY id DESC LIMIT 4')->fetchAll() ?: [];
$events = $pdo->query('SELECT * FROM events ORDER BY event_date DESC LIMIT 3')->fetchAll() ?: [];
$blogs = $pdo->query('SELECT * FROM blogs ORDER BY created_at DESC LIMIT 3')->fetchAll() ?: [];
$testimonials = $pdo->query('SELECT * FROM testimonials ORDER BY id DESC LIMIT 3')->fetchAll() ?: [];
$stats = [
    'courses' => $pdo->query('SELECT COUNT(*) FROM courses')->fetchColumn(),
    'events' => $pdo->query('SELECT COUNT(*) FROM events')->fetchColumn(),
    'blogs' => $pdo->query('SELECT COUNT(*) FROM blogs')->fetchColumn(),
    'gallery' => $pdo->query('SELECT COUNT(*) FROM gallery')->fetchColumn(),
];
?>
<section class="hero-section position-relative overflow-hidden" style="background: url('<?= e(!empty($hero['background_image']) ? site_url('uploads/events/' . $hero['background_image']) : site_url('assets/images/hero.svg')) ?>') center/cover no-repeat;">
    <div class="hero-overlay"></div>
    <div class="hero-layer hero-layer--far"></div>
    <div class="hero-layer hero-layer--mid"></div>
    <div class="hero-layer hero-layer--near"></div>
    <div class="hero-globe">
        <div class="hero-globe__sphere"></div>
        <div class="hero-globe__ring hero-globe__ring--x"></div>
        <div class="hero-globe__ring hero-globe__ring--y"></div>
        <div class="hero-globe__ring hero-globe__ring--z"></div>
    </div>
    <div class="hero-paths">
        <div class="hero-path hero-path--one"></div>
        <div class="hero-path hero-path--two"></div>
        <div class="hero-path hero-path--three"></div>
    </div>
    <div class="hero-transport-icons">
        <div class="hero-icon hero-icon--truck" data-depth="0.9" style="top: 14%; left: 12%;"></div>
        <div class="hero-icon hero-icon--container" data-depth="0.7" style="top: 28%; left: 72%;"></div>
        <div class="hero-icon hero-icon--plane" data-depth="1.3" style="top: 10%; left: 52%;"></div>
        <div class="hero-icon hero-icon--ship" data-depth="0.8" style="top: 70%; left: 62%;"></div>
        <div class="hero-icon hero-icon--crane" data-depth="0.6" style="top: 38%; left: 24%;"></div>
        <div class="hero-icon hero-icon--drone" data-depth="1.1" style="top: 18%; left: 86%;"></div>
        <div class="hero-icon hero-icon--warehouse" data-depth="0.5" style="top: 58%; left: 34%;"></div>
        <div class="hero-icon hero-icon--forklift" data-depth="0.8" style="top: 48%; left: 84%;"></div>
    </div>
    <div class="container hero-content py-5 text-white">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <span class="badge bg-warning text-dark mb-3">Logistics & Supply Chain</span>
                <h1 class="display-5 fw-bold mb-3"><?= e($hero['main_heading'] ?? 'Advance Your Career in Logistics & Supply Chain Management') ?></h1>
                <p class="lead mb-4"><?= e($hero['sub_heading'] ?? 'Top-rated college focused on modern logistics education, placements, and industry partnerships.') ?></p>
                <div class="d-flex gap-3 flex-wrap">
                    <?php if (!empty($hero['button_text_1'])): ?>
                        <a href="<?= e($hero['button_link_1'] ?? site_url('pages/admissions.php')) ?>" class="btn btn-warning btn-lg text-dark"><?= e($hero['button_text_1']) ?></a>
                    <?php endif; ?>
                    <?php if (!empty($hero['button_text_2'])): ?>
                        <a href="<?= e($hero['button_link_2'] ?? site_url('pages/contact.php')) ?>" class="btn btn-outline-light btn-lg"><?= e($hero['button_text_2']) ?></a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-5 text-center">
                <?php if (!empty($hero['video_url'])): ?>
                    <div class="ratio ratio-16x9 shadow-lg rounded">
                        <iframe src="<?= e($hero['video_url']) ?>" title="Intro Video" allowfullscreen></iframe>
                    </div>
                <?php else: ?>
                    <img src="<?= e(site_url('assets/images/hero.svg')) ?>" class="img-fluid rounded shadow-lg" alt="Logistics overview" />
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<section class="container py-5">
    <div class="row text-center mb-4">
        <div class="col-md-3">
            <div class="stats-card p-4 shadow-sm rounded bg-white">
                <h2 class="display-6 text-primary"><?= e($stats['courses']) ?></h2>
                <p class="mb-0 text-muted">Courses</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card p-4 shadow-sm rounded bg-white">
                <h2 class="display-6 text-primary"><?= e($stats['events']) ?></h2>
                <p class="mb-0 text-muted">Events</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card p-4 shadow-sm rounded bg-white">
                <h2 class="display-6 text-primary"><?= e($stats['blogs']) ?></h2>
                <p class="mb-0 text-muted">Blog Posts</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card p-4 shadow-sm rounded bg-white">
                <h2 class="display-6 text-primary"><?= e($stats['gallery']) ?></h2>
                <p class="mb-0 text-muted">Gallery Items</p>
            </div>
        </div>
    </div>

    <div class="row align-items-center mb-5">
        <div class="col-lg-6">
            <img src="<?= e(site_url('assets/images/about-campus.svg')) ?>" alt="About logistics college" class="img-fluid rounded shadow-sm" />
        </div>
        <div class="col-lg-6">
            <h2 class="fw-bold">Modern Logistics Education with Career-Focused Training</h2>
            <p class="text-muted">Our college offers specialized courses in logistics and supply chain operations, preparing students for high-demand roles across freight, warehousing, procurement and transport management.</p>
            <a href="<?= e(site_url('pages/about.php')) ?>" class="btn btn-primary">Learn More</a>
        </div>
    </div>

    <h3 class="mb-4">Featured Courses</h3>
    <div class="row gy-4">
        <?php if (!empty($courses)): ?>
            <?php foreach ($courses as $course): ?>
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="<?= e(site_url('uploads/courses/' . $course['image'])) ?>" class="card-img-top" alt="<?= e($course['name']) ?>" />
                        <div class="card-body">
                            <h5 class="card-title"><?= e($course['name']) ?></h5>
                            <p class="card-text text-muted mb-2">Duration: <?= e($course['duration']) ?></p>
                            <p class="card-text"><?= e(substr($course['description'], 0, 100)) ?>...</p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-secondary rounded-4">No featured courses are available right now. Please check back soon.</div>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="bg-light py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3>Upcoming Events</h3>
                <p class="text-muted">Stay connected with seminars, industry drives, and campus workshops.</p>
            </div>
            <a href="<?= e(site_url('pages/events.php')) ?>" class="btn btn-outline-primary">View All Events</a>
        </div>
        <div class="row gy-4">
            <?php if (!empty($events)): ?>
                <?php foreach ($events as $event): ?>
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm border-0">
                            <img src="<?= e(site_url('uploads/events/' . $event['banner'])) ?>" class="card-img-top" alt="<?= e($event['title']) ?>" />
                            <div class="card-body">
                                <h5><?= e($event['title']) ?></h5>
                                <p class="text-muted mb-2"><?= e(date('F j, Y', strtotime($event['event_date']))) ?></p>
                                <p class="mb-0"><?= e(substr($event['description'], 0, 120)) ?>...</p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-secondary rounded-4">No upcoming events are scheduled yet. Check back for future workshops and seminars.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3>Student Testimonials</h3>
            <p class="text-muted">Hear from students who completed courses and entered successful logistics careers.</p>
        </div>
        <a href="<?= e(site_url('pages/about.php')) ?>" class="btn btn-outline-primary">Our Story</a>
    </div>
    <div class="row gy-4">
        <?php if (!empty($testimonials)): ?>
            <?php foreach ($testimonials as $testimony): ?>
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 p-4 h-100">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <img src="<?= e(site_url('uploads/gallery/' . $testimony['photo'])) ?>" alt="<?= e($testimony['student_name']) ?>" class="rounded-circle" width="64" height="64" />
                            <div>
                                <h6 class="mb-0"><?= e($testimony['student_name']) ?></h6>
                                <small class="text-muted"><?= e($testimony['course']) ?></small>
                            </div>
                        </div>
                        <p class="mb-3">"<?= e($testimony['review']) ?>"</p>
                        <div class="text-warning">
                            <?= str_repeat('★', min(5, max(0, (int)$testimony['rating']))) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-secondary rounded-4">Student testimonials are coming soon. Explore our programs and success stories in the meantime.</div>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="bg-primary text-white py-5">
    <div class="container text-center">
        <h2 class="fw-bold">Build Your Future in Logistics</h2>
        <p class="lead">Apply today and join a career-focused logistics college with strong industry ties.</p>
        <a href="<?= e(site_url('pages/admissions.php')) ?>" class="btn btn-warning btn-lg text-dark">Apply Now</a>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php';
>>>>>>> 34d40bb (Initial commit)
