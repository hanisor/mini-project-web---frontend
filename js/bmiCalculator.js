$(document).ready(function() {
    $('#health-assessment-form').submit(function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Get height and weight values
        var height = parseFloat($('#height').val());
        var weight = parseFloat($('#weight').val());

        // Calculate BMI
        var bmi = weight / (height * height);

        // Determine BMI status
        var bmiStatus = getBMIStatus(bmi);

        // Update BMI and BMI status fields
        $('#bmi').val(bmi.toFixed(2));
        $('#bmiStatus').val(bmiStatus);

        // Prepare the form data
        var formData = {
            UserId: 1, // Replace with actual user ID if available
            Height: height,
            Weight: weight
        };

        // Log form data for debugging
        console.log('Form Data:', formData);

        // Send AJAX request to the server
        $.ajax({
            type: 'PUT',
            url: $('#health-assessment-form').attr('action'),
            data: JSON.stringify(formData),
            contentType: 'application/json',
            success: function(response) {
                // Handle successful response here
                console.log('Success:', response);
            },
            error: function(xhr, status, error) {
                // Handle error response here
                console.error('Error:', xhr.responseText);
            }
        });
    });

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
