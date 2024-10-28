# Recipe-Share Platform
A web-based platform for sharing, browsing, and managing recipes. This application allows us## Features
- **User Authentication:** Register and log in to manage your own recipes.
- **Recipe Management:** Add, view, and browse recipes.
- **Interactive Frontend:** Clean and user-friendly interface with separate styling for login, re## Project Structure
```
Recipe-Share_Platform-main/
├── backend_login.php # Backend logic for user login
├── backend_register.php # Backend logic for user registration
├── add_recipe.php # Script for adding new recipes
├── load_recipes.php # Script for loading all recipes
├── recipe_steps.php # Step-by-step instructions for each recipe
├── frontend/
│ ├── index.html # Homepage for viewing recipes
│ ├── login.html # Login page
│ ├── register.html # Registration page
│ ├── test.html # Testing or additional frontend file
│ └── src/ # CSS styles for various frontend pages
│ ├── index/style.css
│ ├── login/style.css
│ └── register/style.css
└── LICENSE # License file
```
## Installation
1. **Clone the Repository:**
 ```bash
 git clone https://github.com/username/Recipe-Share_Platform.git
 ```
2. **Set Up Database:**
 - Create a MySQL database named recipe for storing user and recipe data.
3. **Configure Database Connection:**
 - Update the database configuration in the PHP files to match your MySQL credentials.
4. **Start the Server:**
 - Use a local server (e.g., XAMPP or WAMP) or deploy to a PHP-enabled web server.
 - Create a folde named recipe inside htdocs and place all the above files there.
## Usage
- Navigate to the [homepage](http://localhost/recipe/index.php)to view shared recipes.
- Register or log in to add and manage your recipes.
## License
This project is licensed under the MIT License. See the LICENSE file for details.
