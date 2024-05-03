<?php

/// need to also change it

$servername = "BDAPPSS02V\SQLEXPRESS";
$username = "sa";
$password = "sa@123";

// Database configuration for different stores
$user_name = 'admin';
$user_company = 'hlfs';
$user_role = 'admin';



$database = $user_company;

try {
        $conn = new PDO("sqlsrv:Server=$servername;Database=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
    
// Close the database connection when you're done with your operations
//$conn = null;


// Fetch department names from the database
$sql = "SELECT d_name FROM department ORDER BY d_name DESC";

$result = $conn->query($sql);



if (!$result) {
    die("Error in SQL query: " . $conn->errorInfo()[2]);
}

$rowno = $result->rowCount();
echo $rowno;
echo "<p>Total departments: " . $rowno . "</p>";


    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "" . $row['d_name'] . " | ";
    
    echo "</p>";

    }
//$conn = null;
?>