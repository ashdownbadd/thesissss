<?php
// Database connection
$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "student_tracking";

$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed.']));
}

// Fetch alerts from the log file
$file = 'emergency_alerts.log';
if (!file_exists($file)) {
    echo json_encode([]);
    exit();
}

$alerts = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$alertData = [];

foreach ($alerts as $line) {
    // Example log format: "Emergency alert from username (last_name) at timestamp"
    if (preg_match('/Emergency alert from (.*?) \((.*?)\) at (.*)/', $line, $matches)) {
        $alertData[] = [
            'username' => $matches[1],
            'last_name' => $matches[2],
            'timestamp' => $matches[3]
        ];
    }
}

// Sort alerts by timestamp ascending
usort($alertData, function($a, $b) {
    return strtotime($a['timestamp']) - strtotime($b['timestamp']);
});

echo json_encode($alertData);

$conn->close();
?>
