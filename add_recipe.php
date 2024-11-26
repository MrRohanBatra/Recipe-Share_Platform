<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "recipe";


$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (!isset($_POST['title'], $_POST['description'], $_POST['category'], $_POST['ingredients'], $_POST['steps'], $_POST['image_url'])) {
        die("Error: All fields are required.");
    }

   
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $ingredients = $_POST['ingredients'];
    $steps = $_POST['steps'];
    $image_url = $_POST['image_url'];

    if (empty($title) || empty($description) || empty($category) || empty($ingredients) || empty($steps) || empty($image_url)) {
        die("Error: All fields must be filled.");
    }

   
    $sql = "INSERT INTO recipes (title, description, category, ingredients, instructions, image_url)
            VALUES (?, ?, ?, ?, ?, ?)";

   
    if ($stmt = $conn->prepare($sql)) {
       
        $stmt->bind_param("ssssss", $title, $description, $category, $ingredients, $steps, $image_url);

        
        if ($stmt->execute()) {
            
            header("Location: http://localhost/recipe/frontend/index.html"); 
            
        } else {
            echo "Error: Could not execute query. " . $stmt->error;
        }


        $stmt->close();
    } else {
        echo "Error: Could not prepare statement. " . $conn->error;
    }
}


$conn->close();
?>