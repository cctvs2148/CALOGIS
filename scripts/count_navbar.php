<?php
// scripts/count_navbar.php
ob_start();
require __DIR__ . '/../index.php';
$html = ob_get_clean();
$count = substr_count($html, 'navbar-brand');
echo "navbar-brand occurrences: $count\n";
// For debugging, optionally dump the brand snippet
$pos = strpos($html, 'navbar-brand');
if ($pos !== false) {
    echo "\nSnippet around first occurrence:\n" . substr($html, $pos, 200) . "\n";
}
