<?php
// Start session
session_start();

$emp_name = $_POST['name'];
$mn=$_POST['mn'];
$emp_id = $_POST['id'];
$emp_designation = $_POST['designation'];
$emp_department_id = $_POST['department'];
$emp_add_datetime = $_POST['emp_add_datetime'];
$emp_add_by = $_POST['emp_add_by'];

include '../layoutdbconnection.php';

// Prepare the SQL statement with named parameters using PDO
$sql = "INSERT INTO employee (e_com_id, e_name, d_id, e_designation, e_add_date_time, e_add_by, user_type) 
VALUES (:emp_id, :emp_name, :emp_department_id, :emp_designation, :emp_add_datetime, :emp_add_by, :mn)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error in SQL statement: " . $conn->errorInfo());
}

// Bind parameters
$stmt->bindParam(':emp_id', $emp_id, PDO::PARAM_STR);
$stmt->bindParam(':emp_name', $emp_name, PDO::PARAM_STR);
$stmt->bindParam(':emp_department_id', $emp_department_id, PDO::PARAM_INT);
$stmt->bindParam(':emp_designation', $emp_designation, PDO::PARAM_STR);
$stmt->bindParam(':emp_add_datetime', $emp_add_datetime, PDO::PARAM_STR);
$stmt->bindParam(':emp_add_by', $emp_add_by, PDO::PARAM_STR);
$stmt->bindParam(':mn', $mn, PDO::PARAM_STR);

// Execute the prepared statement
if ($stmt->execute()) {
    // Display success message
    $adduser_process_message = "Record inserted successfully";

    // Redirect to a new page with the value included as a query parameter
    header("Location: adduser.php?value=" . urlencode($adduser_process_message));
} else {
    // Display error message
    $adduser_process_message = "Duplicate record or error occurred!";

    // Redirect to a new page with the value included as a query parameter
    header("Location: adduser.php?value=" . urlencode($adduser_process_message));
}

// Close the statement and database connection
$stmt = null;
$conn = null;
?>
