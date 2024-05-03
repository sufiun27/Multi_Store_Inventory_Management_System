<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../../../hostingDBinfoClass.php';
//echo $db;



class DbhReport extends DbInfo {
    private $db_name;

    public function __construct() {
        parent::__construct(); // Call the constructor of the parent class to initialize host, user, and pass.
        $this->db_name = $_SESSION['company'];
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
// class DbhReport {
//     private $host = "localhost";
//     private $user = "root";
//     private $pass = "";
//     private $db_name;

//     public function __construct() {
//         $this->db_name = $_SESSION['company'];
//     }

//     protected function connect() {
//         $dsn = "mysql:host=".$this->host.";dbname=".$this->db_name;
//         $pdo = new PDO($dsn, $this->user, $this->pass);
//         $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
//         return $pdo;
//     }
// }
?>


