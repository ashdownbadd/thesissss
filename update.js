// update.js

document.addEventListener('DOMContentLoaded', () => {
    const updateProfileForm = document.getElementById('updateProfileForm');
    const profilePictureInput = document.getElementById('profilePicture');
    const previewImg = document.getElementById('previewImg');

    // Image Preview Functionality
    profilePictureInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                previewImg.setAttribute('src', e.target.result);
                previewImg.style.display = 'block';
            }

            reader.readAsDataURL(file);
        } else {
            previewImg.setAttribute('src', '#');
            previewImg.style.display = 'none';
        }
    });

    // Handle Form Submission
    updateProfileForm.addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent the default form submission

        const formData = new FormData(this);

        // Optional: Validate the form data here

        // Send the form data to your server using Fetch API
        fetch('https://your-server.com/api/update-profile', { // Replace with your server endpoint
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Handle success response
            alert('Profile updated successfully!');
            // Optionally, redirect the user or update the UI
        })
        .catch(error => {
            // Handle errors
            console.error('Error:', error);
            alert('An error occurred while updating the profile.');
        });
    });
});
