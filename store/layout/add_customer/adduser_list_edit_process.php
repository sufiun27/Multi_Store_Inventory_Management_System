<?php
session_start();
include '../layoutdbconnection.php';

// Validate and sanitize input
$emp_name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$emp_id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
$emp_designation = filter_input(INPUT_POST, 'designation', FILTER_SANITIZE_STRING);
$emp_department_id = filter_input(INPUT_POST, 'department', FILTER_VALIDATE_INT);
$emp_main_id = filter_input(INPUT_POST, 'e_id', FILTER_VALIDATE_INT);
$emp_update_by = $_SESSION['username'];
$mn=$_POST['mn'];

if ($emp_name === null || $emp_id === null || $emp_designation === null || $emp_department_id === false || $emp_main_id === false || $emp_update_by === null) {
    // Invalid input, handle error
    header("Location: adduser_list_edit.php?value=" . urlencode("Invalid input."));
    exit;
}

// Prepare the SQL statement using parameterized query
$stmt = $conn->prepare("UPDATE employee SET e_com_id = :com_id, e_name = :name, d_id = :department_id, e_designation = :designation, e_update_date_time = :update_datetime, e_update_by = :update_by, user_type =:mn WHERE e_id = :emp_id");

$stmt->bindParam(':com_id', $emp_id, PDO::PARAM_INT);
$stmt->bindParam(':name', $emp_name, PDO::PARAM_STR);
$stmt->bindParam(':department_id', $emp_department_id, PDO::PARAM_INT);
$stmt->bindParam(':designation', $emp_designation, PDO::PARAM_STR);
$stmt->bindParam(':update_datetime', $defaultDateTime, PDO::PARAM_STR);
$stmt->bindParam(':update_by', $emp_update_by, PDO::PARAM_STR);
$stmt->bindParam(':emp_id', $emp_main_id, PDO::PARAM_INT);
$stmt->bindParam(':mn', $mn, PDO::PARAM_STR);

date_default_timezone_set('Asia/Dhaka');
$defaultDateTime = date('Y-m-d H:i:s');

// Execute the prepared statement
if ($stmt->execute()) {
    // Display success message
    $adduser_process_massae = "Update successfully";
    // Redirect to a new page with the value included as a query parameter
    header("Location: adduser_list_edit.php?value=" . urlencode($adduser_process_massae) . "&id=" . urlencode($emp_main_id));
} else {
    // Display error message
    $adduser_process_massae = "Failed to update.";
    // Redirect to a new page with the value included as a query parameter
    header("Location: adduser_list_edit.php?value=" . urlencode($adduser_process_massae));
}

// Close the prepared statement and database connection
$stmt=NULL;
$conn=NULL;
?>
