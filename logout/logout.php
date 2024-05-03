
<?php  

// Clear session variables
session_start();
//$base_url = $_SESSION['base_url'];
session_unset();
session_destroy();

// Close database connection
$pdo = null; // Assuming $pdo is your active database connection object

// Redirect to the login page or any other appropriate page
//localhost:8080/storehl
header("Location:http://10.3.13.87/storehl");
//header("Location:http://$base_url");
exit();


//
?>


