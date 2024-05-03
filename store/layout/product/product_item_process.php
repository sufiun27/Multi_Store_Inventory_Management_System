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
$section=$_SESSION['section'] ;


// Prepare the SQL statement using prepared statements
$stmt = $conn->prepare("INSERT INTO item (i_name, i_code, i_manufactured_by, i_add_datetime, c_id, i_unit, i_price, stock_out_reminder_qty, i_size, i_add_by, section) 
        VALUES (:item_name, :item_code, :brand, :item_add_date, :cataggory, :unit, :price, :stock_out_reminder_qty, :size, :current_user, :section)");

$stmt->bindParam(':item_name', $item_name, PDO::PARAM_STR);
$stmt->bindParam(':item_code', $item_code, PDO::PARAM_STR);
$stmt->bindParam(':brand', $brand, PDO::PARAM_STR);
$stmt->bindParam(':item_add_date', $item_add_date, PDO::PARAM_STR); // You should ensure that $item_add_date is correctly formatted as a date/time string.
$stmt->bindParam(':cataggory', $cataggory, PDO::PARAM_STR); // I noticed a typo in the variable name, you might want to fix it to match your actual variable name.
$stmt->bindParam(':unit', $unit, PDO::PARAM_STR);
$stmt->bindParam(':price', $price, PDO::PARAM_STR); // Adjust the data type if the price should be a different type (e.g., PDO::PARAM_INT).
$stmt->bindParam(':stock_out_reminder_qty', $stock_out_reminder_qty, PDO::PARAM_STR); // Adjust the data type if it's not a string.
$stmt->bindParam(':size', $size, PDO::PARAM_STR); // Adjust the data type if the size should be a different type.
$stmt->bindParam(':current_user', $current_user, PDO::PARAM_STR);
$stmt->bindParam(':section', $section, PDO::PARAM_STR);


// Execute the statement and handle success or error
if ($stmt->execute()) {
    // Display success message
    $adduser_process_massae = "Record inserted successfully";
    redirectToPage('product_add.php', $adduser_process_massae);
} else {
    // Display error message
    $adduser_process_massae = "Duplicate record!";
    redirectToPage('product_add.php', $adduser_process_massae);
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
