<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: signin.html");
    exit();
}

$username = $_SESSION['username'];
$last_name = $_SESSION['last_name'];
$first_name = $_SESSION['first_name'];
$middle_name = $_SESSION['middle_name'];
$extension = $_SESSION['extension'];
$mobile_no = $_SESSION['mobile_no'];
$email = $_SESSION['email'];
$year_level = $_SESSION['year_level'];
$section = $_SESSION['section'];
$program = $_SESSION['program'];
$student_id = $_SESSION['student_id'];

date_default_timezone_set('Asia/Manila');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>

    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="profile.css">
</head>
<body>


    <div class="container">
        <div class="card">
            <div class="card__border">
                <img src="icon.jpg" alt="card image" class="card__img">
            </div>

<h3 class="card__name">
    <?php 

        echo htmlspecialchars($_SESSION['first_name']) . ' ' . 
             htmlspecialchars($_SESSION['middle_name']) . ' ' . 
             htmlspecialchars($last_name); 
    ?>
</h3>
            <span class="card__profession"><?php echo htmlspecialchars($program); ?></span>

            <div class="card__social" id="card-social">
                <div class="card__social-control">
                    <div class="card__social-toggle" id="card-toggle">
                        <i class="ri-add-line"></i>
                    </div>

                    <span class="card__social-text">See More</span>

                    <ul class="card__social-list">
                    <a href="updateform.html?last_name=<?php echo urlencode($last_name); ?>&first_name=<?php echo urlencode($first_name); ?>&middle_name=<?php echo urlencode($middle_name); ?>&extension=<?php echo urlencode($extension); ?>&mobile_no=<?php echo urlencode($mobile_no); ?>&email=<?php echo urlencode($email); ?>&year_level=<?php echo urlencode($year_level); ?>&section=<?php echo urlencode($section); ?>&program=<?php echo urlencode($program); ?>&role=<?php echo urlencode($role); ?> ?>&student_id=<?php echo urlencode($student_id); ?>" class="card__social-link pen-icon">
    <div class="circle">
        <i class="fa fa-pen"></i>
    </div>
</a>



</a>

<a href="#" class="card__social-link" id="emergencyButton">
    <i class="fas fa-medkit"></i>
</a>


                        <a href="logout.php" class="card__social-link">
                            <i class="fas fa-power-off"></i>
                        </a>
                    </ul>
                </div>
            </div>
        </div>
    </div>


<div id="logoutModal" class="modal">
    <div class="modal-content">
        <span class="close" id="modalClose">&times;</span>
        <h2>Sign Out</h2>
        <p>Are you sure you want to log out?</p>
        <button id="confirmLogout">Yes</button>
        <button id="cancelLogout">Cancel</button>
    </div>
</div>



    <?php
    $current_hour = date("H");

    if ($current_hour < 12) {
        $greeting = "Good Morning";
    } elseif ($current_hour < 18) {
        $greeting = "Good Afternoon";
    } else {
        $greeting = "Good Evening";
    }

    $last_name = isset($_SESSION['last_name']) ? $_SESSION['last_name'] : 'Student';

echo "<h1><span class='greeting'>$greeting, </span><span class='name'>" . strtoupper(htmlspecialchars($first_name)) . "</span></h1>";

   ?>

    <div class="location-status">
    <?php
    $location_allowed = isset($_SESSION['location_allowed']) ? $_SESSION['location_allowed'] : 0;
    if ($location_allowed) {
        echo '<div class="status-circle located" data-message="Your location is being tracked."></div>';
    } else {
        echo '<div class="status-circle not-located" data-message="Your location is not being tracked."></div>';
    }
    ?>
</div>



    <script src="profile.js"></script>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        let locationAllowed = false;
        let watchId = null;

        function sendLocationToServer(lat, lon, allowed) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "update_location.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log("Location status updated:", xhr.responseText);
                }
            };
            xhr.send(`latitude=${lat}&longitude=${lon}&allowed=${allowed}`);
        }

        function requestLocationPermission() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        locationAllowed = true;
                        const latitude = position.coords.latitude;
                        const longitude = position.coords.longitude;
                        sendLocationToServer(latitude, longitude, true);
                        // Optionally start watching position
                        watchId = navigator.geolocation.watchPosition(updatePosition, handleError, {
                            enableHighAccuracy: true,
                            maximumAge: 30000,
                            timeout: 27000
                        });
                    },
                    (error) => {
                        if (error.code === error.PERMISSION_DENIED) {
                            sendLocationToServer(null, null, false);
                        } else {
                            console.error("Geolocation error:", error);
                        }
                    }
                );
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        function updatePosition(position) {
            if (locationAllowed) {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;
                sendLocationToServer(latitude, longitude, true);
            }
        }

        function handleError(error) {
            console.error("Geolocation error:", error);
        }

        requestLocationPermission();

        window.addEventListener('beforeunload', () => {
            if (watchId !== null) {
                navigator.geolocation.clearWatch(watchId);
            }
        });
    });

    document.getElementById('emergencyButton').addEventListener('click', function() {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "send_alert.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    const data = `username=${encodeURIComponent('<?php echo $username; ?>')}&last_name=${encodeURIComponent('<?php echo $last_name; ?>')}`;

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            alert("Emergency alert sent!");
        }
    };

    xhr.send(data);
});

</script>

</body>
</html>
