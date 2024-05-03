
    <!--### Header Part ##################################################-->
    <?php
    include '../template/header.php';
    ?>
    <!--#####################################################-->
<?php
include '../layoutdbconnection.php';
?>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Add 'show' class to the element with ID "collapseLayouts2"
    $(document).ready(function() {
        $("#collapseLayouts2").addClass("show");
        $("#collapseLayouts2_list").addClass("active bg-success");
    });
</script>

<style>
    th,td{
        font-size: 14px;
    }
    
</style>

<div id="layoutSidenav_content">
    <!--main content////////////////////////////////////////////////////////////////////////////////-->
    <main>
        <div class="container-fluid px-4">
           
<!---table------////////////////////---->        
<div class="card mb-4">
<div class="card-header " style="background: rgba(100, 210, 200,0.2);">
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" AND $_POST['view']=='true') {
                
                ?>
                <?php
                $po_id = $_POST['p_po_no'];

                try {
                    $sqlpo = "SELECT i_name FROM item i INNER JOIN item_purchase ip ON ip.i_id = i.i_id WHERE ip.p_po_no = :po_id";
                    $stmt = $conn->prepare($sqlpo);
                    $stmt->bindParam(':po_id', $po_id, PDO::PARAM_INT);

                    if ($stmt->execute()) {
                        $i_name = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($i_name) {
                            // Process the result (do something with $i_name)
                            $item_name = $i_name['i_name'];
                        } else {
                            echo "No matching records found.";
                        }
                    } else {
                        echo "Error executing the statement.";
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                ?>
            <span><b><div class="row" style="background: rgba(50, 210, 200,0.2);">
                <div class="col-1"><i class="fas fa-table me-1"></i></div>
                <div class="col-2"><?php echo "Po No: ".$_POST['p_po_no']?></div>
                <div class="col-2"><?php echo "Item: ".$item_name." : ".$_POST['i_manufactured_by']?></div>
                <div class="col-2"><?php echo "Category: ".$_POST['c_name']?></div>
                <div class="col-2"><?php echo "Unit Price: ".$_POST['p_unit_price']?></div>
                <div class="col-2"><?php echo "Req Qty: ".$_POST['p_req_qty']?></div>
            </div></b></span>
            <?php
            // collect value of input field
            echo 
            '<table class="table table-striped table-sm">
            <tr>
                <th>Add Date Time</th>                
                <th>Subbpier</th>
                <th>Purchase by</th>
                <th>Accepted by</th>                
            </tr>
            <tr>
                <td>'.$_POST['p_request_datetime'].'</td>                
                <td>'.$_POST['s_name'].'</td>
                <td>'.$_POST['p_purchase_by'].'</td>
                <td>'.$_POST['p_request_accept_by'].'</td>

            </tr>
           </table>';

           /////////////////////
           $p_id=$_POST['p_id'];

                $sql_receive="
                SELECT * FROM tem_purchase_recive WHERE p_id = $p_id;
                ";
                $stmt = $conn->prepare($sql_receive);
                    if ($stmt->execute()) {
                    $count = 0;
                    echo '<table class="table table-striped table-sm">';
                    echo '
                            <tr>
                                <th>No</th>
                                <th>Quantity</th>
                                <th>Receive Date</th>
                                <th>Expired Date</th>
                                <th>Purchase By</th>
                                <th>Receive By</th>
                            </tr>
                        ';

                    while ($receive_product = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $count++;
                        echo '
                            <tr>
                                <td>' . $count . '</td>
                                <td>' . $receive_product['p_recive_qty'] . '</td>
                                <td>' . $receive_product['p_recive_datetime'] . '</td>
                                <td>' . $receive_product['p_expaired_datetime'] . '</td>';

                                if($receive_product['cash1_creadit0']=='1'){
                                    echo '<td> Cash </td>';
                                } else {
                                    echo '<td> Credit </td>';
                                }

                                echo '
                                <td>' . $receive_product['p_recive_by'] . '</td>
                            </tr>
                        ';
                    }

                    echo '</table>';
                    }
            //////////////////////////////
            echo '
            <div class="row" style="background: rgba(50, 210, 200,0.2);">
                 <div class="col-2 bg-info" style="text-align: right;"><h5>Recive Qty</h5></div> <div class="col-2"><h5>'.$_POST['total_recive'].'</h5></div>
                 <div class="col-2 bg-info" style="text-align: right;"><h5>Remaining</h5></div> <div class="col-1"><h5>'.$_POST['p_req_qty']-$_POST['total_recive'].'</h5></div>
                
            </div>
            ';
////////////////////////////////////////////////////////////////////////
if($_POST['p_request']=='1'){
    if(  $_POST['total_recive'] <= $_POST['p_req_qty'] and $_POST['total_recive'] != $_POST['p_req_qty'] ){


        echo '

        <form action="purchase_list_process_recive.php" onsubmit="return method="post" validateNumber(); >
        <label for="receive_qty">Receive Quantity:</label>
        <input name="receive_qty" id="receive_qty" type="number" placeholder="Receive Quantity" />

        
        
        <input name="p_id" id="p_id" hidden type="number" value="'.$_POST['p_id'].'" />
        
        <label for="expaired_datetime">Expiry Date and Time:</label>
        <input name="expaired_datetime" id="expaired_datetime" type="datetime-local" />

        <label for="cash">Cash/Credit:</label>
        <select name="cash" id="cash">
            <option value="1">Cash</option>
            <option value="0">Credit</option>
        </select>

        
        <button id="submitButton" class="bg-success text-light">Submit</button>

          <p id="message" style="display: none;"></p>
        </form>
        ';
        ?>
        <script>
            // Get references to the elements
            const inputNumber = document.getElementById('receive_qty');
            const submitButton = document.getElementById('submitButton');
            const message = document.getElementById('message');

            // Add event listener to the input
            inputNumber.addEventListener('input', function() {
                const value = parseInt(inputNumber.value);

                if (value > <?php echo $_POST['p_req_qty']-$_POST['total_recive'];?>) {
                    submitButton.style.display = 'none';
                    message.style.display = 'block';
                    message.textContent = 'Input is greater than <?php echo $_POST['p_req_qty']-$_POST['total_recive'];?>.';
                } else {
                    submitButton.style.display = 'block';
                    message.style.display = 'none';
                }
            });
        </script>
        <?php

       // echo "<a href=\"purchase_list_process_recive.php?p_id=".$product['p_id']."\"><button type=\"button\" class=\"btn btn-primary btn-sm\">Receive</button></a>";
    } else {
        echo "<span class=\"text-primary\">Received</span>";
    }
} else {
    echo "<span class=\"text-primary\">| After accept can be receive</span>";
}
                }
            ?>
</div>
        
        
<div class="card-body">           
<table id="datatablesSimple">
    <thead>
        <tr>
            <th>Po No</th>
            <th>Item Name</th>
            <th>Brand</th>
            <th>Category</th>
            <th>Unit</th>
            <th>Size</th>
            <th>Unit Price</th>
            <th>Req/Accept Qty</th>
            <th>Total Price</th>
            <th>Action</th>
            <th>Select</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>Po No</th>
            <th>Item Name</th>
            <th>Brand</th>
            <th>Category</th>
            <th>Unit</th>
            <th>Size</th>
            <th>Unit Price</th>
            <th>Req/Accept Qty</th>
            <th>Total Price</th>
            <th>Status</th>
            <th>Select</th>
        </tr>
    </tfoot>
    
    <?php
        $section = $_SESSION['section'];
        // Fetch company names from the database

        if($_SESSION['table']=='short'){
        $sql = "SELECT TOP (50)
        COALESCE(r.total_recive, 0) AS total_recive, ip.p_req_qty, 
        ip.p_id, ip.p_po_no, i.i_name, c.c_name, i.i_unit, i.i_size,
        i.i_manufactured_by, 
        ip.p_unit_price,  ip.p_unit_price*ip.p_req_qty as total_price, 
        ip.p_profit, ip.p_request_datetime,  s.s_name, 
        ip.p_purchase_by, ip.p_request, ip.p_recive, ip.p_request_accept_by
        FROM item_purchase ip
        INNER JOIN item i ON ip.i_id = i.i_id 
        INNER JOIN supplier s ON ip.s_id = s.s_id 
        INNER JOIN category_item c ON i.c_id = c.c_id
        LEFT JOIN (SELECT p_id, SUM(p_recive_qty) AS total_recive FROM tem_purchase_recive GROUP BY p_id) r ON ip.p_id = r.p_id
        WHERE i.section = '$section'
        ORDER BY ip.p_request_datetime DESC";
        }
        if($_SESSION['table']=='all'){
            $sql = "SELECT 
            COALESCE(r.total_recive, 0) AS total_recive, ip.p_req_qty, 
            ip.p_id, ip.p_po_no, i.i_name, c.c_name, i.i_unit, i.i_size,
            i.i_manufactured_by, 
            ip.p_unit_price,  ip.p_unit_price*ip.p_req_qty as total_price, 
            ip.p_profit, ip.p_request_datetime,  s.s_name, 
            ip.p_purchase_by, ip.p_request, ip.p_recive, ip.p_request_accept_by
            FROM item_purchase ip
            INNER JOIN item i ON ip.i_id = i.i_id 
            INNER JOIN supplier s ON ip.s_id = s.s_id 
            INNER JOIN category_item c ON i.c_id = c.c_id
            LEFT JOIN (SELECT p_id, SUM(p_recive_qty) AS total_recive FROM tem_purchase_recive GROUP BY p_id) r ON ip.p_id = r.p_id
            WHERE i.section = '$section'
            ORDER BY ip.p_request_datetime DESC";
            }

        $stmt = $conn->prepare($sql);
     ?>

    <tbody>
        <?php

        if ($stmt->execute()) {
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($products as $product) {
                echo "<tr>";
                echo "<td>".$product['p_po_no']."</td>";
                echo "<td>".$product['i_name']."</td>";
                echo "<td>".$product['i_manufactured_by']."</td>";
                echo "<td>".$product['c_name']."</td>";
                echo "<td>".$product['i_unit']."</td>";
                echo "<td>".$product['i_size']."</td>";
                echo "<td>".$product['p_unit_price']."</td>";
                echo "<td>".$product['p_req_qty']." / ".$product['total_recive']."</td>";
                echo "<td>".$product['total_price']."</td>";
/////////////////////////ACTION Button///////////////////////////////
                echo "<td>";
                if($product['total_recive'] == $product['p_req_qty']){
                    echo "<span>Completed </span>";
                }elseif($product['p_recive']=='1'){
                    echo "<span>Receiving</span>";
                }elseif ($_SESSION['role'] == 'admin'||$_SESSION['role'] == 'super_admin'){

                    if($product['p_request']=='0'){
                        echo "<a href=\"purchase_list_process_request.php?p_id=".$product['p_id']."\"><button type=\"button\" class=\"btn btn-success btn-xs\">Accept</button></a>";
                    } else {
                        if($product['p_recive']=='0'){
                            echo "<a href=\"purchase_list_process_request_unaccept.php?p_id=".$product['p_id']."\"><button type=\"button\" class=\"btn btn-warning btn-xs\">Unaccept</button></a>";
                        } else {
                            echo "<span class=\"text-success\">Accepted | </span>";
                        }
                    }
                }
                if($product['p_recive']=='0' and $product['p_request']=='0'){
                    echo "<a href=\"purchase_list_process_delete.php?p_id=".$product['p_id']."\"><button type=\"button\" class=\"btn btn-danger btn-xs\">Delete</button></a>";
                } elseif($product['p_recive']!='0' and $product['p_request']!='0') {
                    echo "<a href=\"purchase_list_process_delete_return_step1.php?p_id=".$product['p_id']."\"><button type=\"button\" class=\"btn btn-danger btn-xs\">Return</button></a>";
                    
                }
                echo "</td>";

                
/////////////////////////End ACTION Button///////////////////////////////               
                ?>
<!--Submit button  ///////////////////////////-->
                <td>              
                   
                    <div>
                    <form method="post" action=""  >
                    <input hidden type="text" name="view" value="true">
                    <input hidden type="text" name="p_po_no" value="<?php echo $product['p_po_no'];?>">
                    <input hidden type="text" name="c_name" value="<?php echo $product['c_name'];?>">
                    <input hidden type="text" name="i_manufactured_by" value="<?php echo $product['i_manufactured_by'];?>">
                    <input hidden type="text" name="p_unit_price" value="<?php echo $product['p_unit_price'];?>">
                        <input hidden type="text" name="p_request_datetime" value="<?php echo $product['p_request_datetime'];?>">
                        <input hidden type="text" name="s_name" value="<?php echo $product['s_name'];?>">
                        <input hidden type="text" name="p_purchase_by" value="<?php echo $product['p_purchase_by'];?>">
                        <input hidden type="text" name="p_request_accept_by" value="<?php echo $product['p_request_accept_by'];?>">
                        <input hidden type="text" name="p_id" value="<?php echo $product['p_id'];?>">
                        <input hidden type="text" name="total_recive" value="<?php echo $product['total_recive'];?>">
                        <input hidden type="text" name="p_req_qty" value="<?php echo $product['p_req_qty'];?>">
                        <input hidden type="text" name="p_request" value="<?php echo $product['p_request'];?>">
                        <button type="submit">Select</button>
                    </form>
                    </div>
                    
                </td>
 <!--close submit button  ///////////////////////////-->
             <?php   
                echo "</tr>";
            }
        }
        ?>
    </tbody>

</table>
</div>
</div>
<!---table------////////////////////---->    


    </main>
    <!--main content//////////////////////////////////////////////////////////////////////////////////-->
    <!--###### Footer Part ###############################################-->
    <?php
    include '../template/footer.php';
    ?>
    <!--#####################################################-->
</div>

