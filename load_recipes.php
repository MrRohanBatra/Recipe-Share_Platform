<?php
header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Allow specific methods
header("Access-Control-Allow-Headers: Content-Type"); // Allow specific headers

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "recipe";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch recipes, including category
$sql = "SELECT id, title, description, category FROM recipes ORDER BY created_at DESC";
$result = $conn->query($sql);

$recipes = array();
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $recipes[] = $row;
    }
}

// Always return a valid JSON response (even if no recipes found)
echo json_encode([
    "success" => true,
    "recipes" => $recipes
]);

// Close the connection
$conn->close();
?>
