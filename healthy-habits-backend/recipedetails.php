<?php

session_start();
header('Content-Type: application/json');

include('../healthy-habits-backend/database/db_connection.php');

$response = ["success" => false, "message" => "An error occurred."];

if (isset($_GET['id'])) {
    $recipeId = intval($_GET['id']);
    $sql = "SELECT RecipeId, Name, Ingredient, Description, Category FROM recipe WHERE RecipeId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $recipeId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $response = ["success" => true] + $result->fetch_assoc();
    } else {
        $response["message"] = "Recipe not found.";
    }

    $stmt->close();
}

$conn->close();
echo json_encode($response);
?>