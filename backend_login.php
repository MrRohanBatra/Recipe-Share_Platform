<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// CORS headers for API usage
header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Allow specific methods
header("Access-Control-Allow-Headers: Content-Type"); // Allow specific headers

session_start();

// Database connection settings
$host = 'localhost'; // or use '127.0.0.1'
$username = 'root'; 
$password = ''; // Empty password for XAMPP
$dbname = 'recipe'; 
$port = 3306; // Default MySQL port

// Create a connection to the database
$conn = new mysqli($host, $username, $password, $dbname, $port);

// Check the connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Function to return all users as JSON
function getUsers($conn) {
    $query = "SELECT id, username FROM users"; // Fetching only id and username for security
    $result = $conn->query($query);
    $users = [];

    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($users);
}

// Handle POST request (login)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and get form data
    $username = isset($_POST['username']) ? trim($_POST['username']) : null;
    $password = isset($_POST['password']) ? trim($_POST['password']) : null;

    // Input validation
    if (empty($username) || empty($password)) {
        echo json_encode(["error" => "Username and Password cannot be empty."]);
        exit();
    }

    // Prepare SQL statement to check user
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    if (!$stmt) {
        echo json_encode(["error" => "SQL prepare failed: " . $conn->error]);
        exit();
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Check if user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userId, $storedPassword);
        $stmt->fetch();

        // Compare plain text password directly (as requested)
        if ($password === $storedPassword) {
            // Store user information in session
            $_SESSION['user_id'] = $userId;
            $_SESSION['username'] = $username;

            // Redirect to homepage (or wherever you want)
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
    // Handle GET request to return list of users
    getUsers($conn);
}

// Close the database connection
$conn->close();
?>
