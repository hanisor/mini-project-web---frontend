document.addEventListener('DOMContentLoaded', () => {
    const logoutButton = document.getElementById('logoutButton');

    // Logout function
    logoutButton.addEventListener('click', () => {
        fetch('../healthy-habits-backend/logout.php', { // Updated path to logout.php
            method: 'GET',
            credentials: 'same-origin'
        })
        .then(response => {
            if (response.ok) {
                window.location.href = '../html/index.html'; // Redirect to login page
            } else {
                console.error('Logout failed.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});
