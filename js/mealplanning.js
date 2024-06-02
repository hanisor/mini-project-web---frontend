async function fetchUserDetails() {
    try {
        const response = await fetch('../healthy-habits-backend/meal_plan.php');
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        const result = await response.json();

        if (result.success) {
            document.getElementById('meal-plan').style.display = 'block';
            document.querySelector('.meal-content').innerHTML = `
                <p>BMI: ${result.bmi}</p>
                <p>Meal Plan: ${result.mealPlan}</p>
                <div class="recipe-list">
                <br>
                    <h3>Recommended Recipes:</h3>
                    ${result.recipes.map(recipe => `
                        <div class="recipe-box">
                            <h3>${recipe.Name}</h3>
                            <p>${recipe.Ingredient}</p>
                            <p>${recipe.Description}</p>
                        </div>
                    `).join('')}
                </div>
            `;
        } else {
            alert('Failed to fetch user details: ' + result.message);
        }
    } catch (error) {
        console.error('Error fetching user details:', error);
        alert('An error occurred while fetching user details.');
    }
}
