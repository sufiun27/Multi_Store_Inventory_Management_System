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
        $("#collapseLayouts3_add").addClass("active bg-success");
    });
</script>

<style>
    label{
        font-size: 12px;
        color: black;
    }
    body {
    color: black;
}
</style>

            <div id="layoutSidenav_content">


<!--main content////////////////////////////////////////////////////////////////////////////////-->
                <main>
                    <?php
                    include '../layoutdbconnection.php';

                    if (isset($_GET['id'])) {
                       
                         $db=$_SESSION['company'];
                        // Create a PDO connection to your Microsoft SQL Server database
                        $serverName = "BDAPPSS02V\SQLEXPRESS";
                        $connectionOptions = array(
                            "Database" => "$db",
                            "Uid" => "sa",
                            "PWD" => "sa@123"
                        );
                        try {
                            $conn = new PDO("sqlsrv:Server=$serverName;Database={$connectionOptions['Database']}", $connectionOptions['Uid'], $connectionOptions['PWD']);
                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        } catch (PDOException $e) {
                            die("Connection failed: " . $e->getMessage());
                        }
                    
                        
////////////////////////////////emp record
                        function query($sql,$conn){                            
                        $stmt = $conn->prepare($sql);                        
                        $stmt->execute();                    
                        return $stmt->fetch(PDO::FETCH_ASSOC);
                        }

                        $e_id=$_GET['id'];
                        $sql="SELECT e_com_id,e_name,d_name,e_id ,store
                        from employee INNER JOIN department ON department.d_id=employee.d_id 
                        WHERE e_id= $e_id";
                        $emp=query($sql,$conn);
                        $issue_store=$emp['store'];
//////////////////////////////////////item list
                           //$query = "SELECT i.i_name,i.i_id,b.qty_balance,i.i_manufactured_by FROM item i INNER JOIN balance b ON b.i_id=i.i_id WHERE i.section = '{$_SESSION['section']}'  ORDER BY i.i_name ASC";
                            
                            $query="SELECT i.i_name,i.i_id,b.qty_balance,i.i_manufactured_by,i.i_size FROM item i INNER JOIN balance b ON b.i_id=i.i_id WHERE i.section = '{$_SESSION['section']}' AND
                            EXISTS (
                            SELECT sub.i_name,sub.i_manufactured_by,sub.i_size FROM item sub
                            WHERE sub.section='{$issue_store}' AND sub.i_name=i.i_name AND sub.i_manufactured_by=i.i_manufactured_by AND i.i_size=sub.i_size
                            )
                            ORDER BY i.i_name ASC";
                            $stmt = $conn->prepare($query);
                            $stmt->execute();
                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
////////////////////////////////////////////////////////
                        /////////item record
                        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selectedOption'])) {
                            $input =  $_POST['selectedOption'];
                            $emp_id=$_GET['id'];
                            $last_issue_emp="SELECT e.e_name, e.e_id, d.d_name, e.e_com_id,
                                            COALESCE(iss.is_qty, 0) AS is_qty, 
                                            COALESCE(iss.is_item_issue_by, '-') AS is_item_issue_by, 
                                            ISNULL(CONVERT(VARCHAR, TRY_CAST(iss.is_datetime AS DATETIME), 120), '-') AS is_datetime, 
                                            iss.is_active
                                            FROM employee e
                                            LEFT JOIN (
                                                SELECT ii.e_id, ii.is_qty, ii.is_datetime, ii.is_item_issue_by, ii.is_active
                                                FROM item_issue ii
                                                WHERE ii.i_id = $input AND ii.is_active = 1
                                                    AND ii.is_datetime = (
                                                        SELECT MAX(ii2.is_datetime)
                                                        FROM item_issue ii2
                                                        WHERE ii2.e_id = ii.e_id
                                                            AND ii2.i_id = ii.i_id
                                                    )
                                            ) iss ON iss.e_id = e.e_id
                                            INNER JOIN department d ON d.d_id = e.d_id
                                            WHERE e.e_active = 1 AND e.e_id= $emp_id and d.d_active=1";
                                            $stmt = $conn->prepare($last_issue_emp);
                                            $stmt->execute();
                                            $last_issue_emp = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            } else {
                                //echo "<p>self post </p>";
                            }
                        $stmt = $conn->prepare("SELECT * FROM item i INNER JOIN category_item c ON i.c_id = c.c_id WHERE i_id = ?");
                        $stmt->bindValue(1, $input, PDO::PARAM_INT);
                        $stmt->execute();                    
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                        if ($row) {
                            $itemname = $row["i_name"];
                            $catagory = $row["c_name"];
                            $brand = $row["i_manufactured_by"];
                            $size = $row["i_size"];
                            $unit = $row["i_unit"];
                            $price = $row["i_price"];
                    
                            // Prepare and execute the SQL statement for the second query
                            $stmt2 = $conn->prepare("SELECT qty_balance, item_issue_avg_price FROM balance WHERE i_id = ?");
                            $stmt2->bindValue(1, $input, PDO::PARAM_INT);
                            $stmt2->execute();
                    
                            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                    
                            if ($row2) {
                                $avg_price = $row2["item_issue_avg_price"];
                                $stock = $row2["qty_balance"];
                            } else {
                                echo "No options found. 1";
                            }
                        } else {
                            //echo "No options found. 2";
                        }
                        ///////////////self
                           ///////////////////////

                
                



                        // Close statement
                        $stmt = null;
                        $stmt2 = null;
                    
                        // Close database connection
                        $conn = null;
                    } else {
                        echo "No options found.";
                    }
                    
                    /////////////////////self work set item//////////////
                    
