<?php
// update.php

// Database connection
$servername = "localhost"; // Change if needed
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "student_tracking"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $student_id = $_POST['student_id'];
    $last_name = $_POST['last_name'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $extension = $_POST['extension'];
    $mobile_no = $_POST['mobile_no'];
    $email = $_POST['email'];
    $year_level = $_POST['year_level'];
    $section = $_POST['section'];
    $program = $_POST['program'];

    // Prepare and bind
    $stmt = $conn->prepare("UPDATE student SET last_name=?, first_name=?, middle_name=?, extension=?, mobile_no=?, email=?, year_level=?, section=?, program=? WHERE student_id=?");
    $stmt->bind_param("ssssssssss", $last_name, $first_name, $middle_name, $extension, $mobile_no, $email, $year_level, $section, $program, $student_id);

   // Execute the statement
   if ($stmt->execute()) {
    // Set success message in session
    $_SESSION['success'] = "Record updated successfully";
    // Redirect to profile.php
    header("Location: profile.php");
    exit();
} else {
    echo "Error updating record: " . $stmt->error;
}

    // Close statement and connection
    $stmt->close();
}

$conn->close();
?>
