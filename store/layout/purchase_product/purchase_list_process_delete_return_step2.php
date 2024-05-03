<?php
$p_is = $_GET['p_id'];
// echo $p_is;


session_start();
$user=$_SESSION['username'];

include '../layoutdbconnection.php';
try {
// Fetch company names from the database
$sql = "SELECT COALESCE(COUNT(iss.is_po_no), 0) AS total_po_qty
        FROM item_issue AS iss 
        INNER JOIN item AS i ON iss.i_id = i.i_id
        INNER JOIN employee AS e ON e.e_id = iss.e_id
        INNER JOIN item_issue_trac AS ist ON ist.is_id = iss.is_id
        INNER JOIN tem_purchase_recive AS ir ON ir.r_id = ist.r_id
        INNER JOIN item_purchase AS ip ON ip.p_id = ir.p_id
        WHERE ip.p_id = :p_id";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':p_id', $p_is, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$total_po_qty = $row['total_po_qty'];

if ($total_po_qty == 0) {
    $insertSql = "INSERT INTO item_purchase_return
                  ([i_id], [s_id], [p_req_qty], [p_unit_price], [p_request_datetime], [p_purchase_by],
                   [p_profit], [p_request], [p_request_accept_by], [p_request_unaccept_by],
                   [p_recive], [p_request_accept_datetime], [p_request_unaccept_datetime],
                   [p_po_no], [return_by], [return_datetime], [return_reason], [return_qty])
                  SELECT
                  [i_id], [s_id], [p_req_qty], [p_unit_price], [p_request_datetime], [p_purchase_by],
                  [p_profit], [p_request], [p_request_accept_by], [p_request_unaccept_by],
                  [p_recive], [p_request_accept_datetime], [p_request_unaccept_datetime],
                  [p_po_no], '$user', GETDATE(), 'reason', sub.TotalReceivedQuantity	 
                  FROM item_purchase
                  INNER JOIN (
                      SELECT SUM(ir.p_recive_qty) AS TotalReceivedQuantity, ip.p_id
                      FROM tem_purchase_recive AS ir
                      INNER JOIN item_purchase AS ip ON ir.p_id = ip.p_id
                      GROUP BY ip.p_id
                  ) as sub ON sub.p_id = item_purchase.p_id
                  WHERE item_purchase.p_id=:p_id";

    $stmt = $conn->prepare($insertSql);
    $stmt->bindParam(':p_id', $p_is, PDO::PARAM_INT);
    $stmt->execute();

    $deleteSql1 = "DELETE FROM tem_purchase_recive WHERE p_id = :p_id";
    $stmt = $conn->prepare($deleteSql1);
    $stmt->bindParam(':p_id', $p_is, PDO::PARAM_INT);
    $stmt->execute();

    $deleteSql2 = "DELETE FROM item_purchase WHERE p_id = :p_id";
    $stmt = $conn->prepare($deleteSql2);
    $stmt->bindParam(':p_id', $p_is, PDO::PARAM_INT);
    $stmt->execute();

    header("Location:purchase_list.php");
    
}
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}