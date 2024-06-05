document.getElementById('recipeForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const name = document.getElementById('name').value;
    const ingredient = document.getElementById('ingredient').value;
    const description = document.getElementById('description').value;
    const category = document.getElementById('category').value;

    fetch('../healthy-habits-backend/recipe-admin.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ Name: name, Ingredient: ingredient, Description: description, Category: category })
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('messages').innerText = data.message;
    })
    .catch(error => {
        document.getElementById('messages').innerText = 'Error: ' + error.message;
    });
});

document.getElementById('updateForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const exerciseId = document.getElementById('exerciseId').value;
    const updateName = document.getElementById('updateName').value;
    const updateIngredient = document.getElementById('updateIngredient').value;
    const updateDescription = document.getElementById('updateDescription').value;

    const updateData = {};
    if (updateName) updateData.Name = updateName;
    if (updateIngredient) updateData.Ingredient = updateIngredient;
    if (updateDescription) updateData.Description = updateDescription;

    fetch(`api.php/${exerciseId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(updateData)
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('responseMessage').innerText = data.message;
    })
    .catch(error => {
        document.getElementById('responseMessage').innerText = 'Error: ' + error.message;
    });
});
