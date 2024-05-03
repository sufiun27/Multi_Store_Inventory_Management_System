<?php
session_start();

// Include the hostingDBinfo.php file for connection details
include('../../../hostingDBinfo.php');

$user_name = $_SESSION['username'];
$user_company = $_SESSION['company'];
$user_role = $_SESSION['role'];

$database = $user_company;

try {
    $serverName = $servername;
    $connectionOptions = array(
        "Database" => $database,
        "Uid" => 'sa',
        "PWD" => 'sa@123'
    );

    $conn = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Input validation and sanitization
    $emp_main_id = isset($_GET['id']) ? $_GET['id'] : '';
    $emp_update_by = isset($_SESSION['username']) ? $_SESSION['username'] : '';

    // Ensure that the values are properly sanitized and cast to the expected data types
    $emp_main_id = is_numeric($emp_main_id) ? (int)$emp_main_id : 0;
    $emp_update_by = is_string($emp_update_by) ? $emp_update_by : '';

    date_default_timezone_set('Asia/Dhaka');
    $defaultDateTime = date('Y-m-d H:i:s');

    $active = 0;

    // Prepare and bind parameters for SQL query
    $sql = "UPDATE supplier SET 
            s_active = ?,
            s_inactive_datetime = ?,
            s_inactive_by = ?
            WHERE s_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $active, PDO::PARAM_INT);
    $stmt->bindParam(2, $defaultDateTime, PDO::PARAM_STR);
    $stmt->bindParam(3, $emp_update_by, PDO::PARAM_STR);
    $stmt->bindParam(4, $emp_main_id, PDO::PARAM_INT);

    // Execute the query and handle success or error
    if ($stmt->execute()) {
        // Display success message
        $adduser_process_massae = "Update successfully";

        // Redirect to a new page with the value included as a query parameter
        header("Location: supplier_search.php?value=" . urlencode($adduser_process_massae) . "&id=" . urlencode($emp_main_id));
        exit();
    } else {
        // Display error message
        $adduser_process_massae = "Don't found employee!";

        // Redirect to a new page with the value included as a query parameter
        header("Location: supplier_search.php?value=" . urlencode($adduser_process_massae));
        exit();
    }

    // Close the database connection
    $conn = null;
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
