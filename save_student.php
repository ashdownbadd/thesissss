<?php
// Connect to the database
$servername = "localhost"; // Change this if your database is hosted elsewhere
$username = "root"; // Change this if necessary
$password = ""; // Change this if necessary
$dbname = "student_tracking";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $last_name = $_POST['last_name'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $extension = $_POST['extension'];
    $mobile_number = $_POST['mobile_no'];
    $email = $_POST['email'];
    $year_level = $_POST['year_level'];
    $section = $_POST['section'];
    $program = $_POST['program'];
    $emergency_name = $_POST['emergency_name'];
    $emergency_contact = $_POST['emergency_mobile'];
    $emergency_email = $_POST['emergency_email'];

    // Insert data into the 'student' table
    $sql = "INSERT INTO student (last_name, first_name, middle_name, extension, mobile_number, email, year_level, section, program, emergency_name, emergency_contact, emergency_email)
            VALUES ('$last_name', '$first_name', '$middle_name', '$extension', '$mobile_number', '$email', '$year_level', '$section', '$program', '$emergency_name', '$emergency_contact', '$emergency_email')";

    if ($conn->query($sql) === TRUE) {
        echo "Record saved successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>
