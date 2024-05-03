<?php
session_start();
$item_po_no=filter_input(INPUT_POST, 'item_po_no', FILTER_SANITIZE_STRING);
$item_id = filter_input(INPUT_POST, 'i_id', FILTER_VALIDATE_INT);
/////////////////////////////////
// $emp_id_combine = filter_input(INPUT_POST, 'flexRadioDefault', FILTER_SANITIZE_STRING);
// $values = explode(',', $emp_id_combine);

$emp_id = $_POST['e_id'];
$emp_dep = filter_input(INPUT_POST, 'd_name', FILTER_SANITIZE_STRING);
// $emp_id = isset($values[0]) ? $values[0] : null;
// $emp_dep = isset($values[1]) ? $values[1] : null;
//////////////////////////
$real_price = filter_input(INPUT_POST, 'real_price', FILTER_VALIDATE_FLOAT);
$avg_price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
$quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);
$profit = filter_input(INPUT_POST, 'profit', FILTER_VALIDATE_FLOAT);
$ad_datetime = filter_input(INPUT_POST, 'item_add_date', FILTER_SANITIZE_STRING);
$user = $_SESSION['username'];
$issueArray=$_POST['issueArray'];

// Validate the filtered inputs
if ($item_id === null || $emp_id === null || $emp_dep === null || $real_price === false || $avg_price === false || $quantity === false || $profit === false || $ad_datetime === null || $user === null) {
    // Display error message or handle the validation failure
    $adduser_process_message = "Invalid input data";
    // Redirect to a new page with the value included as a query parameter
    header("Location: issue.php?value=" . urlencode($adduser_process_message));
    exit;
}

include '../layoutdbconnection.php';

//echo "item_po_no: " . $item_po_no . "<br>";
//echo "item_id: " . $item_id . "<br>";
//echo "emp_id_combine: " . $emp_id_combine . "<br>";
//echo "emp_id: " . $emp_id . "<br>";
//echo "emp_dep: " . $emp_dep . "<br>";
//echo "real_price: " . $real_price . "<br>";
//echo "avg_price: " . $avg_price . "<br>";
//echo "quantity: " . $quantity . "<br>";
//echo "profit: " . $profit . "<br>";
//echo "ad_datetime: " . $ad_datetime . "<br>";
//echo "user: " . $user . "<br>";
//echo "issueArray: " . print_r($issueArray, true) . "<br>";






$stmt = $conn->prepare("INSERT INTO item_issue (is_po_no, is_datetime, i_id, is_qty, i_price, e_id, emp_dep, is_item_issue_by, is_avg_price, is_profit)
VALUES (:item_po_no, :ad_datetime, :item_id, :quantity, :real_price, :emp_id, :emp_dep, :user, :avg_price, :profit)");

$stmt->bindParam(':item_po_no', $item_po_no, PDO::PARAM_STR);//p_po_NO
$stmt->bindParam(':ad_datetime', $ad_datetime, PDO::PARAM_STR); // Assuming $ad_datetime is a string, adjust the data type if needed
$stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);//I_ID
$stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
$stmt->bindParam(':real_price', $real_price, PDO::PARAM_STR); // Adjust data type if needed
$stmt->bindParam(':emp_id', $emp_id, PDO::PARAM_INT);
$stmt->bindParam(':emp_dep', $emp_dep, PDO::PARAM_STR);
$stmt->bindParam(':user', $user, PDO::PARAM_STR);
$stmt->bindParam(':avg_price', $avg_price, PDO::PARAM_STR); // Adjust data type if needed
$stmt->bindParam(':profit', $profit, PDO::PARAM_STR); // Adjust data type if needed

