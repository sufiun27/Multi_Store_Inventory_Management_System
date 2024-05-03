<?php
session_start();
include_once '../layoutdbconnection.php';

// Validate and sanitize the input
$p_id = isset($_GET['p_id']) ? $_GET['p_id'] : '';

// Ensure that p_id is a valid integer value
if (!ctype_digit($p_id)) {
    redirectToPage('product_list.php', 'Invalid product ID');
}

// Prepare the SQL statement using prepared statements
$stmt = $conn->prepare("DELETE FROM item WHERE i_id = :item_id");

$stmt->bindParam(':item_id', $p_id, PDO::PARAM_INT);

// Execute the statement and handle success or error
try {
    if ($stmt->execute()) {
        // Display success message
        $adduser_process_massae = "Record deleted successfully";

    } else {
        // Display error message
        $adduser_process_massae = "Failed to delete record";

    }
}catch (mysqli_sql_exception $ex) {
    $adduser_process_massae = "can't delete record - The record is linked";
}
redirectToPage('product_list.php', $adduser_process_massae);
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
