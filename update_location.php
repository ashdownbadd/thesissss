<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    http_response_code(401);
    echo "Unauthorized";
    exit();
}

// Database connection parameters
$host = 'localhost';
$db   = 'student_tracking';
$user = 'db_username';
$pass = 'db_password';
$charset = 'utf8mb4';

// Set up DSN
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Set up options
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // Create PDO instance
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    http_response_code(500);
    echo "Database connection failed";
    exit();
}

// Retrieve POST data
$latitude = isset($_POST['latitude']) ? $_POST['latitude'] : null;
$longitude = isset($_POST['longitude']) ? $_POST['longitude'] : null;
$allowed = isset($_POST['allowed']) ? ($_POST['allowed'] === 'true' ? 1 : 0) : 0;

// Get the username from the session
$username = $_SESSION['username'];

if ($allowed) {
    // Update the user's location and permission status
    $stmt = $pdo->prepare("UPDATE students SET latitude = :latitude, longitude = :longitude, location_allowed = :allowed, last_location_update = NOW() WHERE username = :username");
    $stmt->execute([
        ':latitude' => $latitude,
        ':longitude' => $longitude,
        ':allowed' => $allowed,
        ':username' => $username
    ]);

    // Update session with location permission
    $_SESSION['location_allowed'] = $allowed;
} else {
    // Update only the permission status
    $stmt = $pdo->prepare("UPDATE students SET location_allowed = :allowed, last_location_update = NOW() WHERE username = :username");
    $stmt->execute([
        ':allowed' => $allowed,
        ':username' => $username
    ]);

    // Update session with location permission
    $_SESSION['location_allowed'] = $allowed;
}

echo "Success";
?>
