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

        // Serialize the form data
        var formData = $(this).serialize();

        // Send AJAX request to the server
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: formData,
            success: function(response) {
                // Handle successful response here
                console.log(response);
            },
            error: function(xhr, status, error) {
                // Handle error response here
                console.error(xhr.responseText);
            }
        });
    });

});