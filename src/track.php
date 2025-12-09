<?php
// 1. CORS Headers
// Allows your main website to send data to this specific tracking server.
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

// 2. Handle Preflight Options Request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// 3. Receive Data
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (empty($data)) {
    // Return 204 even on empty data to prevent client-side errors
    http_response_code(204);
    exit();
}

// 4. Enrich Data (Server-Side)
$data['ip'] = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
$data['serverTime'] = date('Y-m-d H:i:s');

// 5. Write to Log
// We write to the 'data' subdirectory which is mapped to your host
$log_file = __DIR__ . '/data/traffic_logs.jsonl';
$log_entry = json_encode($data) . "\n";

file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX);

// 6. Response
http_response_code(204);
exit();
?>
