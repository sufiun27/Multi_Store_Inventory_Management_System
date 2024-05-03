<?php
// Start session
session_start();

// Get the department data
$department_short_name = $_POST['department_short_name'];
$department_full_name = $_POST['department_full_name'];
$current_user = $_SESSION['username'];
$time = $_SESSION['Asia_Dhaka_time'];

include '../layoutdbconnection.php';

// Prepare the SQL statement with named placeholders
$stmt = $conn->prepare("INSERT INTO department (d_name, d_full_name, d_add_by, d_add_date_time) 
VALUES (:d_name, :d_full_name, :d_add_by, :d_add_date_time)");

// Bind parameters using named placeholders
$stmt->bindParam(':d_name', $department_short_name, PDO::PARAM_STR);
$stmt->bindParam(':d_full_name', $department_full_name, PDO::PARAM_STR);
$stmt->bindParam(':d_add_by', $current_user, PDO::PARAM_STR);
$stmt->bindParam(':d_add_date_time', $time, PDO::PARAM_STR);

if ($stmt->execute()) {
    // Display success message
    $adduser_process_message = "Record inserted successfully";

    // Redirect to a new page with the value included as a query parameter
    header("Location: adddepartment.php?value_dep=" . urlencode($adduser_process_message));
} else {
    if ($stmt->errorCode() == 23000) {
        // Display error message for duplicate record
        $adduser_process_message = "Duplicate record!";
    } else {
        // Display generic error message
        $adduser_process_message = "Error inserting the record!";
    }

    // Redirect to a new page with the value included as a query parameter
    header("Location: adddepartment.php?value_dep=" . urlencode($adduser_process_message));
}

// Close the statement and database connection
$stmt = null; // Release the statement resources
$conn = null;  // Close the database connection
?>
