<?php
// Start session
session_start();

include '../layoutdbconnection.php';

// Get item ID and update information from session
$item_main_id = $_GET['id'];
$item_update_by = $_SESSION['username'];

// Set default date and time
date_default_timezone_set('Asia/Dhaka');
$defaultDateTime = date('Y-m-d H:i:s');

$active = 1;

// Prepare the SQL statement using prepared statements
$stmt = $conn->prepare("UPDATE item SET i_active = :active, i_update_datetime = :update_datetime, i_update_by = :update_by WHERE i_id = :item_id");

$stmt->bindParam(':active', $active, PDO::PARAM_STR);
$stmt->bindParam(':update_datetime', $defaultDateTime, PDO::PARAM_STR);
$stmt->bindParam(':update_by', $item_update_by, PDO::PARAM_STR);
$stmt->bindParam(':item_id', $item_main_id, PDO::PARAM_INT);

// Execute the statement and handle success or error
if ($stmt->execute()) {
    // Display success message
    $adduser_process_massae = "Update successfully";
    redirectToPage('product_list.php', $adduser_process_massae, $item_main_id);
} else {
    // Display error message
    $adduser_process_massae = "Failed to update item";
    redirectToPage('product_list.php', $adduser_process_massae);
}

// Close the statement and database connection
$stmt->close();
$conn->close();

// Function to redirect to a new page with a message and item ID as query parameters
function redirectToPage($page, $message, $item_id = '') {
    $url = $page . '?value=' . urlencode($message);
    if ($item_id) {
        $url .= '&id=' . urlencode($item_id);
    }
    header("Location: $url");
    exit();
}
?>
