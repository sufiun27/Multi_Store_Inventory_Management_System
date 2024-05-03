<?php
// Start session
session_start();

// Get the department data
$department_short_name = $_POST['department_short_name'];
$department_full_name = $_POST['department_full_name'];
$depid = $_POST['depid'];
$current_user = $_SESSION['username'];
$time = $_SESSION['Asia_Dhaka_time'];

include '../layoutdbconnection.php';

// Prepare the SQL statement with parameterized query
$stmt = $conn->prepare("UPDATE department SET d_name = :short_name, d_full_name = :full_name, d_update_by = :update_by, d_update_date_time = :update_datetime WHERE d_id = :dep_id");

$stmt->bindParam(':short_name', $department_short_name, PDO::PARAM_STR);
$stmt->bindParam(':full_name', $department_full_name, PDO::PARAM_STR);
$stmt->bindParam(':update_by', $current_user, PDO::PARAM_STR);
$stmt->bindParam(':update_datetime', $time, PDO::PARAM_STR);
$stmt->bindParam(':dep_id', $depid, PDO::PARAM_INT);

if ($stmt->execute()) {
    // Display success message
    $adduser_process_message = "Record updated successfully";

    // Redirect to a new page with the value included as a query parameter
    header("Location: adduser_list_department_edit.php?value_dep=" . urlencode($adduser_process_message) . "&id=" . $depid);
} else {
    // Display error message
    $adduser_process_message = "Error updating the record!";

    // Redirect to a new page with the value included as a query parameter
    header("Location: adduser_list_department_edit.php?value_dep=" . urlencode($adduser_process_message) . "&id=" . $depid);
}

// Close the statement and database connection
$stmt->close();
$conn->close();
?>
