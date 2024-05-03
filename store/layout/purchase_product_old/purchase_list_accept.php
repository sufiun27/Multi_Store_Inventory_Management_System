<!--### Header Part ##################################################-->
<?php
include '../template/header.php';
?>
<!--#####################################################-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Add 'show' class to the element with ID "collapseLayouts2"
    $(document).ready(function() {
        $("#collapseLayouts2").addClass("show");
        $("#collapseLayouts2_accept_list").addClass("active bg-success");
    });
</script>


            <div id="layoutSidenav_content">
<!--main content////////////////////////////////////////////////////////////////////////////////-->
                <main>
                    <div class="container-fluid px-4">
                    <table class="table table-striped bg-light">
                    <thead>
                        <tr>
                            <th>Po No</th>
                            <th>Item Name</th>
                            <th>Category</th>
                            <th>Unit</th>
                            <th>Size</th>
                            <th>Unit Price</th>
                            <th>Req/Rec Quantity</th>
                            <th>Total Price</th>
                            <!--<th>Profit</th>-->
                            <th>Request Time</th>
                            <!--<th>Expiration DateTime</th>-->
                            <th>Supplier</th>
                            <th>Purchased By</th>
                            <th>Accept By</th>
                            <th>Actions</th>
                        </tr>
                        </thead>

                    <tbody>


                    <?php
                        
                        include '../layoutdbconnection.php';                     
                        // Fetch company names from the database
                        $sql = "SELECT 
                        COALESCE(r.total_recive, 0) AS total_recive, ip.p_req_qty, ip.p_request_accept_by,
                        ip.p_id, ip.p_po_no, i.i_name, c.c_name, 
                        i.i_unit, i.i_size, ip.p_unit_price,  ip.p_unit_price*ip.p_req_qty as total_price,
                        ip.p_profit, ip.p_request_datetime,  s.s_name, ip.p_purchase_by,
                        ip.p_request, ip.p_recive
                        FROM item_purchase ip
                        INNER JOIN item i ON ip.i_id = i.i_id 
                        INNER JOIN supplier s ON ip.s_id = s.s_id 
                        INNER JOIN category_item c ON i.c_id = c.c_id
                        LEFT JOIN (SELECT p_id, SUM(p_recive_qty) AS total_recive FROM tem_purchase_recive GROUP BY p_id) r ON ip.p_id = r.p_id
                        WHERE ip.p_request = 1
                        ORDER BY ip.p_request_datetime DESC
                        ";
                        $stmt = $conn->prepare($sql);
                
                        if ($stmt->execute()) {
                            
                            while ($product = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                //echo print_r($product);
                                echo "<tr>";
                                echo "<td>".$product['p_po_no']."</td>";
                                echo "<td>".$product['i_name']."</td>";
                                echo "<td>".$product['c_name']."</td>";

                                echo "<td>".$product['i_unit']."</td>";
                                echo "<td>".$product['i_size']."</td>";

                                echo "<td>".$product['p_unit_price']."</td>";
                                echo "<td>".$product['p_req_qty']." / ".$product['total_recive']."</td>";

                                echo "<td>".$product['total_price']."</td>";
                                //echo "<td>".$product['p_profit']."</td>";

                                echo "<td>".$product['p_request_datetime']."</td>";
                                //echo "<td>".$product['p_expaired_datetime']."</td>";
                                echo "<td>".$product['s_name']."</td>";
                                echo "<td>".$product['p_purchase_by']."</td>";
                                echo "<td>".$product['p_request_accept_by']."</td>";
                                
                                
                                echo "<td>
                                        <div class=\"btn-group\">";
                                        /*if ($_SESSION['role'] == 'admin'){
                                            if($product['p_request']=='0'){
                                                echo "<a href=\"purchase_list_process_request.php\?p_id=".$product['p_id']."><button type=\"button\" class=\"btn btn-success\">Accept</button></a>";
                                            }else{echo "Accepted";}                                           
                                        }*/
                                           


                                        if($product['p_recive']=='1' and $product['p_req_qty']==$product['total_recive']){
                                            echo "<span class=\"text-danger\">Completed</span>";
                                        }elseif($product['p_recive']=='1'){
                                            echo "<span class=\"text-primary\">Receiving</span>";
                                        }elseif ($product['p_request']=='1'){
                                            echo "<span class=\"text-primary\">Not Recive</span>";
                                        }
                                    }
                                    
                                        
                                    echo "</div>
                                          </td>";

                                echo "</tr>";
                            }
                
                            
                         else {
                            echo "No records found.";
                        }
                
                        // Close database connection
                        unset($conn);
                        exit;
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