if ($stmt->execute()) {
    
    $sql_is_id = "SELECT TOP 1 is_id FROM item_issue WHERE is_po_no='$item_po_no' ORDER BY is_id DESC";

    $result=$conn->query($sql_is_id) ;
    $row=$result->fetch(PDO::FETCH_ASSOC);

    $is_id=$row['is_id']; //issue id
///__Start insert into item issue trac__//////////////////////////////////////////////////
/// ///////////////////////////////////////////////////////
    // Ensure $issueArray is a valid JSON string and decode it into an array
    $issueArray = json_decode($issueArray, true);

// Check if decoding was successful and if the decoded data is an array
    if (is_array($issueArray) && !empty($issueArray)) {
        foreach ($issueArray as $issueData) {
            // Ensure that the array element has the required keys
            if (isset($issueData['r_id']) && isset($issueData['p_stock']) && isset($issueData['p_unit_price'])) {
                // Escape values to prevent SQL injection
                $r_id = $issueData['r_id'];
                $p_stock = $issueData['p_stock'];
                $p_unit_price = $issueData['p_unit_price'];
                $count=0;
                $count++;
                echo"$count is_id= $is_id - r_id= $r_id - p_stock= $p_stock - p_unit_price= $p_unit_price <br>";
                $sql = "INSERT INTO item_issue_trac (is_id, r_id, ist_qty, ist_price) 
                    VALUES ('$is_id', '$r_id', '$p_stock', '$p_unit_price')";

                if ($conn->query($sql) === TRUE) {
                  //  echo "issue Record inserted successfully.";
                } else {
                  //  echo "issue Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
              // echo "issue Error: Invalid array element.";
            }
        }
    } else {
        //echo "issue Error: Invalid or empty issueArray.";
    }
///__ close insert into item issue trac__//////////////////////////////////////////////////////

///__start tem purchase recive __ track update__/////////////////////////////////////////////////
// Check if decoding was successful and if the decoded data is an array
    if (is_array($issueArray) && !empty($issueArray)) {
        foreach ($issueArray as $issueData) {
            // Ensure that the array element has the required keys
            if (isset($issueData['r_id']) && isset($issueData['p_stock']) ) {
                // Escape values to prevent SQL injection
                $r_id = $issueData['r_id'];
                $p_stock = $issueData['p_stock'];

                ///tem st0ck = item recive - issue qty
                $sql1="SELECT p_stock FROM tem_purchase_recive WHERE r_id='$r_id'";
                $result1 = $conn->query($sql1);
                $row = $result1->fetch(PDO::FETCH_ASSOC);
                $p_stock_tem_purchase_recive = $row['p_stock'];
                $count=0;
                $count++;
                //echo "$count - p_stock_tem_purchase_recive:$p_stock_tem_purchase_recive = row['p_recive_qty']: {$row['p_recive_qty']}; <br>";
                $qty=$p_stock_tem_purchase_recive -$p_stock;
               // echo " qty $qty= p_stock_tem_purchase_recive: $p_stock_tem_purchase_recive - p_stock: $p_stock <br>";
                //echo "$qty<br>";
                // Update query to modify existing records based on r_id
                $sql = "UPDATE tem_purchase_recive
                    SET 
                        p_stock = '$qty'
                        
                    WHERE r_id = '$r_id'";

                if ($conn->query($sql) === TRUE) {
                   // echo "stock update Record updated successfully.";
                } else {
                   // echo "stock update Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
               // echo "stock Error: Invalid array element.";
            }
        }
    } else {
       // echo "stock Error: Invalid or empty issueArray.";
    }
///__Close start tem purchase recive __ track update__/////////////////////////////////////////////////
    // Display success message
    // $item_po_no
    // $emp_id

    $adduser_process_message = "Issue successfully";
    // Redirect to a new page with the value included as a query parameter
    header("Location: issue_process1.php?value=" . urlencode($adduser_process_message) . "&item_po_no=" . urlencode($item_po_no) . "&id=" . urlencode($emp_id));
} else {
   // echo "Error: " . $stmt->error;
    // Display error message
    $adduser_process_message = "Error";
    // Redirect to a new page with the value included as a query parameter
    header("Location: issue_process1.php?value=" . urlencode($adduser_process_message) . "&item_po_no=" . urlencode($item_po_no) . "&id=" . urlencode($emp_id));
}

// Close the statement and database connection
 unset($conn);
    exit;
?>
