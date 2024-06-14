<?php

include('../healthy-habits-backend/database/db_connection.php');

// Set the response header to return JSON
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the JSON data from the request body
    $putData = file_get_contents('php://input');
    // Debugging: Log the raw input data
    error_log("Raw input data: " . $putData);
    
    // Decode the JSON data into an associative array
    $requestData = json_decode($putData, true);

    // Debugging: Log the decoded data
    error_log("Decoded data: " . print_r($requestData, true));

    // Check if the email and new password are provided in the request
    if (isset($requestData["email"]) && isset($requestData["password"])) {
        $email = $requestData["email"];
        $newPassword = $requestData["password"];

        // Debugging: Log the email and new password
        error_log("Email: $email, New Password: $newPassword");

        // Prepare the update query with parameterized statement to prevent SQL injection
        $updateQuery = "UPDATE user SET Password = ? WHERE Email = ?";
        $stmt = $con->prepare($updateQuery);

        if (!$stmt) {
            // Log statement preparation error
            error_log("Failed to prepare statement: " . $con->error);
            http_response_code(500); // Internal Server Error
            echo json_encode(["status" => "error", "message" => "Failed to prepare update statement"]);
            exit();
        }

        $stmt->bind_param("ss", $newPassword, $email);

        // Execute the update query
        if ($stmt->execute()) {
            // Debugging: Log successful update
            error_log("Password updated successfully for email: $email");

            // Return success message
            echo json_encode(["status" => "success", "message" => "Password updated successfully"]);
        } else {
            // Log statement execution error
            error_log("Failed to execute statement: " . $stmt->error);
            http_response_code(500); // Internal Server Error
            echo json_encode(["status" => "error", "message" => "Failed to update password"]);
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        // Return an error response if email or password is not provided
        error_log("Email or password not provided in the request");
        http_response_code(400); // Bad Request
        echo json_encode(["status" => "error", "message" => "Email and password are required"]);
    }
} else {
    // Return an error response if the request method is not POST
    http_response_code(405); // Method Not Allowed
    echo json_encode(["status" => "error", "message" => "Only POST requests are allowed for this endpoint"]);
}
?>
