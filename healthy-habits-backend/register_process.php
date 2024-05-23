<?php

include('../healthy-habits-backend/database/db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Step 1: Obtain values for each input in the form and assign them to variables
    $Name = $_POST["Name"];
    $Username = $_POST["Username"];
    $Gender = $_POST["Gender"];
    $Date_Of_Birth = $_POST["Date_Of_Birth"];
    $Email = $_POST["Email"];
    $Password = $_POST["Password"];

    // Step 2: Check if the provided email already exists in the database
    $sqlCheckEmail = "SELECT * FROM user WHERE Email = '$Email'";
    $result = mysqli_query($con, $sqlCheckEmail);

    if (mysqli_num_rows($result) > 0) {
        // Email already exists, display error message and prevent registration
        echo "<script>
                window.alert('Email already exists. Please use a different email.');
                window.location.href = '../html/register.html';
              </script>";
        exit; // Stop further execution
    }

    // Step 3: Generate SQL statement for registration
    $sqlRegister = "INSERT INTO user (UserId, Name, Username, Gender, Date_Of_Birth, Email, Password, Status, Height, Weight, BMI) 
                    VALUES (0, '$Name', '$Username', '$Gender', '$Date_Of_Birth', '$Email', '$Password', 'Active', NULL, NULL, NULL)";

    // Step 4: Execute SQL statement for registration
    $sqlResult = mysqli_query($con, $sqlRegister);

    // Step 5: Check if the insert statement is successfully executed
    if ($sqlResult === TRUE) {
        // Registration successful
        echo "<script>
                window.alert('Registration successful');
                window.location.href = '../html/index.html';
              </script>";
    } else {
        // Registration failed
        echo "<script>
                window.alert('Registration failed');
              </script>";
    }
}
?>