?>


                         
                        


                    <div class="container-fluid px-4">
                    <div class="fs-3 font-weight-bold p-5" style="background: rgba(217, 217, 217,0.7);">
<!-- Add Product //////////////////////////////////////////////////////////////////////-->
                    <!-- <h2 class="mt-2 mb-4 "><b>Issue Product <span class="text-success"><?php // echo '( '.$itemname.' )'; ?></span> </b></h2> -->
                    
                    
                    <!-- ///////////////// -->
                    <style>
                       .bg{
                        background-color: rgba(220, 238, 247, 0.8);
                       }
                    </style>
                    <div class="row bg-info" >
                        <h3><b>Store:<?php echo $emp['store']; ?></b></h3>
                    </div>
                    <div class="row " style="background-color: #F8FAFF;">
                    <div class="col-4 "><h4><b>Select Item</b></h4></div>

                    <div class="col-3 bg"><h4><i>Last issue record:</i></h4></div>
                    <div class="col-2 bg">Employee: <?php echo $emp['e_name']; ?></div>
                    <div class="col-2 bg">ID: <?php echo $emp['e_com_id']; ?></div>
                    <div class="col-1 bg">Dep: <?php echo $emp['d_name']; ?></div>
                    </div>
                    
                    <form action="" method="post">
                    
    <div class="row " style="background-color: #F8FAFF;">
        
        <div class="col-4 " style="background-color: #EFFFE9;"> <!-- Adjusted column width -->

        <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
               
            <div class="form-group">
              
             
                <select data-style="selected-item" name="selectedOption" class="selectpicker" data-show-subtext="true" data-live-search="true" id="mySelect">
                
                <?php
                    // Fetch item record
                    if ($result) {
                        echo '<option >Please select Item</option>';
                        foreach ($result as $row) {
                                
                            if($row['qty_balance']==0){
                                echo '<option value="' . $row['i_id'] . '" data-subtext="' . $row['i_manufactured_by'] .' - '. $row['qty_balance'] . '" disabled="disabled">' . $row['i_name'] . '</option>';
                            }else{
                                echo '<option value="' . $row['i_id'] . '" data-subtext="" >' . $row['i_name'] .' : '. $row['i_manufactured_by'] .' - '. $row['i_size'].': [ '. $row['qty_balance'].' ]</option>';
                            }
                            
                        }
                        
                    } else {
                        echo "<p>No results found.</p>";
                    }
                    ?>
                
                </select>

                <input type="hidden" name="selectedOptionID" id="selectedOptionID">
                <!-- <span class="help-inline">With <code>data-show-subtext="true" data-live-search="true"</code>. Try searching for california</span> -->
                <button type="submit" class="btn btn-primary">Select</button>
            </div>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
            <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
            <script>
            $(document).ready(function() {
                $('#mySelect').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
                var selectedOptionValue = $('#mySelect option:selected').val();
                $('#selectedOptionID').val(selectedOptionValue);
                });
            });

            </script>
            
        </div>
        
        <div class="col-2">Item: <?php echo $itemname; ?></div>
        <div class="col-1">Qty: <?php echo $last_issue_emp[0]['is_qty']; ?></div>
        <div class="col-2">Issue BY: <?php echo $last_issue_emp[0]['is_item_issue_by']; ?></div>
        <div class="col-3">Date: <?php echo $last_issue_emp[0]['is_datetime']; ?></div>
    </div>
</form>

                   
  <form id="submitForm" action="issue_process2.php" method="POST">
   
   <div class="row bg-info">
    
    
   </div>

  <div class="row">
             
  <!--////////////Supplier Search///////////////////////////////////////////////////////////////////////////-->
    <div class="form-group" >
                

