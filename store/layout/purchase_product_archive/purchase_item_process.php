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
        $("#collapseLayouts2_add").addClass("active bg-success");
    });
</script>


<style>
    label{
        font-size: 14px;
    }
</style>

            <div id="layoutSidenav_content">




<!--main content////////////////////////////////////////////////////////////////////////////////-->
                <main>
                <?php
        
        include '../layoutdbconnection.php';


           
           
           if(isset( $_GET['id'])){
               $input =  $_GET['id'];
                  // Prepare the SQL statement 
                   $sql = "SELECT * FROM item INNER JOIN category_item ON item.c_id = category_item.c_id WHERE i_id = $input ";
                   $stmt = $conn->prepare($sql);
                   $stmt->execute();
                   $row = $stmt->fetch(PDO::FETCH_ASSOC);

                   


                  
                       
                    
                           $itemname=$row["i_name"];
                           $catagory=$row["c_name"];
                           $brand= $row["i_manufactured_by"];
                           $size=$row["i_size"];
                           $unit=$row["i_unit"];
                           $price=$row["i_price"];
                           
                           
                   } else {
                       echo "No options found.";
                   }
   
                   // Close database connection

                




                   unset($conn);
                  
   
       ?>
                    <div class="container-fluid px-4">
                    <div class="fs-2 font-weight-bold p-3" style="background: rgba(217, 217, 217,70%);">
<!-- Add Product //////////////////////////////////////////////////////////////////////-->
                    <h4 class="mt-5 mb-4"><b>Purchase Product <span class="text-success"><?php  echo '( '.$itemname.' )'; ?></span> </b></h4>
                   
              

  <form id="submitForm" action="adduser_emp_process_submit.php" method="POST">
   
  <div class="row">
  <!--////////////Supplier Search///////////////////////////////////////////////////////////////////////////-->
    <div class="form-group" >
                <div >
                <h3 class="fs-2 font-weight-bold"><b>Select Supplier</b></h3>
                </div>
                <input type="text" class="form-control" id="live_search" autocomplete="off" placeholder="Search..." required>
                </div>

                <div id="search_result"></div>

                 <!-- jQuery -->
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
                    <!-- Optional Bootstrap JavaScript -->
                    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

                    <script type="text/javascript">
                        $(document).ready(function() {
                        $("#live_search").keyup(function() {
                            var input = $(this).val();
                            if (input !== "") {
                            $.ajax({
                                url: "livesearch_supplier.php",
                                method: "POST",
                                data: { input: input },
                                success: function(data) {
                                $("#search_result").html(data);
                                }
                            });
                            } else {
                            $("#search_result").empty();
                            }
                        });
                        });
                    </script>
