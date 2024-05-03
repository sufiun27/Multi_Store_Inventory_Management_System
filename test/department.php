<!DOCTYPE html>
<html>
<head>
    <title>Query Results</title>
</head>
<body>
<h1>Query Results</h1>

<?php
// Database connection parameters
$dbHost = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "hlfs";

// Create a database connection
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query
$sql = "SELECT d_name, i_name, c_name, SUM(is_qty) AS quantity, SUM(total_price) AS total_price
            FROM (
                SELECT iss.is_id, i.i_name, c.c_name, 
                       i.i_size, i.i_unit, 
                       iss.is_qty, ist.total_price as total_price, 
                       iss.is_datetime, iss.is_item_issue_by, e.e_com_id, e.e_name, d.d_name, d.d_id
                FROM item_issue iss 
                INNER JOIN item i ON iss.i_id = i.i_id 
                INNER JOIN employee e ON iss.e_id = e.e_id
                INNER JOIN department d ON d.d_id = e.d_id
                INNER JOIN category_item c ON i.c_id = c.c_id
                INNER JOIN (SELECT SUM(ist_qty * ist_price) as total_price, is_id FROM item_issue_trac GROUP BY is_id) ist ON ist.is_id = iss.is_id
            ) AS subquery
            GROUP BY d_id";

// Execute the query
$result = $conn->query($sql);
$row = $result->fetch_all();
print_r($row);


// Check if the query was successful

// Close the database connection
$conn->close();
?>
</body>
</html>
