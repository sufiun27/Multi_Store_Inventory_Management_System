<!--### Header Part ##################################################-->
<?php
include '../template/header.php';
?>
<!--#####################################################-->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Add 'show' class to the element with ID "collapseLayouts2"
    $(document).ready(function() {
        $("#collapseLayouts3").addClass("show");
        $("#collapseLayouts3_deactivate").addClass("active bg-success");
    });
</script>



            <div id="layoutSidenav_content">
<!--main content////////////////////////////////////////////////////////////////////////////////-->
                <main>
                    <div class="container-fluid px-4">
                    <table class="table table-striped">
                    <thead>
                        <tr>
                            
                            <th>Item Name</th>
                            <th>Category</th>
                            <th>Brand</th>
                            
                            <th>Size</th>
                            <th>Unit</th>
                            <th>Unit Price</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                           
                            <th>Added DateTime</th>
                            <th>issue By</th>
                            <th>Employee ID</th>
                            <th>Employee</th>
                            
                            
                        </tr>
                        </thead>

                    <tbody>


                    <?php
                        
                        include '../layoutdbconnection.php';                     
                        // Fetch company names from the database
                        $sql = "SELECT i.i_name, c.c_name, i.i_manufactured_by, 
                        i.i_size, i.i_unit, iss.is_avg_price, iss.is_qty, iss.is_avg_price*iss.is_qty as total_price,
                         iss.is_datetime, iss.is_item_issue_by, e.e_com_id, e.e_name
                        from item_issue iss 
                        INNER JOIN item i ON iss.i_id = i.i_id 
                        INNER JOIN employee e ON iss.e_id = e.e_id
                        INNER JOIN category_item c ON i.c_id = c.c_id
                        WHERE iss.is_active = 0
                        ORDER BY iss.is_datetime DESC
                        ";
                        $result = mysqli_query($conn, $sql);
                
                        if (mysqli_num_rows($result) > 0) {
                            
                            while ($product = mysqli_fetch_assoc($result)) {
                                //echo print_r($product);
                                echo "<tr>";
                                
                                echo "<td>".$product['i_name']."</td>";
                                echo "<td>".$product['c_name']."</td>";
                                echo "<td>".$product['i_manufactured_by']."</td>";

                                
                                echo "<td>".$product['i_size']."</td>";
                                echo "<td>".$product['i_unit']."</td>";

                                echo "<td>".$product['is_avg_price']."</td>";
                                echo "<td>".$product['is_qty']."</td>";

                                echo "<td>".$product['total_price']."</td>";
                                

                                echo "<td>".$product['is_datetime']."</td>";
                                echo "<td>".$product['is_item_issue_by']."</td>";
                                echo "<td>".$product['e_com_id']."</td>";
                                echo "<td>".$product['e_name']."</td>";
                                
                                
                                
                                

                                echo "</tr>";
                            }
                        }
                
                            
                         else {
                            echo "No records found.";
                        }
                
                        // Close database connection
                        mysqli_close($conn);
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