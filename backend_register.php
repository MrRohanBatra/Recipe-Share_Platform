<?php
session_start();


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "recipe";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (!isset($_POST['username']) || !isset($_POST['email']) || !isset($_POST['password'])) {
    http_response_code(400);
    echo json_encode(["error" => "Required fields are missing."]);
    exit();
}

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];


if (empty($username) || empty($email) || empty($password)) {
    http_response_code(400);
    echo json_encode(["error" => "All fields are required."]);
    exit();
}


if ($stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)")) {

    $stmt->bind_param("sss", $username, $email, $password);


    if ($stmt->execute()) {

        header("Location: http://localhost/recipe/frontend/index.html?cmd=" . urlencode("Registration Successful"));
        exit();
    } else {

        http_response_code(500);
        echo json_encode(["error" => "Registration failed. Please try again later."]);
    }


    $stmt->close();
} else {

    http_response_code(500);
    echo json_encode(["error" => "Database error: Failed to prepare statement."]);
}


$conn->close();
