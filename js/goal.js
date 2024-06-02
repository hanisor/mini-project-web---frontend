$(document).ready(function() {
    // Function to fetch goals and populate the dropdown menu
    function fetchGoals() {
        $.ajax({
            url: '../healthy-habits-backend/goal-admin.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var dropdown = $('#GoalId');
                dropdown.empty();
                dropdown.append('<option value="-">Select Goal</option>');
                $.each(response, function(index, item) {
                    dropdown.append($('<option></option>').attr('value', item.GoalId).text(item.Name));
                });
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    // Function to fetch exercises based on the selected goal
    function fetchExercises(goalId) {
        $.ajax({
            url: '../healthy-habits-backend/exercise.php?GoalId=' + goalId,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var exerciseList = $('#exerciseList');
                exerciseList.empty();
                if (response.error) {
                    exerciseList.append('<p>' + response.error + '</p>');
                } else {
                    $.each(response, function(index, item) {
                        var exerciseItem = $('<div class="exercise"></div>');
                        exerciseItem.append('<h3>' + item.Name + '</h3>');
                        exerciseItem.append('<p>' + item.Description + '</p>');
                        exerciseItem.append('<a href="' + item.Link + '">More Info</a>');
                        exerciseList.append(exerciseItem);
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    // Fetch goals and populate dropdown menu on page load
    fetchGoals();

    // Event listener for dropdown menu change
    $('#GoalId').change(function() {
        var selectedGoalId = $(this).val();
        fetchExercises(selectedGoalId);
    });
});
