// profile.js

document.addEventListener('DOMContentLoaded', () => {
    // ======= Social Card Toggle =======
    const toggleButton = document.getElementById('card-toggle');
    const socialCard = document.getElementById('card-social');

    // Track the state of the card (open/closed)
    let isOpen = false;

    toggleButton.addEventListener('click', () => {
        if (!isOpen) {
            // Trigger the show animation (up)
            socialCard.classList.add('animation');
            socialCard.classList.remove('down-animation'); // Remove any down-animation if it exists
            isOpen = true; // Set the state to open
        } else {
            // Trigger the hide animation (down)
            socialCard.classList.remove('animation'); // Remove the up animation class
            socialCard.classList.add('down-animation'); // Add the down animation
            isOpen = false; // Set the state to closed
        }
    });

    // After the animation ends, reset classes to prevent any issues
    socialCard.addEventListener('animationend', (event) => {
        if (event.animationName === 'down-animation') {
            socialCard.classList.remove('down-animation'); // Clean up after down-animation
        } else if (event.animationName === 'up-animation') {
            // Optional cleanup for the up-animation if needed
        }
    });

    // ======= Logout Modal Functionality =======
    const logoutModal = document.getElementById("logoutModal");
    const powerOffIcon = document.querySelector(".card__social-link:last-child"); // The power-off icon
    const modalClose = document.getElementById("modalClose");
    const confirmLogout = document.getElementById("confirmLogout");
    const cancelLogout = document.getElementById("cancelLogout");

    // Show the modal when power-off icon is clicked
    powerOffIcon.addEventListener("click", (event) => {
        event.preventDefault(); // Prevent default link behavior
        logoutModal.style.display = "block";
    });

    // Close the modal when the 'x' button is clicked
    modalClose.addEventListener("click", () => {
        logoutModal.style.display = "none";
    });

    // Close the modal when the cancel button is clicked
    cancelLogout.addEventListener("click", () => {
        logoutModal.style.display = "none";
    });

    // Logout and redirect when confirm button is clicked
    confirmLogout.addEventListener("click", () => {
        window.location.href = "logout.php"; // Redirect to logout.php
    });

    // Close the modal if the user clicks outside of the modal
    window.addEventListener("click", (event) => {
        if (event.target === logoutModal) {
            logoutModal.style.display = "none";
        }
    });
});