<!--///////////////////////////////////////////////////////////////////////////////////////-->
<!--////////////category button//////////////////////////////////////neet to change this item id /////////////////////////////////////-->
                 <input type="hidden" name="i_id" value="<?php echo $input; ?>">
                
                 <input type="hidden" name="e_id" value="<?php echo $emp['e_id']; ?>">
                 <input type="hidden" name="d_name" value="<?php echo $emp['d_name']; ?>">

    </div>
               <div class="row">


                   <div class="col-4">
                       <div class="form-group">
                           <label for="item_name">Invoice No</label>
                           <?php
                            if (isset($_GET['item_po_no'])) {
                                $item_po_no = htmlspecialchars($_GET['item_po_no']); // Sanitize the input
                                echo '<input readonly type="text" class="form-control" id="item_po_no" name="item_po_no" placeholder="' . $item_po_no . '" value="' . $item_po_no . '" required>';
                            } else {
                                echo '<input type="text" class="form-control" id="item_po_no" name="item_po_no" placeholder="invoice no" required>';
                            }
                            ?>

                           
                       </div>
                   </div>

                <div class="col-2">
                <div class="form-group">
                   <label for="item_name">Item Name</label>
                   <input readonly type="text" class="form-control" id="item_name" name="item_name" value="<?php  echo $itemname; ?>" placeholder="<?php  echo $itemname; ?>" required>
               </div>
                </div>

                <div class="col-2">
                <div class="form-group">
                   <label for="brand">Brand</label>
                   <input readonly placeholder="<?php  echo $brand; ?>" value="<?php  echo $brand; ?>" type="text" class="form-control" id="brand" name="brand" required>
               </div>
                </div>

                <div class="col-1">
               <div class="form-group">
                   <label for="unit">Unit</label>
                   <input readonly placeholder="<?php  echo $unit; ?>" value="<?php  echo $unit; ?>" type="text" class="form-control" id="unit" name="unit" required>
               </div>
               </div>
                
               
               <div class="col-1">
               <div class="form-group">
                   <label for="size">size</label>
                   <input readonly placeholder="<?php  echo $size; ?>" value="<?php  echo $size; ?>" type="text" class="form-control" id="size" name="size" required>
               </div>
               </div>

               <div class="col-1">
                        <div class="form-group">
                            <label for="profit">Stock</label>
                            <input readonly type="number" class="form-control" id="stock" name="stock" placeholder="<?php echo $stock; ?>" required>
                        </div>
                        </div>

               </div>

               
               
                
               <script>
                var price;
                var profit;
                var quantity;
                var totalPrice;
                var oldtotalprice;
                var submit;
                    function calculateTotal() {
                     price = parseFloat(document.getElementById('price').value);
                     quantity = parseFloat(document.getElementById('quantity').value);

                     totalPrice = <?php echo $avg_price?> * quantity;
                     
                    document.getElementById('total').textContent = totalPrice.toFixed(2);
                    oldtotalprice=   quantity *   <?php echo $price?>;
                    profit=oldtotalprice-totalPrice;
                    submit= <?php echo $stock?> - quantity ;
                    
                    // Call the function to update the placeholder value in the second script block
                    updateProfitPlaceholder();
                    

                    }
                    

                </script>
               
               
               
           

            

            <div class="row">
               
               
                <input readonly hidden placeholder="<?php  echo $price; ?>" value="<?php  echo $price; ?>" type="number" class="form-control" id="real_price" name="real_price" step="0.01" min="0" oninput="calculateTotal()" required>
               
          
               
                
                <input hidden readonly placeholder="<?php  echo $avg_price; ?>" value="<?php  echo $avg_price; ?>" type="number" class="form-control" id="price" name="price" step="0.01" min="0" oninput="calculateTotal()" required>
             
             
             
               

                   
                   


                        


                   

                 
               

            </div>
            
            <div class="row">


            <div class="col-2">
                   <div class="form-group">
                   <label for="quantity">Quantity</label>
                   <input type="number" class="form-control" id="quantity" name="quantity" min="0" oninput="calculateTotal()" required>
                   </div>
            </div>
            
            
                  
                                   
                    
                    <span hidden class="form-control" id="total"></span>                    
                   
                

                   

                   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                   
                   <script>
                    var myVariable;
                    var myVariable1;

                    function updateProfitPlaceholder() {
                        myVariable = profit;
                        myVariable1 = submit;
                        $(document).ready(function() {
                        // Set the placeholder value
                        $('#profit').attr('placeholder', myVariable);
                        $('#profit').attr('value', myVariable);
                        $('#value').attr('placeholder', myVariable1);
                        if (myVariable1 < 0) {
                        // Remove the submit button
                        //$('#submitBtn').remove();
                         $("#submitBtn").hide();

                        // Show a message
                        $('#message').text("Quantity must less then stock");
                                    }else { $("#submitBtn").show(); 
                                            $('#message').text("");
                                    }
                        });
                    }
                    </script>

                
            
                   <input hidden readonly type="text" class="form-control" id="profit" name="profit" required>
               
             
               
                <div class="col-2">
               <div class="form-group">
                   <label for="value">Remaining Stock</label>
                   <input readonly type="text" class="form-control" id="value" name="value" required>
               </div>
               </div>
               

               <?php 
                date_default_timezone_set('Asia/Dhaka');
                $defaultDateTime = date('Y-m-d H:i:s');
                ?>
                <!-- <label for="item_add_date" class="col-sm-2 col-form-label">Add Date Time</label> -->  
                   <input hidden type="datetime-local" class="form-control" id="item_add_date" name="item_add_date" placeholder="<?php echo $defaultDateTime; ?>" value="<?php echo $defaultDateTime; ?>" required>                 
                 

            
                
            <div class="col-1">
            <div class="form-group">
            <label for="submitBtn"></label>
            <button id="submitBtn" type="submit" class="btn btn-primary">Submit</button>
            </div>
            </div>
                

            </div>
            
              <div id="container"></div>
               
               <b><h4 id="message" class="bg-danger text-white"></h4></b>
               
               
               
           </form>


           <!-- /////////////////////////////////////////////// -->
                        <h4>issue track</h4>

                        <div class="row">
                        <table class="table table-striped table-sm ">
                <thead class="" style="background-color: #f4f7f7;">
                <tr>
                    <th>Po No</th>
                    <th>Item Name</th>
                    <th>Category</th>
                    <th>Brand</th>
                    <th>Size</th>
                    <th>Unit</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <!-- <th>Added DateTime</th>
                    <th>issue By</th>
                    <th>Employee ID</th>
                    <th>Employee</th> -->
                    
                </tr>
                </thead>
                <tbody>
                <?php
                
                // Fetch company names from the database
                    if(isset($_GET['item_po_no'])){
                        include '../layoutdbconnection.php';
                        $invoice=$_GET['item_po_no'];
                        echo $invoice;
                        $sql = "SELECT iss.is_po_no, iss.is_id, i.i_name, c.c_name, 
                        i.i_manufactured_by, i.i_size, i.i_unit, iss.is_avg_price, 
                        iss.is_qty, ist.total_price as total_price, 
                        iss.is_datetime, iss.is_item_issue_by, e.e_com_id, e.e_name
                             from item_issue iss 
                             INNER JOIN item i ON iss.i_id = i.i_id 
                             INNER JOIN employee e ON iss.e_id = e.e_id
                             INNER JOIN category_item c ON i.c_id = c.c_id
                             INNER JOIN (SELECT SUM(ist_qty*ist_price) as total_price, is_id FROM item_issue_trac GROUP BY is_id) ist ON ist.is_id = iss.is_id
                             WHERE iss.is_active = 1 AND iss.is_po_no = '$invoice'
                             ORDER BY iss.is_datetime DESC";
        
                    $stmt = $conn->prepare($sql);
        
                        if ($stmt->execute()) {
                           // $product = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            while ($product = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>".$product['is_po_no']."</td>";
                                echo "<td>".$product['i_name']."</td>";
                                echo "<td>".$product['c_name']."</td>";
                                echo "<td>".$product['i_manufactured_by']."</td>";
                                echo "<td>".$product['i_size']."</td>";
                                echo "<td>".$product['i_unit']."</td>";
                                echo "<td>".$product['is_avg_price']."</td>";
                                echo "<td>".$product['is_qty']."</td>";
                                echo "<td>".$product['total_price']."</td>";
                                // echo "<td>".$product['is_datetime']."</td>";
                                // echo "<td>".$product['is_item_issue_by']."</td>";
                                // echo "<td>".$product['e_com_id']."</td>";
                                // echo "<td>".$product['e_name']."</td>";
                                
                                echo "</tr>";
        
                                // Include the custom-info-row within each loop iteration
                                
                            }
                        } else {
                            echo "No records found.";
                        }
                    }
               

                // Close database connection
               // unset($conn);
                
                ?>
                </tbody>
            </table>
                        </div>
           



                    </div>
                </main>
<!--main content//////////////////////////////////////////////////////////////////////////////////-->

<!--###### Footer Part ###############################################-->
<?php
include '../template/footer.php';
?>
<!--#####################################################-->