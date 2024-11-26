<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$uploadDir = "uploads/";
$allowedTypes = ["image/jpeg", "image/png", "image/gif"];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
    $file = $_FILES['image'];

    // Check if the file is an image
    if (!in_array($file['type'], $allowedTypes)) {
        echo json_encode(["success" => false, "message" => "Invalid file type."]);
        exit();
    }

    $fileName = uniqid() . '-' . basename($file['name']);
    $filePath = $uploadDir . $fileName;

    // Attempt to move the uploaded file
    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        echo json_encode(["success" => true, "imageUrl" => $filePath]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to upload image."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "No image uploaded."]);
}
?>