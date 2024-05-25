document.addEventListener('DOMContentLoaded', function() {
    // Get form elements
    var form = document.getElementById('health-assessment-form');
    var heightInput = document.getElementById('height');
    var weightInput = document.getElementById('weight');
    var bmiInput = document.getElementById('bmi');
    var bmiStatusInput = document.getElementById('bmiStatus');

    // Add event listeners to height and weight input fields
    heightInput.addEventListener('input', updateBMI);
    weightInput.addEventListener('input', updateBMI);

    // Function to calculate and update BMI
    function updateBMI() {
        // Get height and weight values
        var height = parseFloat(heightInput.value);
        var weight = parseFloat(weightInput.value);

        // Calculate BMI
        var bmi = weight / (height * height);

        // Display BMI
        bmiInput.value = bmi.toFixed(2);

        // Determine BMI status
        var bmiStatus = getBMIStatus(bmi);
        bmiStatusInput.value = bmiStatus;
    }

    // Function to determine BMI status based on standard BMI categories
    function getBMIStatus(bmi) {
        if (bmi < 18.5) {
            return 'Underweight';
        } else if (bmi >= 18.5 && bmi < 25) {
            return 'Normal weight';
        } else if (bmi >= 25 && bmi < 30) {
            return 'Overweight';
        } else {
            return 'Obese';
        }
    }
});
