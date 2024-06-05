const resources = {
    healthyLifestyle: [
        { type: 'article', title: '10 Tips for a Healthy Lifestyle', link: 'https://example.com/lifestyle1' },
        { type: 'video', title: 'Healthy Living: The Basics', link: 'https://www.youtube.com/watch?v=xyQY8a-ng6g&list=PLq_kAHHySqw5p716lV_JvLmydZkbO3RJe&pp=gAQBiAQB' },
    ],
    healthyFood: [
        { type: 'article', title: 'Top 10 Superfoods for a Healthy Diet', link: 'https://example.com/food1' },
        { type: 'video', title: 'Cooking Healthy Meals at Home', link: 'https://www.youtube.com/watch?v=c06dTj0v0sM&list=PLq_kAHHySqw7z2LoED6WfVFda5TmfePzg&pp=gAQBiAQB' },
    ]
};

function filterResources(category) {
    const resourceContainer = document.getElementById('resources');
    resourceContainer.innerHTML = '';

    const categoryResources = resources[category];
    if (categoryResources) {
        categoryResources.forEach(resource => {
            const resourceBox = document.createElement('div');
            resourceBox.classList.add('resource-box');
            resourceBox.style.display = 'flex';

            const resourceTitle = document.createElement('h3');
            resourceTitle.textContent = resource.type === 'article' ? 'Article' : 'Video';

            const resourceLink = document.createElement('a');
            resourceLink.href = resource.link;
            resourceLink.target = '_blank';
            resourceLink.textContent = resource.title;

            resourceBox.appendChild(resourceTitle);
            resourceBox.appendChild(resourceLink);
            resourceContainer.appendChild(resourceBox);
        });
    }
}
