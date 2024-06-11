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

    // Create a PUT request to update the password
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/../healthy-habits-backend/forgot_password.php');
    xhr.setRequestHeader('Content-Type', 'application/json');

    // Define the data to be sent in JSON format
    var data = {
        email: email,
        password: newPassword
    };

    // Convert the data to a JSON string
    var jsonData = JSON.stringify(data);

    // Send the request
    xhr.send(jsonData);

    // Handle the response
    xhr.onload = function() {
        if (xhr.status === 200) {
            alert('Password updated successfully!');
            // Optionally, redirect the user to another page
            window.location.href = '/../html/index.html';
        } else {
            alert('Failed to update password. Please try again.');
        }
    };
});
