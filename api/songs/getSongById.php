<?php

// Allow requests from any origin
header("Access-Control-Allow-Origin: *");

// Other headers to allow
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Check if it's a pre-flight request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Required files
require_once '../config/database.php';
require_once '../objects/songs.php';

// Instantiate database connection
$database = new Database();
$db = $database->getConnection();

// Instantiate SongsController
$songsController = new SongsController($db);

// Check request method
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Check if an ID parameter is provided in the URL
    if(isset($_GET['id'])) {
        // Get the ID parameter from the URL
        $id = $_GET['id'];

        // Fetch song by ID from database
        $stmt = $songsController->readById($id);

        // Check if any song found
        if ($stmt->rowCount() > 0) {
            // Fetch song as an associative array
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Extract song data
            extract($row);

            // Create an associative array with song data
            $song_item = array(
                'id' => $id,
                'name' => $name,
                'author' => $author
            );

            // Output song data as JSON
            http_response_code(200);
            echo json_encode($song_item);
        } else {
            // No song found with the provided ID
            http_response_code(404);
            echo json_encode(array('message' => 'No song found with the provided ID.'));
        }
    } else {
        // No ID parameter provided in the URL
        http_response_code(400);
        echo json_encode(array('message' => 'No ID parameter provided in the URL.'));
    }
} else {
    // Invalid request method
    http_response_code(405);
    echo json_encode(array('message' => 'Method Not Allowed.'));
}
?>