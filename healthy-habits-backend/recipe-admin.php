<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Credentials: true");

include('../healthy-habits-backend/database/db_connection.php');

// Handle POST requests
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $jsonbody = json_decode(file_get_contents('php://input'));

        // Check if all required parameters are present and not empty
        $requiredFields = ['Name', 'Ingredient', 'Description', 'Category'];
        foreach ($requiredFields as $field) {
            if (!isset($jsonbody->$field) || empty($jsonbody->$field)) {
                http_response_code(400);
                $response = array('error' => ucfirst($field) . ' cannot be empty');
                echo json_encode($response);
                exit();
            }
        }

        // Retrieve AdminId based on the logged admin's email from the session
        session_start();
        if (isset($_SESSION["loggedAdminEmail"])) {
            $loggedAdminEmail = $_SESSION["loggedAdminEmail"];
            $sqlAdminId = "SELECT AdminId FROM admin WHERE Email = '$loggedAdminEmail'";
            $resultAdminId = mysqli_query($con, $sqlAdminId);
            if (mysqli_num_rows($resultAdminId) > 0) {
                $rowAdminId = mysqli_fetch_assoc($resultAdminId);
                $adminId = $rowAdminId['AdminId'];

                // Prepare and execute the SQL query to insert the exercise
                $stmt = $con->prepare("INSERT INTO recipe (`Name`, `Ingredient`,`Description`, `Category`, `AdminId`) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssi", $jsonbody->Name, $jsonbody->Ingredient, $jsonbody->Description, $jsonbody->Category, $adminId);
                $stmt->execute();

                // Return success response
                http_response_code(200);
                $response = array('success' => true, 'message' => 'Recipe successfully added');
                echo json_encode($response);
            } else {
                http_response_code(400);
                $response = array('error' => 'Admin not found');
                echo json_encode($response);
            }
        } else {
            http_response_code(400);
            $response = array('error' => 'Admin email not set in session');
            echo json_encode($response);
        }
    } catch (Exception $ee) {
        // Return error response if any exception occurs
        http_response_code(500);
        $response = array('error' => 'Error occurred: ' . $ee->getMessage());
        echo json_encode($response);
    }
}



// Handle PUT requests
else if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    try {
        // Extract ExerciseId from the URL
        $url_parts = explode('/', $_SERVER['REQUEST_URI']);
        $ExerciseId = end($url_parts);

        // Read the input stream to get the raw data sent with the PUT request
        $putData = file_get_contents('php://input');
        // Decode the raw data into an associative array
        $requestData = json_decode($putData, true);

        // Initialize an empty array to store SET clauses for the update query
        $setClauses = array();

        // Retrieve AdminId based on the logged admin's email from the session
        session_start();
        if (isset($_SESSION["loggedAdminEmail"])) {
            $loggedAdminEmail = $_SESSION["loggedAdminEmail"];
            $sqlAdminId = "SELECT AdminId FROM admin WHERE Email = '$loggedAdminEmail'";
            $resultAdminId = mysqli_query($con, $sqlAdminId);
            if (mysqli_num_rows($resultAdminId) > 0) {
                $rowAdminId = mysqli_fetch_assoc($resultAdminId);
                $adminId = $rowAdminId['AdminId'];

                // Check and add optional fields to update
                if (isset($requestData["Name"])) {
                    $setClauses[] = "Name = '" . $requestData["Name"] . "'";
                }
                if (isset($requestData["Ingredient"])) {
                    $setClauses[] = "Ingredient = '" . $requestData["Ingredient"] . "'";
                }
                if (isset($requestData["Description"])) {
                    $setClauses[] = "Description = '" . $requestData["Description"] . "'";
                }
          
                // Ensure AdminId is not updated
                $setClauses[] = "AdminId = " . $adminId;

                // Check if any fields are provided for update
                if ($ExerciseId && !empty($setClauses)) {
                    // Construct the UPDATE query dynamically
                    $updateQuery = "UPDATE exercise SET " . implode(", ", $setClauses) . " WHERE ExerciseId = ?";

                    // Prepare and execute the SQL query to update the exercise
                    $stmt = $con->prepare($updateQuery);
                    $stmt->bind_param("i", $ExerciseId);
                    $stmt->execute();

                    if ($stmt->affected_rows > 0) {
                        // Return a success response
                        http_response_code(200);
                        echo json_encode(["status" => "success", "message" => "Exercise data updated successfully"]);
                    } else {
                        // Return an error response if the update operation fails
                        http_response_code(400);
                        echo json_encode(["status" => "error", "message" => "Failed to update Exercise data or no changes made"]);
                    }
                } else {
                    // Return an error response if Exercise ID is not provided or no fields to update
                    http_response_code(400);
                    echo json_encode(["status" => "error", "message" => "Exercise ID is required and at least one field to update"]);
                }
            } else {
                http_response_code(400);
                $response = array('error' => 'Admin not found');
                echo json_encode($response);
            }
        } else {
            http_response_code(400);
            $response = array('error' => 'Admin email not set in session');
            echo json_encode($response);
        }
    } catch (Exception $ee) {
        // Return error response if any exception occurs
        http_response_code(500);
        $response = array('error' => 'Error occurred: ' . $ee->getMessage());
        echo json_encode($response);
    }
}
// Handle GET requests
else if ($_SERVER["REQUEST_METHOD"] == "GET") {
    try {
        $sql = "SELECT * FROM recipe";
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            $recipes = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $recipes[] = $row;
            }
            http_response_code(200);
            echo json_encode($recipes);
        } else {
            http_response_code(404);
            echo json_encode(array('message' => 'No recipes found'));
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(array('error' => 'Error occurred: ' . $e->getMessage()));
    }
}


// Handle other request methods
else {
    // Return an error response if the request method is not allowed
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Only POST and PUT requests are allowed for this endpoint"]);
}

?>