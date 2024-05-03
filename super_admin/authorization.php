<?php
if (session_status() === PHP_SESSION_NONE) {
    // Start the session
    session_start();
    // Perform any other session initialization or setup here
}
////DB connection////////////
class Dbh
{
    private $host = "BDAPPSS02V\\SQLEXPRESS"; // Double backslashes are used to escape a single backslash in the host name
    private $user = "sa";
    private $pass = "sa@123";
    private $db_name = "inventoryuser";

    public function __construct()
    {
        //$this->db_name = $_SESSION['company'];
    }

    protected function connect()
    {
        $dsn = "sqlsrv:Server=" . $this->host . ";Database=" . $this->db_name;
        try {
            $pdo = new PDO($dsn, $this->user, $this->pass);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        } catch (PDOException $e) {
            // Handle database connection error here
            echo "Connection failed: " . $e->getMessage();
            return null;
        }
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
    $_SESSION['csrf_index']=true;
} else {
    header("Location: http://localhost:8080/storehl/");
    $_SESSION['csrf_index']=false;
}


?>





<!--################################################################################################################################################################-->

<?php

if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    // Redirect the user to the login page or display an error message
    header("Location: http://localhost:8080/storehl/");
    exit();
}

?>
<?php
date_default_timezone_set('Asia/Dhaka');
$defaultDateTime = date('Y-m-d H:i:s');
?>
