<?php
if (session_status() === PHP_SESSION_NONE) {
    // Start the session
    session_start();
    // Perform any other session initialization or setup here
}
////DB connection////////////
class Dbh
{
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db_name="inventoryuser";

    public function __construct()
    {
        //$this->db_name = $_SESSION['company'];
    }

    protected function connect()
    {
        $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name;
        $pdo = new PDO($dsn, $this->user, $this->pass);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    }
}
///////////////////
class AuthCsrf extends Dbh
{
    public function authenticate($token, $uid)
    {
        $pdo = $this->connect();
        $query = "SELECT csrf FROM user_token WHERE u_id = :uid ";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':uid', $uid);
        $stmt->execute();
        //echo $stmt->errorInfo();
        $row = $stmt->fetch();
        if($row['csrf'] == $token)
        {
            return true;
        }
        else
        {
            return false;
        }



    }
}

$token = $_SESSION['csrf_token'];
$uid = $_SESSION['uid'];
$auth = new AuthCsrf();
if ($auth->authenticate($token, $uid)) {
    echo 'true';
} else {
    echo 'false';
}

