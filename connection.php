<?php
// Check if session has already started
if (session_status() === PHP_SESSION_NONE) {
    // Start the session
    session_start();
    // Perform any other session initialization or setup here
}

include 'hostingDBinfoClass.php';

class Dbh extends DbInfo {
    private $db_name = "inventoryuser";

    public function __construct() {
        parent::__construct(); // Call the constructor of the parent class to initialize host, user, and pass.
    }

    protected function connect() {
        $dsn = "sqlsrv:Server=" . $this->getHost() . ";Database=" . $this->db_name;

        try {
            $pdo = new PDO($dsn, $this->getUser(), $this->getPass());
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        } catch (PDOException $e) {
            // Handle database connection error here
            echo "Connection failed: " . $e->getMessage();
            return null;
        }
    }
}





