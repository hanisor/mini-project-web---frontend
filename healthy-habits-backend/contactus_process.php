<?php

include('../healthy-habits-backend/database/db_connection.php');

// Check if the database connection is successful
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
} else {
    echo "Connected successfully";
}

// Check if the request method is POST
if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtain values for each input in the form and assign them to variables
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    // Generate SQL statement for inserting into the Contact_Us table
    $sqlContact = "INSERT INTO contact_Us (id, name, phone, email, message) 
                    VALUES (0, '$name', '$phone', '$email', '$message')";

    // Execute SQL statement for registration
    $sqlResult = mysqli_query($con, $sqlContact);

    // Check if the insert statement is successfully executed
    if ($sqlResult === TRUE) {
        // Registration successful
        echo "<script>
                window.alert('Message sent successfully');
                window.location.href = '../html/index.html';
              </script>";
    } else {
        // Registration failed
        echo "<script>
                window.alert('Failed to send message');
              </script>";
    }
} else {
    // Handle the case when the script is accessed via an invalid request method
    echo "<script>
            window.alert('Invalid request method.');
            window.location.href = '../html/contactus.html';
          </script>";
}

?>
