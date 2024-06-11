<?php

include('../healthy-habits-backend/database/db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Determine if it's a registration or update
    if (isset($_POST["UserId"]) && !empty($_POST["UserId"])) {
        // Update logic
        $UserId = $_POST["UserId"];
        $Name = $_POST["Name"];
        $Username = $_POST["Username"];
        $Gender = $_POST["Gender"];
        $Date_Of_Birth = $_POST["Date_Of_Birth"];
        $Email = $_POST["Email"];
        $Height = $_POST["Height"];
        $Weight = $_POST["Weight"];
        $BMI = $_POST["BMI"];

        $sqlUpdate = "UPDATE user SET 
                      Name = '$Name',
                      Username = '$Username',
                      Gender = '$Gender',
                      Date_Of_Birth = '$Date_Of_Birth',
                      Email = '$Email',
                      Height = '$Height',
                      Weight = '$Weight',
                      BMI = '$BMI'
                      WHERE UserId = '$UserId'";

        $sqlResult = mysqli_query($con, $sqlUpdate);

        if ($sqlResult === TRUE) {
            echo json_encode(['status' => 'success', 'message' => 'Update successful']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Update failed']);
        }
    } else {
        // Registration logic
        $Name = $_POST["Name"];
        $Username = $_POST["Username"];
        $Gender = $_POST["Gender"];
        $Date_Of_Birth = $_POST["Date_Of_Birth"];
        $Email = $_POST["Email"];
        $Password = $_POST["Password"];

        // Check if the provided email already exists in the database
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

        // Generate SQL statement for registration
        $sqlRegister = "INSERT INTO user (UserId, Name, Username, Gender, Date_Of_Birth, Email, Password, Status, Height, Weight, BMI) 
                        VALUES (0, '$Name', '$Username', '$Gender', '$Date_Of_Birth', '$Email', '$Password', 'Active', NULL, NULL, NULL)";

        // Execute SQL statement for registration
        $sqlResult = mysqli_query($con, $sqlRegister);

        // Check if the insert statement is successfully executed
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
} else if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Get all user data
    $sqlGetUsers = "SELECT * FROM user";
    $result = mysqli_query($con, $sqlGetUsers);

    if (mysqli_num_rows($result) > 0) {
        $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
        header('Content-Type: application/json');
        echo json_encode($users);
    } else {
        echo json_encode([]);
    }
}

?>
