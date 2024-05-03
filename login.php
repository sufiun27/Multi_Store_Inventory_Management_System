<?php
include 'connection.php';
class Auth extends Dbh
{
    public function authenticate($email)
    {
        $pdo = $this->connect();

        // Prepare the query
        $query = "SELECT *
        FROM [inventoryuser].[dbo].[user] u
             INNER JOIN [inventoryuser].[dbo].[dbinfo] d ON u.site = d.db_name
                  WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        //$stmt->bindParam(':password', $password);

        // Execute the query
        $stmt->execute();

        // Initialize an array to store the results
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Fetch records one by one and add them to the results array
            $results = $row;
        }

        // Check if any rows were returned
        $rowCount = count($results);

        if ($rowCount > 0) {
            // Authentication successful
            return $results;
        } else {
            // Authentication failed
            return false;
        }
    }
}



// Generate CSRF token
function generateCSRFToken()
{
    if (session_status() === PHP_SESSION_NONE) {
        // Start the session
        session_start();
        // Perform any other session initialization or setup here
    }

    if (empty($_SESSION['csrf_token'])) {
        if (function_exists('random_bytes')) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        } else {
            $_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(32));
        }
    }

    return $_SESSION['csrf_token'];
}

// Update CSRF token in database
class CsrfUpdate extends Dbh
{
    public function updateCsrfToken($uid, $newToken)
    {
        $pdo = $this->connect();

        // Prepare the update query
        $query = "UPDATE user_token SET csrf = :token , active = 1 WHERE u_id = :uid ";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':token', $newToken);
        $stmt->bindParam(':uid', $uid);



        // Execute the update query
        $success = $stmt->execute();

        // Check if the update was successful
        if ($success && $stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
//additional information/////////
//change accourdin to your time zone
date_default_timezone_set('Asia/Dhaka');
$defaultDateTime = date('Y-m-d H:i:s');

//base domain url ////////// change according server//////////////////////////////////////////////////////

$default_url='10.3.13.87/storehl';

//base domain url////////////////////////////////////////////////////////////////
$extra_url='store/layout/start/';
$extra_url_superadmin='super_admin/index.php';
// Authenticate user based on input
$auth = new Auth();
//$username = $_POST['username'];
//$password = ;
//$password = md5($_POST['password']);
$email = $_GET['email'];
$row=$auth->authenticate($email);
if ($row==true) {
    //print_r($row);
    echo "You are logged in  --  ";
    //echo $row['role'];
    (string)$csrf = generateCSRFToken();
    //echo $csrf;
    //echo "<br>".$row['u_id'];
    $csrfDb = new CsrfUpdate();

    if ($csrfDb->updateCsrfToken($row['u_id'], $csrf)) {
        //echo "<br>CSRF token inserted successfully.";
        $_SESSION['uid'] = $row['u_id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['company'] = $row['location'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['section'] = $row['section'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['table']='short';
        $_SESSION['po'] = $row['short_name'];
        //$_SESSION['site'] = $row['site'];
        
        $_SESSION['base_url'] = $default_url;
        $_SESSION['is_logged_in'] = true;
        $_SESSION['Asia_Dhaka_time'] = $defaultDateTime;
        //header("Location:csrf_test.php");
        if($row['role'] == 'super_admin'){
           // echo $row['username'];
            //echo "             Super admin            ";
            //echo "super admin";
            $_SESSION['company'] = NULL;
           // echo $_SESSION['company'];
            header("Location:http://$default_url/$extra_url_superadmin");
        }
        elseif($row['role'] == 'admin' or $row['role'] == 'user' or $row['role'] == 'group_admin'){
            //echo "     Normal user    ";
            header("Location:http://$default_url/$extra_url");
        }
    } else {
        echo "<br>Failed to insert CSRF token.";
    }
} else {
    // User authentication failed
    header("Location:index.php?error=Invalid username or password");
    //echo "Invalid username or password";
}
?>
