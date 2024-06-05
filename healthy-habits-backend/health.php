<?php

session_start(); 

include ('../healthy-habits-backend/database/db_connection.php');

if ($_SERVER["REQUEST_METHOD"] === "PUT") {
    // Check if the user email is set in the session
    if (isset($_SESSION["loggedUserEmail"])) {
        $email = $_SESSION["loggedUserEmail"];

        // Fetch user ID using the email from the session
        $selectQuery = "SELECT UserId FROM user WHERE Email = ?";
        $stmt = $con->prepare($selectQuery);

        if (!$stmt) {
            // Log statement preparation error
            error_log("Failed to prepare statement: " . $con->error);
            http_response_code(500); // Internal Server Error
            echo json_encode(["status" => "error", "message" => "Failed to prepare select statement"]);
            exit();
        }

        $stmt->bind_param("s", $email);
        
        // Execute the select query
        if ($stmt->execute()) {
            $stmt->bind_result($userId);
            $stmt->fetch();
            $stmt->close();

            if ($userId !== null) {
                // Read the input stream to get the raw data sent with the PUT request
                $putData = file_get_contents('php://input');
                // Decode the raw data into an associative array
                $requestData = json_decode($putData, true);

                // Extract data from the request body
                $height = isset($requestData["Height"]) ? floatval($requestData["Height"]) : null;
                $weight = isset($requestData["Weight"]) ? floatval($requestData["Weight"]) : null;

                if ($height !== null && $weight !== null) {
                    // Calculate BMI
                    $bmi = $weight / ($height * $height);

                    // Determine BMI status
                    $bmiStatus = getBMIStatus($bmi);

                    // Prepare the update query with parameterized statement to prevent SQL injection
                    $updateQuery = "UPDATE user SET Height = ?, Weight = ?, BMI = ? WHERE UserId = ?";
                    $stmt = $con->prepare($updateQuery);

                    if (!$stmt) {
                        // Log statement preparation error
                        error_log("Failed to prepare statement: " . $con->error);
                        http_response_code(500); // Internal Server Error
                        echo json_encode(["status" => "error", "message" => "Failed to prepare update statement"]);
                        exit();
                    }

                    $stmt->bind_param("dddi", $height, $weight, $bmi, $userId);

                    // Execute the update query
                    if ($stmt->execute()) {
                        // Return BMI and BMI status as JSON response
                        echo json_encode(["bmi" => $bmi, "bmiStatus" => $bmiStatus]);
                    } else {
                        // Log statement execution error
                        error_log("Failed to execute statement: " . $stmt->error);
                        http_response_code(500); // Internal Server Error
                        echo json_encode(["status" => "error", "message" => "Failed to update user data"]);
                    }

                    // Close the prepared statement
                    $stmt->close();
                } else {
                    // Return an error response if height or weight is not provided
                    http_response_code(400); // Bad Request
                    echo json_encode(["status" => "error", "message" => "Height and weight are required"]);
                }
            } else {
                // Return an error response if userId is not found
                http_response_code(404); // Not Found
                echo json_encode(["status" => "error", "message" => "User not found"]);
            }
        } else {
            // Log statement execution error
            error_log("Failed to execute statement: " . $stmt->error);
            http_response_code(500); // Internal Server Error
            echo json_encode(["status" => "error", "message" => "Failed to fetch user data"]);
        }
    } else {
        // Return an error response if the user email is not set in the session
        http_response_code(401); // Unauthorized
        echo json_encode(["status" => "error", "message" => "User not logged in"]);
    }
} else {
    // Return an error response if the request method is not PUT
    http_response_code(405); // Method Not Allowed
    echo json_encode(["status" => "error", "message" => "Only PUT requests are allowed for this endpoint"]);
}

function getBMIStatus($bmi) {
    if ($bmi < 18.5) {
        return 'Underweight';
    } else if ($bmi >= 18.5 && $bmi < 25) {
        return 'Normal weight';
    } else if ($bmi >= 25 && $bmi < 30) {
        return 'Overweight';
    } else {
        return 'Obese';
    }
}
?>
