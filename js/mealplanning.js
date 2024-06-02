
async function fetchUserDetails() {
    try {
        const response = await fetch('../healthy-habits-backend/meal_plan.php');
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        const result = await response.json();

        if (result.success) {
            window.location.href = 'MealPlanningResult.html';
        } else {
            alert('Failed to fetch user details: ' + result.message);
        }
    } catch (error) {
        console.error('Error fetching user details:', error);
        alert('An error occurred while fetching user details.');
    }
}

