<?php
session_start();

include '../../../hostingDBinfoClass.php';

class Dbhs extends DbInfo {
    private $db_name;

    public function __construct() {
        parent::__construct(); // Call the constructor of the parent class to initialize host, user, and pass.
        $this->db_name = $_SESSION['company'];
    }

    protected function connect() {
        $dsn = "sqlsrv:Server=" . $this->getHost() . ";Database=" . $this->db_name;
        //$dsn = "mysql:host=" . $this->getHost() . ";dbname=" . $this->db_name;
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


$supp_db="OK";

?>


