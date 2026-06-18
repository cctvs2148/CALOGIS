<?php
require_once __DIR__ . '/../config/config.php';
require_admin();
if (!empty($_GET['delete']) && validate_csrf($_GET['token'] ?? '')) {
    $stmt = $pdo->prepare('DELETE FROM contact_messages WHERE id = ?');
    $stmt->execute([$_GET['delete']]);
    set_flash('Message deleted successfully.');
    header('Location: contact_messages.php');
    exit;
}
$messages = $pdo->query('SELECT * FROM contact_messages ORDER BY created_at DESC')->fetchAll();
require_once __DIR__ . '/../includes/admin_header.php';
?>
<div class="card shadow-sm border-0 p-4">
    <h3>Contact Messages</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Subject</th>
                <th>Email</th>
                <th>Submitted</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($messages as $msg): ?>
                <tr>
                    <td><?= e($msg['name']) ?></td>
                    <td><?= e($msg['subject']) ?></td>
                    <td><?= e($msg['email']) ?></td>
                    <td><?= e(date('M j, Y', strtotime($msg['created_at']))) ?></td>
                    <td>
                        <a href="#" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#messageModal<?= e($msg['id']) ?>">View</a>
                        <a href="<?= e(site_url('admin/contact_messages.php?delete=' . $msg['id'] . '&token=' . csrf_token())) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete message?');">Delete</a>
                    </td>
                </tr>
                <div class="modal fade" id="messageModal<?= e($msg['id']) ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Message from <?= e($msg['name']) ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Phone:</strong> <?= e($msg['phone']) ?></p>
                                <p><?= e($msg['message']) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require_once __DIR__ . '/../includes/admin_footer.php';
