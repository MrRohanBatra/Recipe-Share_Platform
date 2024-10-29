let recipes = [];
function loadRecipes() {
  fetch("http://localhost/recipe/load_recipes.php")
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok: " + response.statusText);
      }
      return response.json();
    })
    .then((data) => {
      recipes = data.recipes;
      displayRecipes(recipes);
    })
    .catch((error) => console.error("Error loading recipes:", error));
}

function displayRecipes(recipes) {
  const recipesContainer = document.querySelector(".recipes");
  recipesContainer.innerHTML = "";

  recipes.forEach((recipe) => {
    const recipeCard = document.createElement("div");
    recipeCard.className = "recipe-card";
    recipeCard.innerHTML = `
            <h3>${recipe.title}</h3>
            <p>${recipe.description}</p>
            <p><strong>Category:</strong> ${
              recipe.category || "Uncategorized"
            }</p>
            <a href="http://localhost/recipe/frontend/steps.html?id=${
              recipe.id
            }">View Steps</a>
        `;
    recipesContainer.appendChild(recipeCard);
  });
}

const openModalBtn = document.getElementById("openModalBtn");
const modal = document.getElementById("addRecipeModal");
const closeModalBtn = document.getElementById("closeModalBtn");
const modalbutton = document.getElementById("openModalButton");
openModalBtn.onclick = function () {
  modal.style.display = "block";
};
modalbutton.onclick = function () {
  modal.style.display = "block";
};
closeModalBtn.onclick = function () {
  modal.style.display = "none";
  document.getElementById("recipeForm").reset();
  document.getElementById("formMessage").textContent = "";
};

window.onclick = function (event) {
  if (event.target == modal) {
    closeModalBtn.onclick();
  }
};

const recipeForm = document.getElementById("recipeForm");
recipeForm.addEventListener("submit", function (event) {
  event.preventDefault();

  const title = document.getElementById("title").value;
  const description = document.getElementById("description").value;
  const category = document.getElementById("category").value;
  const steps = document.getElementById("steps").value;

  fetch("http://localhost/recipe/add_recipe.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      title: title,
      description: description,
      category: category,
      steps: steps,
    }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        modal.style.display = "none";
        loadRecipes();
      } else {
        document.getElementById("formMessage").textContent =
          data.message || "Error adding recipe.";
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      document.getElementById("formMessage").textContent =
        "An error occurred. Please try again.";
    });
});
function searchitems() {
  let tosearch = new String();
  tosearch = document.getElementById("search-box").value;
  tosearch = tosearch.toLowerCase();
  const filterrecipes = recipes.filter((recipe) =>
    recipe.category.toLowerCase().includes(tosearch)
  );
  displayRecipes(filterrecipes);
}

window.onload = loadRecipes;
