<?php
header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Allow specific methods
header("Access-Control-Allow-Headers: Content-Type"); // Allow specific headers

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database configuration
$host = 'localhost'; // MySQL server address
$dbname = 'recipe'; // Your database name
$username = 'root'; // Your MySQL username
$password = ''; // Your MySQL password
$port = 3306; // Your MySQL port (default is 3306)

// Create a connection to the database
$conn = new mysqli($host, $username, $password, $dbname, $port);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve recipe ID from the query string
if (isset($_GET['id'])) {
    $recipe_id = (int)$_GET['id'];
    if ($recipe_id <= 0) {
        die("Invalid recipe ID");
    }

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("SELECT title, description, ingredients, instructions FROM recipes WHERE id = ?");
    if (!$stmt) {
        die("Preparation failed: " . $conn->error);
    }
    $stmt->bind_param("i", $recipe_id);
    if (!$stmt->execute()) {
        die("Execution failed: " . $stmt->error);
    }
    
    // Get the result
    $result = $stmt->get_result();
    
    // Check if a recipe was found
    if ($result->num_rows > 0) {
        $recipe = $result->fetch_assoc();

        // Prepare the response
        $response = [
            'title' => $recipe['title'],
            'description' => $recipe['description'],
            'ingredients' => explode(",", $recipe['ingredients']), // Split ingredients into an array
            'instructions' => explode("\n", $recipe['instructions']) // Split instructions into an array
        ];

        // Return the recipe as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // No recipe found
        header('HTTP/1.1 404 Not Found');
        echo json_encode(['error' => 'Recipe not found']);
    }
    
    // Close the statement
    $stmt->close();
} else {
    // Invalid request
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Recipe ID is required']);
}

// Close the database connection
$conn->close();
?>
