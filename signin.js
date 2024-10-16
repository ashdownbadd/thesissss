// Function to handle key press in input fields
document.getElementById('username').addEventListener('keypress', function (event) {
    if (event.key === 'Enter') {
        authenticate(); // Call the authenticate function
    }
});

document.getElementById('password').addEventListener('keypress', function (event) {
    if (event.key === 'Enter') {
        authenticate(); // Call the authenticate function
    }
});

// Existing authenticate function
function authenticate() {
    const username = document.getElementById('username').value.trim();
    const password = document.getElementById('password').value.trim();

    // Define Admin credentials
    const adminCredentials = {
        username: "admin",
        password: "admin" // It's better to use a stronger password
    };

    // Define Student credentials (for demonstration, one student)
    const studentCredentials = {
        username: "student",
        password: "student" // You can add more students as needed
    };

    // Check Admin credentials
    if (username === adminCredentials.username && password === adminCredentials.password) {
        // Redirect to index.html for Admin
        window.location.href = "home.html";
        return;
    }

    // Check Student credentials
    if (username === studentCredentials.username && password === studentCredentials.password) {
        // Redirect to profile.html for Students
        window.location.href = "profile.html";
        return;
    }

    // If credentials don't match any user
    alert("Invalid username or password. Please try again.");
}
