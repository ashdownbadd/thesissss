<?php
// Database configuration
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "student_tracking";

// Create connection
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all student data with filters
$searchQuery = isset($_POST['searchQuery']) ? $_POST['searchQuery'] : '';
$section = isset($_POST['section']) ? $_POST['section'] : '';
$yearLevel = isset($_POST['yearLevel']) ? $_POST['yearLevel'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';  // Changed from 'program' to 'email'

// Prepare SQL statement based on filter
$sql = "SELECT student_id, CONCAT(first_name, ' ', middle_name, ' ', last_name) AS full_name, section, year_level, email 
        FROM student 
        WHERE program = 'Bachelor of Science in Office Administration'"; // Add this line to filter by program

// Apply search filter if the user is typing
if ($searchQuery) {
    $sql .= " AND (student_id LIKE ? OR first_name LIKE ? OR middle_name LIKE ? OR last_name LIKE ?)";
}

// Apply other filters for section, year level, and email
if ($section) {
    $sql .= " AND section LIKE ?";
}
if ($yearLevel) {
    $sql .= " AND year_level LIKE ?";
}
if ($email) {
    $sql .= " AND email LIKE ?";  // Filter by email
}

// Prepare the statement
$stmt = $conn->prepare($sql);

// Bind parameters based on filters
$params = [];
$types = '';

if ($searchQuery) {
    $searchTerm = "%$searchQuery%";
    $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
    $types .= 'ssss';
}
if ($section) {
    $params[] = "%$section%";
    $types .= 's';
}
if ($yearLevel) {
    $params[] = "%$yearLevel%";
    $types .= 's';
}
if ($email) {
    $params[] = "%$email%";  // Bind email parameter
    $types .= 's';
}

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

// Fetch the results and build the table rows
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['student_id']}</td>
                <td>{$row['full_name']}</td>
                <td>{$row['section']}</td>
                <td>{$row['year_level']}</td>
                <td>{$row['email']}</td>  <!-- Display email -->
              </tr>";
    }
} else {
    echo "<tr><td colspan='5' class='text-center'>No results found</td></tr>";
}

$stmt->close();
$conn->close();
?>
