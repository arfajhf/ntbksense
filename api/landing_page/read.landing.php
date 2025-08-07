<?php

// Allow CORS kalau dipanggil dari WordPress
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");


include('../../config/config.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : null;

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if ($id !== null) {
        // Prepare the SQL query to fetch a specific landing page by ID
        $query = "SELECT * FROM wp_acp_landings WHERE id = ?";
        $stmt = mysqli_prepare($connection, $query);

        if (!$stmt) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to prepare statement']);
            exit;
        }

        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $landing_page = mysqli_fetch_assoc($result);
            echo json_encode($landing_page);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Landing page not found']);
        }

        mysqli_stmt_close($stmt);
        exit;
    } else {
        // Prepare the SQL query to fetch all landing pages
        $query = "SELECT * FROM wp_acp_landings";

        // Execute the query
        $result = mysqli_query($connection, $query);

        // Check if the query was successful
        if ($result) {
            // Fetch all landing pages as an associative array
            $landing_pages = mysqli_fetch_all($result, MYSQLI_ASSOC);

            // Return the landing pages as a JSON response
            header('Content-Type: application/json');
            echo json_encode($landing_pages);
        } else {
            // If the query failed, return an error message
            http_response_code(500);
            echo json_encode(['error' => 'Failed to fetch landing pages']);
        }
    }
} else {
    // If the request method is not GET, return a 405 Method Not Allowed response
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
