<?php
$page = 'contact';
require_once __DIR__ . '/../includes/header.php';
$statusMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_csrf($_POST['csrf_token'] ?? '')) {
        $statusMessage = 'Invalid submission token.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO contact_messages (name, email, phone, subject, message, created_at) VALUES (?, ?, ?, ?, ?, NOW())');
        $stmt->execute([
            $_POST['name'],
            $_POST['email'],
            $_POST['phone'],
            $_POST['subject'],
            $_POST['message'],
        ]);
        $statusMessage = 'Thank you! Your message has been sent successfully.';
    }
}
$address = get_setting($pdo, 'contact_address', '123 Logistics Avenue, City');
$phone = get_setting($pdo, 'contact_phone', '+1 234 567 890');
$email = get_setting($pdo, 'contact_email', 'info@logisticscollege.edu');
$whatsapp = get_setting($pdo, 'contact_whatsapp', '+1234567890');
$maps = get_setting($pdo, 'contact_maps', 'https://www.google.com/maps');
?>
<section class="container py-5">
    <div class="row mb-4">
        <div class="col-lg-8">
            <h1 class="fw-bold">Contact Us</h1>
            <p class="text-muted">Need help? Reach out to our admissions and campus support teams.</p>
            <?php if ($statusMessage): ?>
                <div class="alert alert-success"><?= e($statusMessage) ?></div>
            <?php endif; ?>
        </div>
    </div>
    <div class="row gy-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm p-4">
                <h5>Contact Information</h5>
                <p class="mb-1"><strong>Address:</strong> <?= e($address) ?></p>
                <p class="mb-1"><strong>Phone:</strong> <?= e($phone) ?></p>
                <p class="mb-1"><strong>Email:</strong> <?= e($email) ?></p>
                <p class="mb-0"><strong>WhatsApp:</strong> <?= e($whatsapp) ?></p>
                <a target="_blank" href="<?= e($maps) ?>" class="d-block mt-3">View map</a>
            </div>
        </div>
        <div class="col-lg-6">
            <form method="POST" class="card border-0 shadow-sm p-4 bg-white">
                <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>" />
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">Subject</label>
                    <input type="text" name="subject" class="form-control" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">Message</label>
                    <textarea name="message" rows="5" class="form-control" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Send Message</button>
            </form>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/../includes/footer.php';
