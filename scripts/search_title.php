<?php
ob_start();
require __DIR__ . '/../index.php';
$html = ob_get_clean();
$needle = 'Logistics College Management System - CAIIHM Logistics College';
echo "Occurrences of full title: " . substr_count($html, $needle) . "\n";
$short = 'CAIIHM Logistics College';
echo "Occurrences of short title: " . substr_count($html, $short) . "\n\n";

// Print snippets
$offset = 0;
for ($i = 0; $i < 5; $i++) {
	$pos = strpos($html, $needle, $offset);
	if ($pos === false) break;
	echo "Full title snippet #" . ($i+1) . ":\n" . substr($html, max(0, $pos-80), 200) . "\n\n";
	$offset = $pos + strlen($needle);
}

$offset = 0;
for ($i = 0; $i < 5; $i++) {
	$pos = strpos($html, $short, $offset);
	if ($pos === false) break;
	echo "Short title snippet #" . ($i+1) . ":\n" . substr($html, max(0, $pos-80), 200) . "\n\n";
	$offset = $pos + strlen($short);
}
