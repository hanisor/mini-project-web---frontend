// Sample data - Replace with actual resources data
const resources = {
    healthyLifestyle: [
        { title: 'Article 1', type: 'articles', link: 'https://example.com/article1' },
        { title: 'Video 1', type: 'videos', link: 'https://www.youtube.com/watch?v=xyQY8a-ng6g&list=PLq_kAHHySqw5p716lV_JvLmydZkbO3RJe&pp=gAQBiAQB' }
    ],
    healthyFood: [
        { title: 'Article 2', type: 'articles', link: 'https://example.com/article2' },
        { title: 'Video 2', type: 'videos', link: 'https://www.youtube.com/watch?v=c06dTj0v0sM&list=PLq_kAHHySqw7z2LoED6WfVFda5TmfePzg&pp=gAQBiAQB' }
    ]
};

// Function to filter and display resources based on category
function filterResources(category) {
    const filteredResources = resources[category];
    displayResources(filteredResources);
}

// Function to display resources
function displayResources(resources) {
    const resourcesContainer = document.querySelector('.resources');
    resourcesContainer.innerHTML = '';

    resources.forEach(resource => {
        const resourceElement = document.createElement('div');
        resourceElement.classList.add('resource');

        const titleElement = document.createElement('h3');
        titleElement.textContent = resource.title;

        const linkElement = document.createElement('a');
        linkElement.textContent = 'View';
        linkElement.href = resource.link;
        linkElement.target = '_blank';
        linkElement.style.display = 'none'; // Initially hide the link

        resourceElement.appendChild(titleElement);
        resourceElement.appendChild(linkElement);

        resourcesContainer.appendChild(resourceElement);
    });

    // Show links when a category button is clicked
    const links = resourcesContainer.querySelectorAll('.resource a');
    links.forEach(link => {
        link.style.display = 'inline'; // Show the link
    });

    // Show the resources container after adding content
    resourcesContainer.style.display = 'block';
}

// Display default message
const resourcesContainer = document.querySelector('.resources');
resourcesContainer.innerHTML = '<p>Please select a category to view resources.</p>';
