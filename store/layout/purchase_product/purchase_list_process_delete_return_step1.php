<?php
$p_is = $_GET['p_id'];

?>
<!--### Header Part ##################################################-->
<?php
include '../template/header.php';
?>
<style>
    td,th {
        font-size: 10px; /* Increase the font size */
         /* Make the text bold */
    }
    th{
        font-weight: bold;
    }
</style>

<!--#####################################################-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Add 'show' class to the element with ID "collapseLayouts2"
    $(document).ready(function() {
        $("#collapseLayouts2").addClass("show");
        $("#collapseLayouts2_list").addClass("active bg-success");
    });
</script>

<div id="layoutSidenav_content">
    <!--view user list -////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

    <main>
        <div class="container-fluid px-4">
            <h4 class="bg-success text-light p-1"><?php if(isset($_GET['value'])){echo $_GET['value'];} else{echo "";}?></h4>
            <?php
include '../layoutdbconnection.php';
// Fetch company names from the database
$sql="SELECT COALESCE(COUNT(po_qty), 0) AS total_po_qty
FROM (
    SELECT DISTINCT iss.is_po_no as po_qty
    FROM item_issue AS iss 
    INNER JOIN item AS i ON iss.i_id = i.i_id
    INNER JOIN employee AS e ON e.e_id = iss.e_id
    INNER JOIN item_issue_trac AS ist ON ist.is_id = iss.is_id
    INNER JOIN tem_purchase_recive AS ir ON ir.r_id = ist.r_id
    INNER JOIN item_purchase AS ip ON ip.p_id = ir.p_id
    WHERE ip.p_id = $p_is
) AS subquery_alias;";
$result = $conn->query($sql);
$row = $result->fetch(PDO::FETCH_ASSOC);
$total_po_qty = $row['total_po_qty'];


$sql = "SELECT DISTINCT iss.is_po_no, e.e_name, e.e_com_id, i.i_name, iss.is_qty
FROM item_issue AS iss 
INNER JOIN item AS i ON iss.i_id = i.i_id
INNER JOIN employee AS e ON e.e_id = iss.e_id
INNER JOIN item_issue_trac AS ist ON ist.is_id = iss.is_id
INNER JOIN tem_purchase_recive AS ir ON ir.r_id = ist.r_id
INNER JOIN item_purchase AS ip ON ip.p_id = ir.p_id
WHERE ip.p_id = $p_is; ";

try {
    $result = $conn->query($sql);

    if ($result !== false) {
        echo '<div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i> 
                <span>Need to return those '.$total_po_qty.' item first</span>';
                 if ($total_po_qty==0) {
                     echo '<a href="purchase_list_process_delete_return_step2.php?p_id='.$p_is.'" class="btn btn-danger float-end">Return To Supplier</a>';
                 }
               
            echo '</div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                    <tr>
                        <th>PO NO</th>
                        <th>ID</th>
                        <th>Employee</th> 
                        <th>Item</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>';

        $count = 0;
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $count++;
            echo '<tr>
                    <td>'.$row["is_po_no"].'</td>
                    <td>'.$row["e_com_id"].'</td>
                    <td>'.$row["e_name"].'</td>
                    <td>'.$row["i_name"].'</td>
                    <td>'.$row["is_qty"].'</td>
                    ';
              echo'</tr>';
        }

        echo '</tbody> </table>';
    } else {
        echo "No records found.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close database connection
$conn = null;
?>








        </div>
    </main>
    <!--end view user list -////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

    <!--###### Footer Part ###############################################-->
    <?php
    include '../template/footer.php';
    ?>
    <!--#####################################################-->

    <style>
        /* Reduce row spacing */


        /* Apply styles to every second row */
        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</div>
