<?php
// Database connection
$host = "localhost"; // Change if different
$dbUsername = "root"; // Change if different
$dbPassword = ""; // Change if different
$dbname = "student_tracking"; // Your database name

$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

// Check for connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password']; // Get the password from the POST request
    $studentNumber = $_POST['studentnumber'];

    // Check if username already exists
    $usernameCheck = $conn->prepare("SELECT * FROM student WHERE username = ?");
    $usernameCheck->bind_param("s", $username);
    $usernameCheck->execute();
    $usernameResult = $usernameCheck->get_result();

    // Check if student number already exists
    $studentNumberCheck = $conn->prepare("SELECT * FROM student WHERE student_id = ?");
    $studentNumberCheck->bind_param("s", $studentNumber);
    $studentNumberCheck->execute();
    $studentNumberResult = $studentNumberCheck->get_result();

    if ($usernameResult->num_rows > 0) {
        echo "<script>alert('Username already exists.'); window.history.back();</script>";
        exit();
    }

    if ($studentNumberResult->num_rows > 0) {
        echo "<script>alert('Student number already exists.'); window.history.back();</script>";
        exit();
    }

    // If checks pass, proceed with registration
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $extension = $_POST['extension'];
    $mobilenumber = $_POST['mobilenumber'];
    $email = $_POST['email'];
    $yearlevel = $_POST['yearlevel'];
    $section = $_POST['section'];
    $program = $_POST['program'];
    $emergencyName = $_POST['fullname'];
    $emergencyMobile = $_POST['emergencymobilenumber'];

    // Hash the password before inserting it into the database
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user into the database, including the role as 'student'
    $stmt = $conn->prepare("INSERT INTO student (username, password, student_id, last_name, first_name, middle_name, extension, mobile_no, email, year_level, section, program, emergency_name, emergency_no, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'student')");
    $stmt->bind_param("ssssssssssssss", $username, $hashedPassword, $studentNumber, $lastname, $firstname, $middlename, $extension, $mobilenumber, $email, $yearlevel, $section, $program, $emergencyName, $emergencyMobile);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful!'); window.location.href='signin.html';</script>";
    } else {
        echo "<script>alert('Registration failed. Please try again.'); window.history.back();</script>";
    }

    $stmt->close();
}
$conn->close();
?>
