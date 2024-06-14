document.getElementById('resetPasswordForm').addEventListener('submit', function(event) {
    event.preventDefault();

    // Get the email, new password, and confirm password from the form
    var email = document.getElementById('email').value;
    var newPassword = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirmPassword').value;

    // Check if the new password and confirm password match
    if (newPassword !== confirmPassword) {
        alert("Passwords do not match.");
        return;
    }

    // Create a POST request to update the password
    var xhr = new XMLHttpRequest();
    var url = 'http://localhost/xampp/mini-project-web---frontend/healthy-habits-backend/forgot_password.php';
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/json');

    // Prepare the data to be sent
    var data = JSON.stringify({
        email: email,
        password: newPassword
    });

    // Debugging: Log the data being sent
    console.log("Sending data:", data);

    // Send the request
    xhr.send(data);

    // Handle the response
    xhr.onload = function() {
        console.log("Response status:", xhr.status);
        console.log("Response text:", xhr.responseText);

        if (xhr.status === 200) {
            try {
                var response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                    alert('Password updated successfully!');
                    // Optionally, redirect the user to another page
                    window.location.href = '../html/index.html';
                } else {
                    alert('Failed to update password. ' + response.message);
                }
            } catch (e) {
                console.error("Parsing error:", e);
                alert('Failed to update password. Please try again.');
            }
        } else {
            alert('Failed to update password. Please try again.');
        }
    };

    xhr.onerror = function() {
        console.error("Request error:", xhr.statusText);
        alert('An error occurred during the request.');
    };
});
