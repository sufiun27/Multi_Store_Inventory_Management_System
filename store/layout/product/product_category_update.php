<?php
session_start();

// Validate and sanitize the input
$c_id = $_POST['c_id'] ?? '';
$c_name = $_POST['c_name'] ?? '';

// Ensure that c_id is a valid integer value
if (!ctype_digit($c_id)) {
    redirectToPage('product_category_edit.php', 'Invalid category ID');
}

$current_user = $_SESSION['username'] ?? '';
$time = $_SESSION['Asia_Dhaka_time'] ?? '';

include_once '../layoutdbconnection.php';

// Filter input to prevent SQL injection
//$c_name = $conn->real_escape_string($c_name);

// Prepare the SQL statement using prepared statements
$stmt = $conn->prepare("UPDATE category_item SET c_name = :c_name, c_update_by = :c_update_by, c_update_datetime = :c_update_datetime WHERE c_id = :c_id");

$stmt->bindParam(':c_name', $c_name, PDO::PARAM_STR);
$stmt->bindParam(':c_update_by', $current_user, PDO::PARAM_STR);
$stmt->bindParam(':c_update_datetime', $time, PDO::PARAM_STR);
$stmt->bindParam(':c_id', $c_id, PDO::PARAM_INT);

// Execute the statement and handle success or error
if ($stmt->execute()) {
    // Display success message
    $adduser_process_massae = "Record update successfully";
    redirectToPage('product_category_edit.php', $adduser_process_massae, $c_id);
} else {
    // Display error message
    $adduser_process_massae = "ERROR!";
    // echo $conn->error;
    redirectToPage('product_category_edit.php', $adduser_process_massae);
}

// Close the statement and database connection
$stmt->close();
$conn->close();

// Function to redirect to a new page with query parameters
function redirectToPage($page, $message, $id = '') {
    $url = $page . '?value_dep=' . urlencode($message);
    if ($id) {
        $url .= '&id=' . $id;
    }
    header("Location: $url");
    exit();
}
?>
