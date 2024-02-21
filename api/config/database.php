<?php

class Database {
    // Database credentials
    private $host = "localhost";
    private $db_name = "berna_songs";
    private $username = "root";
    private $password = "";
    public $conn;

    // Get the database connection
    public function getConnection() {
        $this->conn = null;

        try {
            // Create a new PDO instance
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->exec("set names utf8mb4");
        } catch(PDOException $exception) {
            // Handle connection errors
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}

?>
