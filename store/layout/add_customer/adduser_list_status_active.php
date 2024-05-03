<?php
session_start();
include '../layoutdbconnection.php';

$emp_main_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$emp_update_by = $_SESSION['username'];

if ($emp_main_id === false || $emp_update_by === null) {
    // Invalid input, handle error
    header("Location: adduser_list.php?value=" . urlencode("Invalid input."));
    exit;
}

$stmt = $conn->prepare("UPDATE employee SET e_active = :active, e_update_date_time = :update_datetime, e_update_by = :update_by WHERE e_id = :emp_id");

$stmt->bindParam(':active', $active, PDO::PARAM_INT);
$stmt->bindParam(':update_datetime', $defaultDateTime, PDO::PARAM_STR);
$stmt->bindParam(':update_by', $emp_update_by, PDO::PARAM_STR);
$stmt->bindParam(':emp_id', $emp_main_id, PDO::PARAM_INT);

date_default_timezone_set('Asia/Dhaka');
$defaultDateTime = date('Y-m-d H:i:s');
$active = 1;

if ($stmt->execute()) {
    // Display success message
    $adduser_process_massae = "Update successfully";
    // Redirect to a new page with the value included as a query parameter
    header("Location: adduser_list.php?value=" . urlencode($adduser_process_massae) . "&id=" . urlencode($emp_main_id));
} else {
    // Display error message
    $adduser_process_massae = "Failed to update.";
    // Redirect to a new page with the value included as a query parameter
    header("Location: adduser_list.php?value=" . urlencode($adduser_process_massae));
}

$stmt->close();
$conn->close();
?>
