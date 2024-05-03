<?php
// Start session
session_start();

include '../layoutdbconnection.php';

$dep_main_id = $_GET['id'];
$emp_update_by = $_SESSION['username'];

// Prepare the SQL statement with parameterized query
$stmt = $conn->prepare("UPDATE department SET d_active = :active, d_inactive_datetime = :inactive_datetime, d_inactive_by = :inactive_by WHERE d_id = :dep_id");

$stmt->bindParam(':active', $active, PDO::PARAM_INT);
$stmt->bindParam(':inactive_datetime', $defaultDateTime, PDO::PARAM_STR);
$stmt->bindParam(':inactive_by', $emp_update_by, PDO::PARAM_STR);
$stmt->bindParam(':dep_id', $dep_main_id, PDO::PARAM_INT);

$active = 0;
$defaultDateTime = date('Y-m-d H:i:s');


if ($stmt->execute()) {
    // Display success message
    $adduser_process_message = "Update successfully";

    // Redirect to a new page with the value included as a query parameter
    header("Location: adduser_Department_list.php?value=" . urlencode($adduser_process_message));
} else {
    // Display error message
    $adduser_process_message = "Error updating the record!";

    // Redirect to a new page with the value included as a query parameter
    header("Location: adduser_Department_list.php?value=" . urlencode($adduser_process_message));
}

// Close the statement and database connection
$stmt->close();
$conn->close();
?>
