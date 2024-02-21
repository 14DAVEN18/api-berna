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
    // Fetch songs from database
    $stmt = $songsController->read();

    // Check if any songs found
    if ($stmt->rowCount() > 0) {
        // Songs array
        $songs_arr = array();

        // Fetch songs as associative array
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $song_item = array(
                'id' => $id,
                'name' => $name,
                'author' => $author
            );

            array_push($songs_arr, $song_item);
        }

        // Output songs as JSON
        http_response_code(200);
        echo json_encode($songs_arr);
    } else {
        // No songs found
        http_response_code(404);
        echo json_encode(array('message' => 'No songs found.'));
    }
} else {
    // Invalid request method
    http_response_code(405);
    echo json_encode(array('message' => 'Method Not Allowed.'));
}
?>
