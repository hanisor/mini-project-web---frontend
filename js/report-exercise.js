document.addEventListener('DOMContentLoaded', function() {
    fetch('../healthy-habits-backend/exercise.php')
        .then(response => response.json())
        .then(data => {
            const exerciseList = document.getElementById('exerciseList');
            if (data.length > 0) {
                data.forEach(exercise => {
                    const exerciseDiv = document.createElement('div');
                    exerciseDiv.classList.add('exercise');

                    exerciseDiv.innerHTML = `
                        <h2>${exercise.Name}</h2>
                        <p><strong>Description:</strong><br> ${exercise.Description}</p>
                        <p><strong>Link:</strong><br> <a href="${exercise.Link}" target="_blank">${exercise.Link}</a></p>
                    `;
                    exerciseList.appendChild(exerciseDiv);
                });
            } else {
                exerciseList.innerHTML = '<p>No exercise found.</p>';
            }
        })
        .catch(error => {
            console.error('Error fetching exercises:', error);
            const exerciseList = document.getElementById('exerciseList');
            exerciseList.innerHTML = '<p>Error fetching exercises.</p>';
        });
});
