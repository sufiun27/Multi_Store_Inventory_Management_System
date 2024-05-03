<!--### Header Part ##################################################-->
<?php
include '../template/header.php';
?>
<!--#####################################################-->
<style>
    td,th {
        font-size: 12px; /* Increase the font size */
        font-weight: bold; /* Make the text bold */
    }
    #active{
                            background-color: orange;
                            padding: 2px 4px;
                            border-radius: 2px;
                            font-size: 12px;
                            color: red;
    }
    #deactive{
                            background-color: green;
                            padding: 2px 4px;
                            border-radius: 2px;
                            font-size: 12px;
                            color: white;
    }
    #edit{
                            background-color: blue;
                            padding: 2px 4px;
                            border-radius: 2px;
                            font-size: 12px;
                            color: white;
    
    }
    #delete{
                            background-color: red;
                            padding: 2px 4px;
                            border-radius: 2px;
                            font-size: 12px;
                            color: white;
    
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Add 'show' class to the element with ID "collapseLayouts2"
    $(document).ready(function() {
        $("#collapseLayouts1").addClass("show");
        $("#collapseLayouts1_list").addClass("active bg-success");
    });
</script>



            <div id="layoutSidenav_content">
<!--main content////////////////////////////////////////////////////////////////////////////////-->
                <main>
                    <?php
                    if (isset($_GET['value'])) {
                        $message = $_GET['value'];
                        echo '<div id="message" class="bg-warning">' . $message . '</div>';
                        echo '<script>
        setTimeout(function() {
            document.getElementById("message").style.display = "none";
        }, 3000); // 5000 milliseconds (5 seconds) until the message is hidden
    </script>';
                    }
                    ?>
                    <div class="container-fluid px-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Product List  - - D = Delete , E = Edit , L = Locked
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
                           <!-- <th>Issue Avg Price</th>-->
                            <th>Stock</th>
                            <th>ROL</th>
                            <th>Added DateTime</th>
                            <th>Update DateTime</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>

                    <tbody>


                    <?php
                        
              try{
                include '../layoutdbconnection.php';                     
                // Fetch company names from the database Full texts	
                $section = $_SESSION['section'];
                
      $sql = " SELECT
                i.i_code,
                i.i_id,
                i.i_name,
                c.c_name,
                i.i_manufactured_by,
                i.i_size,
                i.i_unit,
                i.i_price,
                i.i_add_datetime,
                i.i_update_datetime,
                i.i_active,
                i.stock_out_reminder_qty,
                b.qty_balance,
                b.item_issue_avg_price,
                b.total_item_purchase,
                b.total_item_issue
                FROM
                item i
                LEFT JOIN
                balance b ON i.i_id = b.i_id
                INNER JOIN
                category_item c ON c.c_id = i.c_id
                WHERE i.section = '$section'
                ORDER BY
                i.i_add_datetime DESC
                ";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
        
                //if ($stmt->rowCount() > 0) {
                    
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
                        if($product['stock_out_reminder_qty']>$product['qty_balance']){
                            echo '<td>( ' . $product['qty_balance'] . ' )</td>';
                        }else{
                            echo "<td class='' style=\"background: rgba(91, 255, 102, 0.40);\">".$product['qty_balance']."</td>";
                        }
                        echo "<td>".$product['stock_out_reminder_qty']."</td>";

                       echo "<td>".date('Y-m-d', strtotime($product['i_add_datetime']))."</td>";
                       if ($product['i_update_datetime'] !== null) {
                        echo "<td>".date('Y-m-d', strtotime($product['i_update_datetime']))."</td>";
                    } else {
                        echo '<td></td>';
                    }


                        if($product["i_active"]==1){ echo '<td class="text-success">
                           Ok  <a  id="active" href="product_list_status_deactive.php?id='.$product["i_id"].'" > X </a>
                            </td>';}
                            else{echo '<td class="text-danger">
                                X
                                <a id="deactive" href="product_list_status_active.php?id='.$product["i_id"].'" >
                                Ok
                                </a>
                                </td>';}
                        
                         /*
                         <i class="fa-solid fa-xmark"></i>
                         <i class="fa-solid fa-check"></i>
                         <i class="fa-solid fa-pen-to-square"></i>
                         <i class=\"fa-solid fa-pen-to-square\"></i>
                         <span ><i class="fa-solid fa-lock"></i></sapan>

                         */
                        
                        
                        echo "<td>
                        <div class=\"btn-group\">";
                    if ($_SESSION['role'] == 'admin'||$_SESSION['role'] == 'super_admin'){
                        echo "<a id=\"edit\" href=\"product_edit.php?p_id=".$product['i_id']."\">
                           
                           E 
                            
                        </a>";

                        if ($product['total_item_purchase'] == 0 && $product['total_item_issue'] == 0){
                            echo "<a id=\"delete\" href=\"product_delete.php?p_id=".$product['i_id']."\">
                                
                                 X
                              
                            </a>";
                        } else {
                            echo '<span >L</sapan>';
                        }
                    }
                        }
                                
                            echo "
                                  </td>";

                        echo "
                        
                        </tr>";
                    //}
        
                    
                //  else {
                //     echo "No records found.";
                // }
                ////////////////////////////////////////////////////
                        
                        
        
                // Close database connection
                $conn = null;
              } catch(PDOException $e){
                echo "Database Error: " . $e->getMessage();

              }
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