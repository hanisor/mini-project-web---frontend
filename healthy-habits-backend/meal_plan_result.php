<?php
session_start();
header('Content-Type: application/json');

$response = ["success" => false, "message" => "An error occurred."];

if (isset($_SESSION['mealPlanData'])) {
    $response = array_merge(["success" => true], $_SESSION['mealPlanData']);
} else {
    $response["message"] = "No meal plan data found.";
}

echo json_encode($response);
?>
