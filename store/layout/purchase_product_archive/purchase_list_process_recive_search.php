<?php
session_start();
include '../layoutdbconnection.php';

// Input validation and sanitization
$p_id = isset($_GET['p_id']) ? $_GET['p_id'] : '';
$P_receive_qty = isset($_GET['receive_qty']) ? $_GET['receive_qty'] : '';
$P_expaired_datetime = isset($_GET['expaired_datetime']) ? $_GET['expaired_datetime'] : '';

// Session handling
$user = isset($_SESSION['username']) ? $_SESSION['username'] : '';
date_default_timezone_set('Asia/Dhaka');
$defaultDateTime = date('Y-m-d H:i:s');

// Include database connection

// URLs
$extra_url = 'store/layout/purchase_product/purchase_list.php';
$base_url = isset($_SESSION['base_url']) ? $_SESSION['base_url'] : '';

// Prepare and bind parameters for SQL queries
$sql = "INSERT INTO tem_purchase_recive (p_id, p_recive_by, p_recive_datetime, p_expaired_datetime, p_recive_qty, p_stock)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bindParam(1, $p_id, PDO::PARAM_INT);
$stmt->bindParam(2, $user, PDO::PARAM_STR);
$stmt->bindParam(3, $defaultDateTime, PDO::PARAM_STR);
$stmt->bindParam(4, $P_expaired_datetime, PDO::PARAM_STR);
$stmt->bindParam(5, $P_receive_qty, PDO::PARAM_INT);
$stmt->bindParam(6, $P_receive_qty, PDO::PARAM_INT);

$sql1 = "UPDATE item_purchase
        SET p_recive = 1
        WHERE p_id = ?";

$stmt1 = $conn->prepare($sql1);
$stmt1->bindParam(1, $p_id, PDO::PARAM_INT);

// Execute the queries and handle success or error
if ($stmt->execute() && $stmt1->execute()) {

    echo "if done";
    // Redirect to a new page with the value included as a query parameter
   // header("Location: http://$base_url/$extra_url");
    //exit();
} else {
    echo "else done";
    // Redirect to a new page with the value included as a query parameter
   // header("Location: http://$base_url/$extra_url");
   // exit();
}

unset($conn);
exit;
// Close the database connection
?>
