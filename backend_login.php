<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

session_start();

$host = 'localhost';
$username = 'root'; 
$password = '';
$dbname = 'recipe'; 
$port = 3306;

$conn = new mysqli($host, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

function getUsers($conn) {
    $query = "SELECT id, username FROM users";
    $result = $conn->query($query);
    $users = [];

    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($users);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : null;
    $password = isset($_POST['password']) ? trim($_POST['password']) : null;

    if (empty($username) || empty($password)) {
        echo json_encode(["error" => "Username and Password cannot be empty."]);
        exit();
    }

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    if (!$stmt) {
        echo json_encode(["error" => "SQL prepare failed: " . $conn->error]);
        exit();
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userId, $storedPassword);
        $stmt->fetch();

        if ($password === $storedPassword) {
            $_SESSION['user_id'] = $userId;
            $_SESSION['username'] = $username;

            header("Location: ./frontend/index.html");
            exit();
        } else {
            echo json_encode(["error" => "Invalid password."]);
        }
    } else {
        echo json_encode(["error" => "Invalid username."]);
    }

    $stmt->close();
} else {
    getUsers($conn);
}

$conn->close();
?>
