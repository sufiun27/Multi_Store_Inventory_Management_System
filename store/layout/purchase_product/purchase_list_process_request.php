<?php
session_start();
include '../layoutdbconnection.php';
// Input validation and sanitization
$purchase_id = isset($_GET['p_id']) ? $_GET['p_id'] : '';
$accept_by = isset($_SESSION['username']) ? $_SESSION['username'] : '';

date_default_timezone_set('Asia/Dhaka');
$defaultDateTime = date('Y-m-d H:i:s');

// Include database connection


// URLs
$extra_url = 'store/layout/purchase_product/purchase_list.php';
$base_url = isset($_SESSION['base_url']) ? $_SESSION['base_url'] : '';

// Prepare and bind parameters for SQL query
$sql = "UPDATE item_purchase
        SET p_request = 1, p_request_accept_by = :accept_by, p_request_accept_datetime = :defaultDateTime
        WHERE p_id = :purchase_id";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':accept_by', $accept_by, PDO::PARAM_STR);
$stmt->bindParam(':defaultDateTime', $defaultDateTime, PDO::PARAM_STR); // Assuming $defaultDateTime is a string, adjust the data type if needed
$stmt->bindParam(':purchase_id', $purchase_id, PDO::PARAM_INT); // Adjust data type if needed


// Execute the query and handle success or error
if ($stmt->execute()) {
    // Redirect to a new page with the value included as a query parameter
    header("Location: http://$base_url/$extra_url");
    exit();
} else {
    // Redirect to a new page with the value included as a query parameter
    header("Location: http://$base_url/$extra_url");
    exit();
}

// Close the database connection
$stmt->close();
$conn->close();
?>
