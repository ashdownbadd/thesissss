<?php
header('Content-Type: application/json');

// Define the JSON file that stores the notifications
$jsonFile = 'emergency_alerts.json';

// Check if the file exists
if (file_exists($jsonFile)) {
    $notifications = json_decode(file_get_contents($jsonFile), true);
    echo json_encode($notifications);
} else {
    echo json_encode([]); // Return an empty array if the file doesn't exist
}
?>
