<?php
    session_start();
    include 'db_connection.php'; // Assuming this exists

    $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
    $limit = 10;

    $sql = "SELECT id, title, description, category FROM recipes ORDER BY created_at DESC LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $limit, $offset);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $recipes = [];

        while ($row = $result->fetch_assoc()) {
            $recipes[] = $row;
        }

        echo json_encode(["recipes" => $recipes]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Failed to load recipes."]);
    }

    $stmt->close();
    $conn->close();
    ?>
    