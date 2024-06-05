document.addEventListener('DOMContentLoaded', function() {
    fetch('../healthy-habits-backend/recipe-admin.php')
        .then(response => response.json())
        .then(data => {
            const recipeList = document.getElementById('recipeList');
            if (data.length > 0) {
                data.forEach(recipe => {
                    const recipeDiv = document.createElement('div');
                    recipeDiv.classList.add('recipe');

                    // Replace newlines with <br>
                    const formattedIngredients = recipe.Ingredient.replace(/\n/g, '<br>');
                    const formattedDescription = recipe.Description.replace(/\n/g, '<br>');

                    recipeDiv.innerHTML = `
                        <h2>${recipe.Name}</h2>
                        <p><strong>Ingredients:</strong><br>${formattedIngredients}</p>
                        <p><strong>Description:</strong><br>${formattedDescription}</p>
                        <p><strong>Category:</strong> ${recipe.Category}</p>
                    `;
                    recipeList.appendChild(recipeDiv);
                });
            } else {
                recipeList.innerHTML = '<p>No recipes found.</p>';
            }
        })
        .catch(error => {
            console.error('Error fetching recipes:', error);
            const recipeList = document.getElementById('recipeList');
            recipeList.innerHTML = '<p>Error fetching recipes.</p>';
        });
});
