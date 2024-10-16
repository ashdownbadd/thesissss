<?php
session_start();

date_default_timezone_set('Asia/Manila');

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    http_response_code(403); // Forbidden
    exit('Unauthorized access.');
}

// Retrieve the data sent from the AJAX request
$username = $_POST['username'];
$last_name = $_POST['last_name'];
$timestamp = date("F j, Y h:i A"); // Format: Month Day, Year Hour:Minute AM/PM

// Log the emergency alert in a log file
$file = 'emergency_alerts.log'; // Change to your preferred logging method
$alert_message = "Emergency alert from $username ($last_name) at $timestamp\n";
file_put_contents($file, $alert_message, FILE_APPEND);

// Append the alert to the HTML notification file
$notification_file = 'notification.html';
$notification_entry = "<div class='notification'><strong>Emergency alert</strong> from $last_name sent at $timestamp</div>\n";
file_put_contents($notification_file, $notification_entry, FILE_APPEND);

// Optional: You can include additional notification logic here, e.g., send an email to the admin

// Send a success response
echo json_encode(['status' => 'success']);
?>
