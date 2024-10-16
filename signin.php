<?php
session_start();

$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "student_tracking";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT student_id, password, role, last_name, first_name, middle_name, extension, mobile_no, email, year_level, section, program FROM student WHERE username = ?");
    $stmt->bind_param("s", $username);
    
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($student_id, $db_password, $role, $last_name, $first_name, $middle_name, $extension, $mobile_no, $email, $year_level, $section, $program);
        $stmt->fetch();
        
        if (password_needs_rehash($db_password, PASSWORD_DEFAULT)) {
            if ($password === $db_password) {
                $_SESSION['student_id'] = $student_id;

                $_SESSION['username'] = $username;
                $_SESSION['last_name'] = $last_name;
                $_SESSION['first_name'] = $first_name;
                $_SESSION['middle_name'] = $middle_name;
                $_SESSION['extension'] = $extension;
                $_SESSION['mobile_no'] = $mobile_no;
                $_SESSION['email'] = $email;
                $_SESSION['year_level'] = $year_level;
                $_SESSION['section'] = $section;
                $_SESSION['program'] = $program; 
                $_SESSION['role'] = $role;
                
                if ($role === 'admin') {
                    header("Location: home.html");
                } else {
                    header("Location: profile.php");
                }
                exit();
            } else {
                echo "<script>alert('Invalid username or password. Please try again.'); window.location.href='signin.html';</script>";
            }
        } else {
            if (password_verify($password, $db_password)) {
                            $_SESSION['student_id'] = $student_id;

                $_SESSION['username'] = $username;
                $_SESSION['last_name'] = $last_name;
                $_SESSION['first_name'] = $first_name;
                $_SESSION['middle_name'] = $middle_name;
                $_SESSION['extension'] = $extension;
                $_SESSION['mobile_no'] = $mobile_no;
                $_SESSION['email'] = $email;
                $_SESSION['year_level'] = $year_level;
                $_SESSION['section'] = $section;
                $_SESSION['program'] = $program; 
                $_SESSION['role'] = $role;
                
                if ($role === 'admin') {
                    header("Location: home.html");
                } else {
                    header("Location: profile.php");
                }
                exit();
            } else {
                echo "<script>alert('Invalid username or password. Please try again.'); window.location.href='signin.html';</script>";
            }
        }
    } else {
        echo "<script>alert('Invalid username or password. Please try again.'); window.location.href='signin.html';</script>";
    }
    
    $stmt->close();
    $conn->close();
} else {
    header("Location: signin.html");
    exit();
}
