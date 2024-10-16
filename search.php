<?php
// Database connection
$host = "localhost"; // Your database host (e.g., localhost)
$user = "root"; // Your database username
$password = ""; // Your database password
$dbname = "student_tracking"; // Your database name

$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the search term is set
if (isset($_GET['query'])) {
    $search = $conn->real_escape_string($_GET['query']);

    // Query to search the student table
    $sql = "SELECT * FROM student WHERE 
            student_id LIKE '%$search%'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data as JSON
        $students = array();
        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
        echo json_encode($students);
    } else {
        echo json_encode([]);
    }
}

$conn->close();
?>
