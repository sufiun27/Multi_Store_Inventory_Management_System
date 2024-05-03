<?php
// Start session
session_start();

$emp_id = $_GET['id'];

include '../layoutdbconnection.php';

// Prepare the SQL statement with parameterized query
$stmt = $conn->prepare("DELETE FROM employee WHERE e_id = :emp_id");

$stmt->bindParam(':emp_id', $emp_id, PDO::PARAM_STR);

try {
    if ($stmt->execute()) {
        // Display success message
        $adduser_process_message = "Record deleted successfully";

        // Redirect to a new page with the value included as a query parameter
        header("Location: adduser_list.php?value=" . urlencode($adduser_process_message));
    } else {
        // Display error message
        $adduser_process_message = "Error deleting the record!";
        header("Location: adduser_list.php?value=" . urlencode($adduser_process_message));
    }
} catch (mysqli_sql_exception $ex) {
    // Check if the error message contains the specific text
    $error_message = $ex->getMessage();
    if (strpos($error_message, "Cannot delete employee. References exist in item_issue table") !== false) {
        // Handle the specific error
        $adduser_process_message = "Cannot delete employee. References exist .";
        header("Location: adduser_list.php?value=" . urlencode($adduser_process_message));
    } else {
        // Display a general error message
        $adduser_process_message = "Error deleting the record!";
        header("Location: adduser_list.php?value=" . urlencode($adduser_process_message));
    }
}

// Close the statement and database connection
$stmt->close();
$conn->close();
?>
