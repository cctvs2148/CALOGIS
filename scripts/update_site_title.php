<?php
// scripts/update_site_title.php
// Safe updater for `site_title` setting. Run from CLI or via browser with ?run=1

$desired = 'Logistics College Management System - CAIIHM Logistics College';

// Load DB config
$config = __DIR__ . '/../config/database.php';
if (!file_exists($config)) {
    echo "Database config not found at $config\n";
    exit(1);
}
require_once $config; // provides $pdo

try {
    if (php_sapi_name() === 'cli' || (isset($_GET['run']) && $_GET['run'] === '1')) {
        $pdo->beginTransaction();
        $stmt = $pdo->prepare("SELECT id, `value` FROM settings WHERE `key` = 'site_title' LIMIT 1");
        $stmt->execute();
        $row = $stmt->fetch();
        if ($row) {
            $update = $pdo->prepare("UPDATE settings SET `value` = ? WHERE id = ?");
            $update->execute([$desired, $row['id']]);
            echo "Updated site_title (id={$row['id']}).\n";
        } else {
            $ins = $pdo->prepare("INSERT INTO settings (`key`, `value`) VALUES ('site_title', ?)");
            $ins->execute([$desired]);
            echo "Inserted new site_title.\n";
        }
        $pdo->commit();
    } else {
        $self = basename(__FILE__);
        echo "To run this updater:\n";
        echo "  CLI: php scripts/$self\n";
        echo "  Browser: open /scripts/$self?run=1 in your local site\n";
        exit(0);
    }
} catch (Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo 'Error: ' . $e->getMessage() . "\n";
    exit(1);
}

return 0;
