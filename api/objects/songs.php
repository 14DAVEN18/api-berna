<?php

class Song {
    // Properties
    public $id;
    public $name;
    public $author;

    // Constructor with parameters
    public function __construct($id, $name, $author) {
        $this->id = $id;
        $this->name = $name;
        $this->author = $author;
    }
}

class SongsController {
    // Database connection and table name
    private $conn;
    private $table_name = "songs";

    // Constructor with $db as database connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // Read all songs
    function read() {
        // Select all query
        $query = "SELECT id, name, author FROM " . $this->table_name;

        // Prepare query statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // Read song by ID
    function readById($id) {
        // Select query with a placeholder for the song ID
        $query = "SELECT id, name, author FROM " . $this->table_name . " WHERE id = :id";

        // Prepare query statement
        $stmt = $this->conn->prepare($query);

        // Bind the song ID parameter
        $stmt->bindParam(':id', $id);

        // Execute query
        $stmt->execute();

        return $stmt;
    }
}
?>