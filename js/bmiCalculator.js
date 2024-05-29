document.addEventListener('DOMContentLoaded', function() {
    // Get form element
    var form = document.getElementById('health-assessment-form');

    // Add event listener to form submission
    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        // Serialize form data
        var formData = new FormData(form);

        // Send PUT request using fetch API
        fetch('health.php', {
            method: 'PUT',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Update BMI and BMI status fields with the received data
            document.getElementById('bmi').value = data.bmi;
            document.getElementById('bmiStatus').value = data.bmiStatus;
        })
        .catch(error => {
            console.error('Error:', error); // Log any errors
        });
    });
});
