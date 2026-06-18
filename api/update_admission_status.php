<?php
require_once __DIR__ . '/../config/config.php';
header('Content-Type: application/json');
if (!is_admin_logged_in() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}
if (!validate_csrf($_POST['csrf_token'] ?? '')) {
    echo json_encode(['success' => false, 'message' => 'Invalid CSRF token.']);
    exit;
}
$stmt = $pdo->prepare('UPDATE admissions SET status=?, notes=?, updated_at=NOW() WHERE id=?');
$stmt->execute([$_POST['status'], $_POST['notes'], $_POST['id']]);
echo json_encode(['success' => true, 'message' => 'Admission status updated.']);
