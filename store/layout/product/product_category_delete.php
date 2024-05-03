<?php
session_start();

// Function to redirect to a new page with query parameters
function redirectToPage($page, $message, $id, $errorMessage = '') {
    $url = $page . '?value=' . urlencode($message) . '&id=' . $id;
    if ($errorMessage) {
        $url .= '&message=' . urlencode($errorMessage);
    }
    header("Location: $url");
    exit();
}

// Validate and sanitize the input
$c_id = isset($_GET['id']) ? $_GET['id'] : '';

// Ensure that c_id is a valid integer value
if (!ctype_digit($c_id)) {
    redirectToPage('product_category.php', 'Invalid category ID');
}

$current_user = $_SESSION['username'] ?? '';
$time = $_SESSION['Asia_Dhaka_time'] ?? '';

include_once '../layoutdbconnection.php';

try {
    // Prepare the SQL statement using prepared statements
    $stmt = $conn->prepare("DELETE FROM category_item WHERE c_id = :c_id");
    $stmt->bindParam(':c_id', $c_id, PDO::PARAM_INT);

    // Execute the statement
    if ($stmt->execute()) {
        // Display success message
        $adduser_process_message = "Deleted successfully";
        redirectToPage('product_category.php', $adduser_process_message, $c_id);
    } else {
        // Check if the category has items
        $errorMessage = $stmt->errorInfo()[2];
        if (strpos($errorMessage, 'Cannot delete or update a parent row') !== false) {
            $errorMessage = "Can't delete category because it has items";
        }
        redirectToPage('product_category.php', "Can't proceed", $c_id, $errorMessage);
    }
} catch (PDOException $ex) {
    // Handle database errors
    $errorMessage = "Can't Delete";
    redirectToPage('product_category.php', "Can't proceed", $c_id, $ex->getMessage());
} finally {
    // Close the statement and database connection
    if (isset($stmt)) {
        $stmt->closeCursor();
    }
    if (isset($conn)) {
        $conn = null;
    }
}
