<?php
$item_id = filter_input(INPUT_POST, 'i_id', FILTER_SANITIZE_NUMBER_INT);
$supplier_id = filter_input(INPUT_POST, 'flexRadioDefault', FILTER_SANITIZE_NUMBER_INT);
$p_po_no = filter_input(INPUT_POST, 'pono', FILTER_SANITIZE_STRING);
$item_name = filter_input(INPUT_POST, 'item_name', FILTER_SANITIZE_STRING);
$brand = filter_input(INPUT_POST, 'brand', FILTER_SANITIZE_STRING);
$unit = filter_input(INPUT_POST, 'unit', FILTER_SANITIZE_STRING);
$size = filter_input(INPUT_POST, 'size', FILTER_SANITIZE_STRING);
$price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$quantity = filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_NUMBER_INT);
$profit = filter_input(INPUT_POST, 'profit', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$ad_datetime = filter_input(INPUT_POST, 'item_add_date', FILTER_SANITIZE_STRING);

session_start();

include '../layoutdbconnection.php';

$sql = "INSERT INTO item_purchase (i_id, s_id, p_po_no, p_req_qty, p_unit_price, p_request_datetime, p_purchase_by, p_profit) 
        VALUES (:item_id, :supplier_id, :p_po_no, :quantity, :price, :ad_datetime, :username, :profit)";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);
$stmt->bindParam(':supplier_id', $supplier_id, PDO::PARAM_INT);
$stmt->bindParam(':p_po_no', $p_po_no, PDO::PARAM_STR);
$stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
$stmt->bindParam(':price', $price, PDO::PARAM_STR); // You may need to adjust the data type if necessary
$stmt->bindParam(':ad_datetime', $ad_datetime, PDO::PARAM_STR); // Adjust data type as needed
$stmt->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR);
$stmt->bindParam(':profit', $profit, PDO::PARAM_STR); // Adjust data type as needed



if ($stmt->execute()) {
    // Display success message
    $adduser_process_massae = "Record inserted successfully";
    header("Location: purchase.php?value=" . urlencode($adduser_process_massae));
} else {
    // Display error message
    $adduser_process_massae = "Error";
    header("Location: purchase.php?value=" . urlencode($adduser_process_massae));
}

unset($conn);
exit;
?>
