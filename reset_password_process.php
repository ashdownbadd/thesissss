<?php
// Database connection
$host = "localhost";
$dbUsername = "root"; 
$dbPassword = ""; 
$dbname = "student_tracking"; 

$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'];
    $token = $_POST['token'];

    // Hash the new password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if token is valid and not expired
    $sql = "SELECT * FROM student WHERE reset_token='$token' AND token_expires > " . date("U");
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Token is valid, update password
        $sql = "UPDATE student SET password='$hashedPassword', reset_token=NULL, token_expires=NULL WHERE reset_token='$token'";
        if ($conn->query($sql) === TRUE) {
            echo "Password has been reset successfully.";
        } else {
            echo "Error updating password: " . $conn->error;
        }
    } else {
        echo "Invalid or expired token.";
    }
}

// Close connection
$conn->close();
?>
