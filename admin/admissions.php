<?php
require_once __DIR__ . '/../config/config.php';
require_admin();
if (!empty($_GET['export']) && $_GET['export'] === 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="admissions.csv"');
    $rows = $pdo->query('SELECT * FROM admissions ORDER BY created_at DESC')->fetchAll();
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Name','Mobile','Email','City','State','Course Interested','Qualification','Status','Notes','Created At']);
    foreach ($rows as $row) {
        fputcsv($output, [$row['name'],$row['mobile'],$row['email'],$row['city'],$row['state'],$row['course_interested'],$row['qualification'],$row['status'],$row['notes'],$row['created_at']]);
    }
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_csrf($_POST['csrf_token'] ?? '')) {
        set_flash('Invalid request token.');
    } else {
        $stmt = $pdo->prepare('UPDATE admissions SET status=?, notes=?, updated_at=NOW() WHERE id=?');
        $stmt->execute([$_POST['status'], $_POST['notes'], $_POST['id']]);
        set_flash('Admission updated successfully.');
    }
    header('Location: admissions.php');
    exit;
}
admissions:
$admissions = $pdo->query('SELECT * FROM admissions ORDER BY created_at DESC')->fetchAll();
require_once __DIR__ . '/../includes/admin_header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Admissions</h3>
    <a href="<?= e(site_url('admin/admissions.php?export=csv')) ?>" class="btn btn-outline-primary">Export CSV</a>
</div>
<table class="table table-bordered align-middle">
    <thead>
        <tr>
            <th>Name</th>
            <th>Course</th>
            <th>Status</th>
            <th>Notes</th>
            <th>Submitted</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($admissions as $item): ?>
            <tr>
                <td><?= e($item['name']) ?><br><small><?= e($item['email']) ?> · <?= e($item['mobile']) ?></small></td>
                <td><?= e($item['course_interested']) ?></td>
                <td><?= e($item['status']) ?></td>
                <td><?= e($item['notes']) ?></td>
                <td><?= e(date('M j, Y', strtotime($item['created_at']))) ?></td>
                <td>
                    <form method="POST" class="admission-form d-flex flex-column gap-2">
                        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>" />
                        <input type="hidden" name="id" value="<?= e($item['id']) ?>" />
                        <select name="status" class="form-select form-select-sm" required>
                            <?php foreach (['New','Contacted','Interested','Admitted','Rejected'] as $status): ?>
                                <option value="<?= e($status) ?>" <?= $item['status'] === $status ? 'selected' : '' ?>><?= e($status) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <textarea name="notes" class="form-control form-control-sm" rows="2"><?= e($item['notes']) ?></textarea>
                        <button type="submit" class="btn btn-sm btn-primary">Save</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script>
    $('.admission-form').on('submit', function(event) {
        event.preventDefault();
        var form = $(this);
        var data = form.serialize();
        var button = form.find('button[type=submit]');
        button.prop('disabled', true).text('Saving...');
        $.post('<?= e(site_url('api/update_admission_status.php')) ?>', data, function(response) {
            if (response.success) {
                form.closest('tr').find('td:nth-child(3)').text(form.find('select[name=status]').val());
                button.text('Saved');
                setTimeout(function() { button.prop('disabled', false).text('Save'); }, 1000);
            } else {
                alert(response.message || 'Unable to save admission status.');
                button.prop('disabled', false).text('Save');
            }
        }, 'json').fail(function() {
            alert('Network error. Please try again.');
            button.prop('disabled', false).text('Save');
        });
    });
</script>
<?php require_once __DIR__ . '/../includes/admin_footer.php';
