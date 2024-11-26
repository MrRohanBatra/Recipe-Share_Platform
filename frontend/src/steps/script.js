const urlParams = new URLSearchParams(window.location.search);
const recipeId = urlParams.get("id");

if (recipeId) {
  fetch(`http://localhost/recipe/recipe_steps.php?id=${recipeId}`)
    .then((response) => response.json())
    .then((data) => {
      if (data.error) {
        document.getElementById("recipe-title").innerText = "Recipe Not Found";
        document.getElementById("recipe-description").innerText = data.error;
      } else {
        document.getElementById("recipe-title").innerText = data.title;
        document.getElementById("recipe-description").innerText =
          data.description;

        const imageElement = document.getElementById("recipe-image");
        imageElement.src = data.image_url;

        const instructionsList = document.getElementById("instructions-list");
        const steps = data.instructions[0].split(",");
        steps.forEach((step) => {
          const li = document.createElement("li");
          li.innerText = step.trim();
          instructionsList.appendChild(li);
        });
      }
    })
    .catch((error) => {
      console.error("Error fetching recipe:", error);
      document.getElementById("recipe-description").innerText =
        "An error occurred while loading the recipe.";
    });
} else {
  document.getElementById("recipe-title").innerText = "Invalid Recipe ID";
  document.getElementById("recipe-description").innerText =
    "Please provide a valid recipe ID in the URL.";
}
