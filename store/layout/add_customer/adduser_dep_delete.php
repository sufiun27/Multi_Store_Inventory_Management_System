<?php
// Start session
session_start();

// Get the current user and other required data
$current_user = $_SESSION['username'];
$time = $_SESSION['Asia_Dhaka_time'];
$depid = $_GET['id'];

include '../layoutdbconnection.php';

// Check if there are associated employees
$stmt_check = $conn->prepare("SELECT COUNT(*) FROM employee WHERE d_id = :dep_id");
$stmt_check->bindParam(':dep_id', $depid, PDO::PARAM_INT);
$stmt_check->execute();

$employee_count = $stmt_check->fetchColumn();

if ($employee_count > 0) {
    // Display error message
    $adduser_process_message = "Cannot delete this department as it has associated employees";
    header("Location: adduser_Department_list.php?massage=" . urlencode($adduser_process_message));
} else {
    // Prepare the SQL statement for deletion
    $stmt = $conn->prepare("DELETE FROM department WHERE d_id = :dep_id");
    $stmt->bindParam(':dep_id', $depid, PDO::PARAM_INT);

    try {
        if ($stmt->execute()) {
            // Display success message
            $adduser_process_message = "Record deleted successfully";
            header("Location: adduser_Department_list.php");
        } else {
            // Display a general error message
            $adduser_process_message = "Error deleting the record!";
            header("Location: adduser_Department_list.php?massage=" . urlencode($adduser_process_message));
        }
    } catch (PDOException $ex) {
        // Display a general error message
        $adduser_process_message = "Error deleting the record!";
        header("Location: adduser_Department_list.php?massage=" . urlencode($adduser_process_message));
    }

    // Close the statement and database connection
    $stmt->close();
}

// Close the statement and database connection
$stmt_check->close();
$conn->close();
?>
