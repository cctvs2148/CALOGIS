<?php
// scripts/print_site_title.php
require_once __DIR__ . '/../config/database.php';
$stmt = $pdo->prepare("SELECT `value` FROM settings WHERE `key` = 'site_title' LIMIT 1");
$stmt->execute();
$v = $stmt->fetchColumn();
echo "Current site_title: \n" . ($v ?? '[not set]') . "\n";
