// Exercise data array
var exercises = [
    
];

// Function to populate exercise list based on selected goal
function populateExerciseList(selectedGoal) {
    var exerciseList = document.getElementById("exerciseList");
    exerciseList.innerHTML = ""; // Clear previous exercises
    
    exercises.forEach(function(exercise) {
        if (exercise.category === selectedGoal) {
            var exerciseElement = document.createElement("div");
            exerciseElement.innerHTML = "<h3>" + exercise.name + "</h3><p>" + exercise.description + "</p><a href='" + exercise.link + "'>Link</a>";
            exerciseList.appendChild(exerciseElement);
        }
    });
}

// Function to be called when a goal is selected
function fetchExercises() {
    var selectedGoal = document.getElementById("goalId").value;
    populateExerciseList(selectedGoal);
}
