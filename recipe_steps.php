<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");



$host = 'localhost';
$dbname = 'recipe';
$username = 'root';
$password = '';
$port = 3306;

$conn = new mysqli($host, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $recipe_id = (int)$_GET['id'];
    if ($recipe_id <= 0) {
        die("Invalid recipe ID");
    }

    $stmt = $conn->prepare("SELECT title, description, ingredients, instructions ,image_url FROM recipes WHERE id = ?");
    if (!$stmt) {
        die("Preparation failed: " . $conn->error);
    }
    $stmt->bind_param("i", $recipe_id);
    if (!$stmt->execute()) {
        die("Execution failed: " . $stmt->error);
    }
    
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $recipe = $result->fetch_assoc();

        $response = [
            'title' => $recipe['title'],
            'description' => $recipe['description'],
            'ingredients' => explode(",", $recipe['ingredients']),
            'instructions' => explode("\n", $recipe['instructions']),
            'image_url'=>$recipe['image_url']
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        header('HTTP/1.1 404 Not Found');
        echo json_encode(['error' => 'Recipe not found']);
    }
    
    $stmt->close();
} else {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Recipe ID is required']);
}

$conn->close();
?>
