<?php
include ('../healthy-habits-backend/database/db_connection.php');

if ($_SERVER["REQUEST_METHOD"] === "PUT") {
    // Check if the email and new password are provided in the request
    if (isset($_GET["email"]) && isset($_GET["password"])) {
        $email = $_GET["email"];
        $newPassword = $_GET["password"];

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

        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $stmt->bind_param("ss", $hashedPassword, $email);

        // Execute the update query
        if ($stmt->execute()) {
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
        http_response_code(400); // Bad Request
        echo json_encode(["status" => "error", "message" => "Email and password are required"]);
    }
} else {
    // Return an error response if the request method is not PUT
    http_response_code(405); // Method Not Allowed
    echo json_encode(["status" => "error", "message" => "Only PUT requests are allowed for this endpoint"]);
}

?>
