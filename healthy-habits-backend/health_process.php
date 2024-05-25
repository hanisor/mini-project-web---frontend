<?php
include('../healthy-habits-backend/database/db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $height = $_POST["height"];
    $weight = $_POST["weight"];

    // Calculate BMI
    $bmi = $weight / ($height * $height);

    // Determine BMI status
    if ($bmi < 18.5) {
        $bmiStatus = 'Underweight';
    } elseif ($bmi >= 18.5 && $bmi < 25) {
        $bmiStatus = 'Normal weight';
    } elseif ($bmi >= 25 && $bmi < 30) {
        $bmiStatus = 'Overweight';
    } else {
        $bmiStatus = 'Obese';
    }

    // Insert health data into database
    $sqlInsert = "INSERT INTO Health_Data (height, weight, bmi, bmi_status) 
                  VALUES ('$height', '$weight', '$bmi', '$bmiStatus')";

    $result = mysqli_query($con, $sqlInsert);

    if ($result) {
        // Display BMI and BMI status to the user
        echo "<script>
                window.alert('Health data inserted successfully.');
                window.location.href = '../html/index.html';
              </script>";
    } else {
        echo "<script>
                window.alert('Failed to insert health data.');
                window.location.href = 'PersonalizedHealthAssessment.html';
              </script>";
    }
}
?>
