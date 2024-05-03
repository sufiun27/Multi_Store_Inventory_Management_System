<?php
session_start();

// Validate and sanitize the input
$category = isset($_POST['category_name']) ? $_POST['category_name'] : '';
$datetime = $_SESSION['Asia_Dhaka_time'] ?? '';
$current_user = $_SESSION['username'] ?? '';
$section = $_SESSION['section'] ?? '';

echo "</br> ".$category." - ".$datetime." - ".$current_user."<br>";
// Include the database connection securely
include_once '../layoutdbconnection.php';

// Prepare the SQL statement using prepared statements
$stmt = $conn->prepare("INSERT INTO category_item (c_name, c_add_date_time, c_add_by, section) VALUES (:category, :datetime, :add_by, :section)");

$stmt->bindParam(':category', $category, PDO::PARAM_STR);
$stmt->bindParam(':datetime', $datetime, PDO::PARAM_STR);
$stmt->bindParam(':add_by', $current_user, PDO::PARAM_STR);
$stmt->bindParam(':section', $section, PDO::PARAM_STR);
print_r($stmt);
// Execute the statement and handle success or error
if ($stmt->execute()) {
    $adduser_process_message = "Record inserted successfully";
    redirectToPage('product_add_catagory_1.php', $adduser_process_message);
} else {
    $adduser_process_message = "Duplicate record!";
    redirectToPage('product_add_catagory_1.php', $adduser_process_message);
}

// Close the statement and database connection
$stmt=NULL;
$conn=NULL;

// Function to redirect to a new page with a message as a query parameter
function redirectToPage($page, $message) {
    $url = $page . '?value=' . urlencode($message);
    header("Location: $url");
    exit();
}
?>
