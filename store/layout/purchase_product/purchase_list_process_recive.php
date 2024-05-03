<?php
session_start();
include '../layoutdbconnection.php';

try {
    // Input validation and sanitization
    $p_id = isset($_GET['p_id']) ? $_GET['p_id'] : '';
    $P_receive_qty = isset($_GET['receive_qty']) ? $_GET['receive_qty'] : '';
    $P_expaired_datetime = isset($_GET['expaired_datetime']) ? $_GET['expaired_datetime'] : '';
    $P_expaired_datetime_string = date('Y-m-d H:i:s', strtotime($P_expaired_datetime)); // Assuming $P_expaired_datetime is in a valid date format
    $p_cash= isset($_GET['cash']) ? $_GET['cash'] : '1';
    // Session handling
    $user = isset($_SESSION['username']) ? $_SESSION['username'] : '';
    date_default_timezone_set('Asia/Dhaka');
    $defaultDateTime = date('Y-m-d H:i:s');

    // Include database connection

    // URLs
    $extra_url = 'store/layout/purchase_product/purchase_list.php';
    $base_url = isset($_SESSION['base_url']) ? $_SESSION['base_url'] : '';

    // Prepare and bind parameters for SQL queries
    $sql = "INSERT INTO tem_purchase_recive (p_id, p_recive_by, p_recive_datetime, p_expaired_datetime, p_recive_qty, p_stock, cash1_creadit0)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $p_id, PDO::PARAM_INT);
    $stmt->bindParam(2, $user, PDO::PARAM_STR);
    $stmt->bindParam(3, $defaultDateTime, PDO::PARAM_STR);
    $stmt->bindParam(4, $P_expaired_datetime_string, PDO::PARAM_STR);
    $stmt->bindParam(5, $P_receive_qty, PDO::PARAM_INT);
    $stmt->bindParam(6, $P_receive_qty, PDO::PARAM_INT);
    $stmt->bindParam(7, $p_cash, PDO::PARAM_INT);

    $sql1 = "UPDATE item_purchase
            SET p_recive = 1
            WHERE p_id = ?";

    $stmt1 = $conn->prepare($sql1);
    $stmt1->bindParam(1, $p_id, PDO::PARAM_INT);

    // Execute the queries and handle success or error
    $conn->beginTransaction(); // Begin a transaction

    if ($stmt->execute() && $stmt1->execute()) {
        $conn->commit(); // Commit the transaction if both queries are successful
        header("Location: http://$base_url/$extra_url");
        exit();
    } else {
        $conn->rollBack(); // Rollback the transaction if any query fails
        header("Location: http://$base_url/$extra_url");
        exit();
    }
} catch (PDOException $e) {
    // Handle any database errors here
    echo "Error: " . $e->getMessage();
}

unset($conn); // Close the database connection
exit;
?>
