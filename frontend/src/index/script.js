let allRecipes = [];
    
const modal = document.getElementById('addRecipeModal');
const openModalButton = document.getElementById('openModalBtn');
const closeModalBtn = document.getElementById('closeModalBtn');
const openModalButton1 = document.getElementById('openModalButton');
const recipeForm = document.getElementById("recipeForm");

openModalButton.onclick = function () {
    modal.style.display = 'block';
}

openModalButton1.onclick = function () {
    modal.style.display = 'block';
}

closeModalBtn.onclick = function () {
    modal.style.display = 'none';
}

window.onclick = function (event) {
    if (event.target === modal) {
        modal.style.display = 'none';
    }
}

function isValidUrl(url) {
    const pattern = /^(https?:\/\/)?(www\.)?[a-zA-Z0-9-]+\.[a-zA-Z]{2,}(\/[^\s]*)?$/;
    return pattern.test(url);
}

function loadRecipes() {
    fetch('http://localhost/recipe/get_recipes.php')
        .then(response => response.json())
        .then(data => {
            if (data && Array.isArray(data.recipes)) {
                allRecipes = data.recipes;
                displayRecipes(allRecipes);
            } else {
                console.error('Error: Invalid response format or no recipes found');
                allRecipes = [];
                displayRecipes(allRecipes);
            }
        })
        .catch(error => {
            console.error('Error fetching recipes:', error);
            allRecipes = [];
            displayRecipes(allRecipes);
        });
}

function displayRecipes(recipes) {
    const recipesContainer = document.querySelector('.recipes');
    recipesContainer.innerHTML = '';

    if (recipes.length === 0) {
        recipesContainer.innerHTML = '<p>No recipes found.</p>';
    } else {
        recipes.forEach(recipe => {
            const recipeCard = document.createElement('div');
            recipeCard.classList.add('recipe-card');
            recipeCard.innerHTML = `
                <img src="${recipe.image_url || 'default-image.jpg'}" alt="Recipe Image">
                <h3>${recipe.title}</h3>
                <p><strong>Category:</strong> ${recipe.category}</p>
                <p>${recipe.description}</p>
                <a href='http://localhost/recipe/frontend/steps.html?id=${recipe.id}'>View Steps</a>
            `;
            recipesContainer.appendChild(recipeCard);
        });
    }
}

recipeForm.addEventListener("submit", function (event) {
    event.preventDefault();

    const title = document.getElementById("title").value;
    const description = document.getElementById("description").value;
    let category = document.getElementById("category").value;
    const ingredients = document.getElementById("ingredients").value;
    const steps = document.getElementById("steps").value;
    const imageUrl = document.getElementById("imageUrl").value;

    if (!isValidUrl(imageUrl)) {
        document.getElementById("formMessage").textContent = "Please enter a valid image URL.";
        return;
    }

    if (category === "Custom") {
        category = prompt("Enter Category to Search");
        if (!category) {
            document.getElementById("formMessage").textContent = "Category is required.";
            return;
        }
    }

    recipeForm.submit();
});

function searchItems() {
    let searchCategory = document.getElementById("search-box").value;
    if (searchCategory === "Custom") {
        searchCategory = prompt("Enter Category to Search");
    }
    let filteredRecipes = allRecipes;

    if (searchCategory && searchCategory !== "") {
        filteredRecipes = allRecipes.filter(recipe => recipe.category === searchCategory);
    }

    displayRecipes(filteredRecipes);
}

document.getElementById("search-box").addEventListener('change', searchItems);

document.addEventListener('DOMContentLoaded', loadRecipes);
const urlp = new URLSearchParams(window.location.search);
const cmd = urlp.get('cmd');
if (cmd) {
    alert(cmd);
}
loadRecipes();
