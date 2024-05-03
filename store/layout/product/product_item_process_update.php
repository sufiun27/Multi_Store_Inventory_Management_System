<?php
session_start();
include_once '../layoutdbconnection.php';

// Validate and sanitize the input
$cataggory = $_POST['flexRadioDefault'] ?? '';
$item_name = $_POST['item_name'] ?? '';
$item_code = $_POST['item_code'] ?? '';
$brand = $_POST['brand'] ?? '';
$unit = $_POST['Unit'] ?? '';
$size = $_POST['size'] ?? '';
$price = $_POST['price'] ?? '';
$item_add_date = $_SESSION['Asia_Dhaka_time'] ?? '';
$stock_out_reminder_qty = $_POST['stock_out_reminder_qty'] ?? '';
$current_user = $_SESSION['username'] ?? '';
$p_id = $_POST['pid'] ?? '';

// Filter input to prevent SQL injection


// Prepare the SQL statement using prepared statements
$stmt = $conn->prepare("UPDATE item SET i_name = :item_name, i_code= :item_code, i_manufactured_by = :brand, i_update_datetime = :update_datetime, c_id = :cataggory, i_unit = :unit, i_price = :price, stock_out_reminder_qty = :stock_out_reminder_qty, i_size = :size, i_update_by = :update_by WHERE i_id = :item_id");

$stmt->bindParam(':item_name', $item_name, PDO::PARAM_STR);
$stmt->bindParam(':item_code', $item_code, PDO::PARAM_STR);
$stmt->bindParam(':brand', $brand, PDO::PARAM_STR);
$stmt->bindParam(':update_datetime', $item_add_date, PDO::PARAM_STR); // Ensure that $item_add_date is properly formatted as a date/time string.
$stmt->bindParam(':cataggory', $cataggory, PDO::PARAM_STR); // Note: There seems to be a typo in the variable name; make sure it matches your actual variable name.
$stmt->bindParam(':unit', $unit, PDO::PARAM_STR);
$stmt->bindParam(':price', $price, PDO::PARAM_STR); // Adjust the data type if the price should be stored differently (e.g., PDO::PARAM_INT).
$stmt->bindParam(':stock_out_reminder_qty', $stock_out_reminder_qty, PDO::PARAM_INT); // If it's an integer, use PDO::PARAM_INT.
$stmt->bindParam(':size', $size, PDO::PARAM_STR); // Adjust the data type if the size should be different.
$stmt->bindParam(':update_by', $current_user, PDO::PARAM_STR);
$stmt->bindParam(':item_id', $p_id, PDO::PARAM_INT);
// Execute the statement and handle success or error
if ($stmt->execute()) {
    // Display success message
    $adduser_process_massae = "Record updated successfully";
    redirectToPage('product_list.php', $adduser_process_massae);
} else {
    // Display error message
    $adduser_process_massae = "Failed to update record";
    redirectToPage('product_list.php', $adduser_process_massae);
}

// Close the statement and database connection
$stmt = null; // Release the statement
$conn = null; // Release the connection

// Function to redirect to a new page with a message as a query parameter
function redirectToPage($page, $message) {
    $url = $page . '?value_emp=' . urlencode($message);
    header("Location: $url");
    exit();
}
?>
