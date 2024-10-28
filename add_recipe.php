<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "recipe";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

$input = json_decode(file_get_contents('php://input'), true);

$stmt = $conn->prepare("INSERT INTO recipes (user_id, title, description, ingredients, instructions, created_at, category) VALUES (?, ?, ?, ?, ?, NOW(), ?)");
$stmt->bind_param("isssss", $user_id, $title, $description, $ingredients, $instructions, $category);

$user_id = 1; 
$title = $input['title'] ?? '';
$description = $input['description'] ?? '';
$ingredients = $input['ingredients'] ?? ''; 
$instructions = $input['steps'] ?? '';
$category = $input['category'] ?? 'Uncategorized';
if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Recipe added successfully."]);
} else {
    echo json_encode(["success" => false, "message" => "Error adding recipe: " . $stmt->error]);
}


$stmt->close();
$conn->close();
?>
