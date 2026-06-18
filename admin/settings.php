<?php
require_once __DIR__ . '/../config/config.php';
require_admin();
$keys = [
    'site_title' => 'Site Title',
    'site_description' => 'Site Description',
    'contact_address' => 'Contact Address',
    'contact_phone' => 'Contact Phone',
    'contact_email' => 'Contact Email',
    'contact_whatsapp' => 'WhatsApp Number',
    'contact_maps' => 'Google Maps Link',
    'chairman_message' => 'Chairman Message',
    'principal_message' => 'Principal Message',
    'vision_statement' => 'Vision Statement',
    'mission_statement' => 'Mission Statement',
    'infrastructure_description' => 'Infrastructure Description',
    'industry_partnerships' => 'Industry Partnerships',
    'hero_button_text_1' => 'Hero Button Text 1',
    'hero_button_link_1' => 'Hero Button Link 1',
    'hero_button_text_2' => 'Hero Button Text 2',
    'hero_button_link_2' => 'Hero Button Link 2',
];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (validate_csrf($_POST['csrf_token'] ?? '')) {
        $stmt = $pdo->prepare('REPLACE INTO settings (`key`, `value`) VALUES (?, ?)');
        foreach ($keys as $key => $label) {
            $stmt->execute([$key, $_POST[$key] ?? '']);
        }
        set_flash('Settings updated successfully.');
    }
    header('Location: settings.php');
    exit;
}
$values = [];
$stmt = $pdo->query('SELECT `key`, `value` FROM settings');
foreach ($stmt->fetchAll() as $row) {
    $values[$row['key']] = $row['value'];
}
require_once __DIR__ . '/../includes/admin_header.php';
?>
<div class="card shadow-sm border-0 p-4">
    <h3>Site Settings</h3>
    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>" />
        <div class="row g-3">
            <?php foreach ($keys as $key => $label): ?>
                <div class="col-md-6">
                    <label class="form-label"><?= e($label) ?></label>
                    <?php if (strpos($key, 'message') !== false || strpos($key, 'description') !== false || strpos($key, 'partnerships') !== false): ?>
                        <textarea name="<?= e($key) ?>" rows="3" class="form-control"><?= e($values[$key] ?? '') ?></textarea>
                    <?php else: ?>
                        <input type="text" name="<?= e($key) ?>" class="form-control" value="<?= e($values[$key] ?? '') ?>" />
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Save Settings</button>
        </div>
    </form>
</div>
<?php require_once __DIR__ . '/../includes/admin_footer.php';
