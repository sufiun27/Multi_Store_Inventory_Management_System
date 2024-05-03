<!--### Header Part ##################################################-->
<?php
include '../template/header.php';
?>
<!--#####################################################-->
<style>
    td,th {
        font-size: 12px; /* Increase the font size */
        /* font-weight: bold; Make the text bold */
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Add 'show' class to the element with ID "collapseLayouts2"
    $(document).ready(function() {
        $("#collapseLayouts1").addClass("show");
        $("#collapseLayouts1_stock_out_list").addClass("active bg-success");
    });
</script>



            <div id="layoutSidenav_content">
<!--main content////////////////////////////////////////////////////////////////////////////////-->
                <main>
                    <div class="container-fluid px-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                DataTable Example
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Item Code</th>
                            <th>Item Name</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Size</th>
                            <th>Unit</th>
                            
                            <th>Unit Price</th>
                            <!--<th>Issue Avg Price</th>-->
                            <th>Stock</th>
                            <th>Added DateTime</th>
                            <th>Status</th>
                            
                        </tr>
                        </thead>

                    <tbody>


                    <?php
                        
                        include '../layoutdbconnection.php';   
                        $section = $_SESSION['section'];                  
                        // Fetch company names from the database Full texts	
                        $sql = " SELECT i.i_active, i.i_id,
                        i.i_name, i.i_code, c.c_name, i.i_manufactured_by, 
                        i.i_size, i.i_unit, i.i_price, i.i_add_datetime, 
                        i.i_update_datetime, b.qty_balance, b.item_issue_avg_price ,
                        b.total_item_purchase, b.total_item_issue  
                        from item i 
                        Left JOIN balance b ON i.i_id = b.i_id 
                        INNER JOIN category_item c ON c.c_id = i.c_id
                        WHERE i.section = '$section' AND b.qty_balance < i.stock_out_reminder_qty
                        order by i.i_add_datetime DESC
                        ";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                
                       // if (mysqli_num_rows($result) > 0) {
                            
                            while ($product = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                //echo print_r($product);
                                echo "<tr>";
                                echo "<td>".$product['i_code']."</td>";
                                
                                echo "<td>".$product['i_name']."</td>";

                                echo "<td>".$product['c_name']."</td>";
                                echo "<td>".$product['i_manufactured_by']."</td>";

                                echo "<td>".$product['i_size']."</td>";
                                echo "<td>".$product['i_unit']."</td>";

                                echo "<td>".$product['i_price']."</td>";
                                //echo "<td>".$product['item_issue_avg_price']."</td>";
                                echo "<td>".$product['qty_balance']."</td>";
                                echo "<td>".$product['i_add_datetime']."</td>";
                                if($product["i_active"]==1){ echo '<td class="text-success">
                                    Ok                                   
                                    </td>';}
                                    else{echo '<td class="text-danger">
                                        X                                        
                                        </td>';}
                                echo "
                                
                                </tr>";
                            }
                
                            
                        // }else {
                        //     echo "No records found.";
                        // }
                        ////////////////////////////////////////////////////
                                
                                
                
                        // Close database connection
                       // mysqli_close($conn);
                        ?>
                        
      </tbody>
    </table>

    
                    </div>
                </main>
                
<!--main content//////////////////////////////////////////////////////////////////////////////////-->
<!--###### Footer Part ###############################################-->
<?php
include '../template/footer.php';
?>
<!--#####################################################-->