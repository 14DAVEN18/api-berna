<?php

// Include the database configuration file
require_once './database.php';

// Create a new instance of the Database class
$database = new Database();

// Attempt to establish a connection to the database
try {
    $pdo = $database->getConnection();
    echo "Connected successfully";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
