<?php
session_start();

include_once '../layoutdbconnection.php';

// Validate and sanitize the input
$emp_main_id = isset($_GET['id']) ? $_GET['id'] : '';
$emp_update_by = $_SESSION['username'] ?? '';

// Ensure that emp_main_id is a valid integer value
if (!ctype_digit($emp_main_id)) {
    redirectToPage('Product_category.php', 'Invalid employee ID');
}

date_default_timezone_set('Asia/Dhaka');
$defaultDateTime = date('Y-m-d H:i:s');

$active = 1;

// Prepare the SQL statement using prepared statements
$stmt = $conn->prepare("UPDATE category_item SET c_active = :c_active, c_update_datetime = :c_update_datetime, c_update_by = :c_update_by WHERE c_id = :c_id");

$stmt->bindParam(':c_active', $active, PDO::PARAM_INT);
$stmt->bindParam(':c_update_datetime', $defaultDateTime, PDO::PARAM_STR);
$stmt->bindParam(':c_update_by', $emp_update_by, PDO::PARAM_STR);
$stmt->bindParam(':c_id', $emp_main_id, PDO::PARAM_INT);

// Execute the statement and handle success or error
if ($stmt->execute()) {
    $adduser_process_message = "Update successfully";
    redirectToPage('Product_category.php', $adduser_process_message);
} else {
    $adduser_process_message = "Failed to update employee!";
    redirectToPage('Product_category.php', $adduser_process_message);
}

// Close the statement and database connection
$stmt->close();
$conn->close();

// Function to redirect to a new page with a message as a query parameter
function redirectToPage($page, $message) {
    $url = $page . '?value=' . urlencode($message);
    header("Location: $url");
    exit();
}
?>
