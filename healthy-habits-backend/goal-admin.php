<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Credentials: true");

include('../healthy-habits-backend/database/db_connection.php');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start output buffering to prevent any accidental output before JSON response
ob_start();

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $jsonbody = json_decode(file_get_contents('php://input'));

        // Check if all required parameters are present and not empty
        $requiredFields = ['Name'];
        foreach ($requiredFields as $field) {
            if (!isset($jsonbody->$field) || empty($jsonbody->$field)) {
                http_response_code(400);
                $response = array('error' => ucfirst($field) . ' cannot be empty');
                echo json_encode($response);
                exit();
            }
        }

        // Prepare and execute the SQL query to insert the goal
        $stmt = $con->prepare("INSERT INTO goal (`Name`) VALUES (?)");
        $stmt->bind_param("s", $jsonbody->Name);
        $stmt->execute();

        // Return success response
        http_response_code(200);
        $response = array('success' => true, 'message' => 'Goal successfully added');
        echo json_encode($response);
    } else if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $sql = "SELECT GoalId, Name FROM goal";
        $result = $con->query($sql);

        $goals = array();
        while ($row = $result->fetch_assoc()) {
            $goals[] = $row;
        }

        // Return success response
        http_response_code(200);
        echo json_encode($goals);
    } else {
        http_response_code(405);
        echo json_encode(["status" => "error", "message" => "Only GET and POST requests are allowed for this endpoint"]);
    }
} catch (Exception $ee) {
    // Return error response if any exception occurs
    http_response_code(500);
    $response = array('error' => 'Error occurred: ' . $ee->getMessage());
    echo json_encode($response);
}

// End output buffering and flush all output
ob_end_flush();

?>
