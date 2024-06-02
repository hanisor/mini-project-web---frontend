<?php
session_start();
header('Content-Type: application/json');

include('../healthy-habits-backend/database/db_connection.php');

$response = ["success" => false, "message" => "An error occurred."];

try {
    if (!isset($_SESSION["loggedUserEmail"])) {
        throw new Exception("User not logged in.");
    }

    $loggedUserEmail = $_SESSION["loggedUserEmail"];

    // Fetch user details including BMI from the database based on the email
    $sqlFetchUserDetails = "SELECT * FROM user WHERE Email = ?";
    $stmt = $con->prepare($sqlFetchUserDetails);
    if (!$stmt) {
        throw new Exception("Prepare statement failed: " . $con->error);
    }
    $stmt->bind_param("s", $loggedUserEmail);
    $stmt->execute();
    $result = $stmt->get_result();
    $userDetails = $result->fetch_assoc();

    if ($userDetails) {
        $weight = $userDetails['Weight'];
        $height = $userDetails['Height'];
        $bmi = calculateBMI($weight, $height);

        $mealPlan = '';
        if ($bmi < 18.5) {
            $mealPlan = "High-calorie diet with balanced nutrients.";
        } else if ($bmi >= 18.5 && $bmi < 24.9) {
            $mealPlan = "Maintenance diet with balanced nutrients.";
        } else {
            $mealPlan = "Low-calorie diet with balanced nutrients.";
        }

        // Fetch recipes based on the meal plan description
        $sqlFetchRecipes = "SELECT * FROM recipe WHERE Description = ?";
        $stmtRecipes = $con->prepare($sqlFetchRecipes);
        if (!$stmtRecipes) {
            throw new Exception("Prepare statement failed: " . $con->error);
        }
        $stmtRecipes->bind_param("s", $mealPlan);
        $stmtRecipes->execute();
        $resultRecipes = $stmtRecipes->get_result();
        $recipes = [];
        while ($row = $resultRecipes->fetch_assoc()) {
            $recipes[] = $row;
        }

        $response = [
            "success" => true,
            "bmi" => $bmi,
            "mealPlan" => $mealPlan,
            "recipes" => $recipes
        ];
    } else {
        throw new Exception("User details not found.");
    }

    $stmt->close();
    $stmtRecipes->close();
} catch (Exception $e) {
    $response["message"] = $e->getMessage();
}

$con->close();
echo json_encode($response);

function calculateBMI($weight, $height)
{
    // Calculate BMI
    $bmi = $weight / (($height / 100) ** 2);

    // Round BMI to two decimal places
    $bmi = number_format((float)$bmi, 2, '.', '');

    return $bmi;
}
?>
