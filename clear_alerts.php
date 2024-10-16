<?php
// clear_alerts.php

session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_username'])) {
    http_response_code(403); // Forbidden
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access.']);
    exit();
}

// Path to the emergency alerts log file
$log_file = 'emergency_alerts.log';

// Clear the log file
file_put_contents($log_file, '');

// Return a success response
echo json_encode(['status' => 'success', 'message' => 'Alerts cleared.']);
?>
