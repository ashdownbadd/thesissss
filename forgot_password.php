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
    $email = $_POST['email'];

    // Check if email exists in the database
    $sql = "SELECT * FROM student WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Email exists, generate a reset token
        $token = bin2hex(random_bytes(50)); // Generate a random token
        $expires = date("U") + 3600; // Token expires in 1 hour

        // Insert token into database (create a new table for this if necessary)
        $sql = "UPDATE student SET reset_token='$token', token_expires='$expires' WHERE email='$email'";
        if ($conn->query($sql) === TRUE) {
            // Send email with reset link
            $to = $email;
            $subject = "Password Reset Request";
            $message = "Here is your password reset link: http://yourwebsite.com/reset_password.php?token=$token";
            $headers = "From: no-reply@yourwebsite.com";

            if (mail($to, $subject, $message, $headers)) {
                echo "A password reset link has been sent to your email.";
            } else {
                echo "Failed to send email.";
            }
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "No account found with that email address.";
    }
}

// Close connection
$conn->close();
?>

<!-- reset_password.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Password</h2>
    <form action="reset_password_process.php" method="POST">
        <label for="password">New Password:</label>
        <input type="password" id="password" name="password" required>
        <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