<!--///////////////////////////////////////////////////////////////////////////////////////-->
    <!--////////////category button///////////////////////////////////////////////////////////////////////////-->
                 <input type="hidden" name="i_id" value="<?php echo $_GET['id']; ?>">
        

    </div>

      <div class="row">
          <div class="col-6">
              <div class="form-group">
                  <label for="pono">PO No</label>
                  <input  type="text" class="form-control" id="pono" name="pono"  placeholder="PO No" required autocomplete="off">
              </div>
          </div>


          <div class="col-6">
          <?php 
                date_default_timezone_set('Asia/Dhaka');
                $defaultDateTime = date('Y-m-d H:i:s');
                ?>
                <div class="col">
                <div class="form-group">
                   <label for="item_add_date">Request Date Time</label>
                   <input readonly type="datetime-local" class="form-control" id="item_add_date" name="item_add_date" placeholder="<?php echo $defaultDateTime; ?>" value="<?php echo $defaultDateTime; ?>" required>
                   </div>
                   </div>
          </div>
      </div>
                <div class="row">
                <div class="col-3">
                <div class="form-group">
                   <label for="item_name">Item Name</label>
                   <input readonly type="text" class="form-control" id="item_name" name="item_name" value="<?php  echo $itemname; ?>" placeholder="<?php  echo $itemname; ?>" required>
               </div>
                </div>

                <div class="col-3">
                <div class="form-group">
                   <label for="brand">Brand</label>
                   <input readonly placeholder="<?php  echo $brand; ?>" value="<?php  echo $brand; ?>" type="text" class="form-control" id="brand" name="brand" required>
               </div>
                </div>

                <div class="col-3">
               <div class="form-group">
                   <label for="unit">Unit</label>
                   <input readonly placeholder="<?php  echo $unit; ?>" value="<?php  echo $unit; ?>" type="text" class="form-control" id="unit" name="unit" required>
               </div>
               </div>
                
               
               <div class="col-3">
               <div class="form-group">
                   <label for="size">size</label>
                   <input readonly placeholder="<?php  echo $size; ?>" value="<?php  echo $size; ?>" type="text" class="form-control" id="size" name="size" required>
               </div>

               </div>

               
                
               <script>
                var price;
                var profit;
                var quantity;
                var totalPrice;
                var oldtotalprice;
                    function calculateTotal() {
                     price = parseFloat(document.getElementById('price').value);
                     quantity = parseFloat(document.getElementById('quantity').value);

                     totalPrice = price * quantity;
                     
                    document.getElementById('total').textContent = totalPrice.toFixed(2);
                    oldtotalprice=   quantity *   <?php echo $price?>;
                    profit=oldtotalprice-totalPrice;
                    // Call the function to update the placeholder value in the second script block
                    updateProfitPlaceholder();

                    }
                    

                </script>

               
               
            </div>

            <div class="row">
               
            <div class="col">
               <div class="form-group">
                <label for="price">price</label>
                <input value="<?php  echo $price; ?>" type="number" class="form-control" id="price" name="price" step="0.01" min="0" oninput="calculateTotal()" required>
               </div>
               </div>

                   <div class="col">
                   <div class="form-group">
                   <label for="quantity">Quantity</label>
                   <input type="number" class="form-control" id="quantity" name="quantity" min="0" oninput="calculateTotal()" required>
                   </div>
                   </div>

                   <div class="col">
                   <div class="form-group">                  
                    <label for="total">Total Price:</label>
                    <span class="form-control" id="total"></span>                    
                   </div>
                   </div>

                   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                   
                   <script>
                    var myVariable;

                    function updateProfitPlaceholder() {
                        myVariable = profit;
                        $(document).ready(function() {
                        // Set the placeholder value
                        $('#profit').attr('placeholder', myVariable);
                        $('#profit').attr('value', myVariable);
                        });
                    }
                    </script>

                   


                   <input hidden type="text" class="form-control" id="profit" name="profit" required>


                   

            </div>

            
               
                <div class="row">
                

                   <!--<div class="col">
                   <div class="form-group">
                   <label for="item_expaired_date">Expaired  Date Time</label>
                   <input type="datetime-local" class="form-control" id="item_expaired_date" name="item_expaired_date" required>
                   </div>
                   </div>-->

            </div>   
               
               
               
               
               
               
               
               
              
            <div class="row">
                <div class="col-6">
                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                </div>
            </div>
               
               
               
           </form>

           <div >
    <h5 class="text-success">Last 5 Receive History</h5>
    <table class="table table-bordered table-striped bg-white table-sm" >
        <thead>
            <tr class="bg-secondary">
                <th>Po No</th>
                <th>Po req qty
                <th>Rec Quantity</th>

                <th>Receive date time</th>
                <th>Expired date time</th>
                <th>Purchased by</th>
                <th>Receive by</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(isset($_GET['id'])){
                $input = $_GET['id'];

                //record of last purchase against this id number
                include '../layoutdbconnection.php';

                $sql_purchase = "SELECT TOP 5 *
                FROM tem_purchase_recive r
                INNER JOIN (
                    SELECT i_id, p_po_no, p_req_qty, p_id, p_recive, p_request_datetime, p_purchase_by
                    FROM item_purchase
                ) ip ON ip.p_id = r.p_id
                WHERE i_id = :input AND p_recive = 1
                ORDER BY p_request_datetime DESC;";
                $stmt = $conn->prepare($sql_purchase);

                if($stmt->execute([$input])) {
                    $row_count = 0;
                    while($purchase = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $row_count++;
                        echo "<tr class='" . ($row_count % 2 == 0 ? 'even' : 'odd') . "'>";
                        echo "<td>".$purchase['p_po_no']."</td>";
                        echo "<td>".$purchase['p_req_qty']."</td>";
                        echo "<td>".$purchase['p_recive_qty']."</td>";
                        echo "<td>".$purchase['p_recive_datetime']."</td>";
                        echo "<td>".$purchase['p_expaired_datetime']."</td>";
                        echo "<td>".$purchase['p_purchase_by']."</td>";
                        echo "<td>".$purchase['p_recive_by']."</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No records found.</td></tr>";
                }

                // Close database connection
                unset($conn);
            }
            ?>
        </tbody>
    </table>
</div>

           <?php
           //print_r( $row_purchase);
           ?>
                    </div>
                </main>
<!--main content//////////////////////////////////////////////////////////////////////////////////-->


<!--###### Footer Part ###############################################-->
<?php
include '../template/footer.php';
?>
<!--#####################################################-->