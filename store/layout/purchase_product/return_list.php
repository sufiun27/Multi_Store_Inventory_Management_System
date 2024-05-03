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
        $("#collapseLayouts2_return").addClass("active bg-success");
    });
</script>

<div id="layoutSidenav_content">
    <!--view user list -////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

    <main>
        <div class="container-fluid px-4">
           
            <?php
include '../layoutdbconnection.php';
// Fetch company names from the database

$sql = "SELECT * 
FROM item_purchase_return as ir
INNER JOIN item as i ON i.i_id=ir.i_id
INNER JOIN supplier as s ON s.s_id=ir.s_id
 order by return_datetime desc";

try {
    $result = $conn->query($sql);

    if ($result !== false) {
        echo '<div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i> 
                Item Return To Suppliar List 
               </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                    <tr>
                        <th>PO NO</th>
                        <th>Supplier</th>
                        <th>Item</th>
                       
                        <th>P Req Qty</th>
                        <th>P Unit Price</th>
                        <th>p_request_datetime</th>
                        <th>p_purchase_by</th>

                        <th>p_profit</th>
                        <th>p_request</th>
                        <th>p_request_accept_by</th>

                        <th>p_request_unaccept_by</th>
                        <th>p_recive</th>
                        <th>p_request_accept_datetime</th>

                        <th>p_request_unaccept_datetime</th>
                        <th>return_by</th>
                        <th>return_datetime</th>

                        <th>return_reason</th>
                        <th>return_qty</th>
                    </tr>
                </thead>
                <tbody>';

        $count = 0;
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $count++;
            echo '<tr>
                    <td>'.$row["p_po_no"].'</td>
                    <td>'.$row["i_name"].'</td>
                    <td>'.$row["s_name"].'</td>
                    
                    <td>'.$row["p_req_qty"].'</td>
                    <td>'.$row["p_unit_price"].'</td>
                    <td>'.$row["p_request_datetime"].'</td>

                    <td>'.$row["p_purchase_by"].'</td>
                    <td>'.$row["p_profit"].'</td>
                    <td>'.$row["p_request"].'</td>

                    <td>'.$row["p_request_accept_by"].'</td>
                    <td>'.$row["p_request_unaccept_by"].'</td>
                    <td>'.$row["p_recive"].'</td>

                    <td>'.$row["p_request_accept_datetime"].'</td>
                    <td>'.$row["p_request_unaccept_datetime"].'</td>
                    <td>'.$row["return_by"].'</td>

                    <td>'.$row["return_datetime"].'</td>
                    <td>'.$row["return_reason"].'</td>
                    <td>'.$row["return_qty"].'</td>
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
