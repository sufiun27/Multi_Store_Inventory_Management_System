
    <!--### Header Part ##################################################-->
    <?php
    include '../template/header.php';
    ?>
    <!--#####################################################-->
<?php
include '../layoutdbconnection.php';


?>

<div id="layoutSidenav_content">
    <!--main content////////////////////////////////////////////////////////////////////////////////-->
    <main>
        <div class="container-fluid px-4">
           
<!---table------////////////////////---->        
        <div class="card mb-4">
        <div class="card-header " style="background: rgba(217, 217, 217,0.2);">
            <i class="fas fa-table me-1"></i>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" AND $_POST['view']=='true') {
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
                                <td>' . $receive_product['p_expaired_datetime'] . '</td>
                                <td>' . $receive_product['p_recive_by'] . '</td>
                            </tr>
                        ';
                    }

                    echo '</table>';
                    }
            //////////////////////////////
            echo '<h5><u>Receive - total recive Qty ('.$_POST['total_recive'].') - Remaining Qty ('.$_POST['p_req_qty']-$_POST['total_recive'].')</u></h5>';
////////////////////////////////////////////////////////////////////////
if($_POST['p_request']=='1'){
    if(  $_POST['total_recive'] <= $_POST['p_req_qty'] and $_POST['total_recive'] != $_POST['p_req_qty'] ){


        echo '

        <form action="purchase_list_process_recive.php" onsubmit="return method="post" validateNumber(); ><label for="receive_qty">Receive Quantity:</label>
        <input name="receive_qty" id="receive_qty" type="number" placeholder="Receive Quantity" />
        
        
        <input name="p_id" id="p_id" hidden type="number" value="'.$_POST['p_id'].'" />
        
        <label for="expaired_datetime">Expiry Date and Time:</label>
        <input name="expaired_datetime" id="expaired_datetime" type="datetime-local" />
        
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
            <th>Category</th>
            <th>Unit</th>
            <th>Size</th>
            <th>Unit Price</th>
            <th>Req/Accept Qty</th>
            <th>Total Price</th>
            <th>Action</th>
            <th>Select</th>
        </tr>
    </tfoot>
    <tbody>
        <?php
        // Fetch company names from the database
        $sql = "SELECT 
        COALESCE(r.total_recive, 0) AS total_recive, ip.p_req_qty, 
        ip.p_id, ip.p_po_no, i.i_name, c.c_name, i.i_unit, i.i_size, 
        ip.p_unit_price,  ip.p_unit_price*ip.p_req_qty as total_price, 
        ip.p_profit, ip.p_request_datetime,  s.s_name, 
        ip.p_purchase_by, ip.p_request, ip.p_recive, ip.p_request_accept_by
        FROM item_purchase ip
        INNER JOIN item i ON ip.i_id = i.i_id 
        INNER JOIN supplier s ON ip.s_id = s.s_id 
        INNER JOIN category_item c ON i.c_id = c.c_id
        LEFT JOIN (SELECT p_id, SUM(p_recive_qty) AS total_recive FROM tem_purchase_recive GROUP BY p_id) r ON ip.p_id = r.p_id
        ORDER BY ip.p_request_datetime DESC";
        $stmt = $conn->prepare($sql);

        if ($stmt->execute()) {
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($products as $product) {
                echo "<tr>";
                echo "<td>".$product['p_po_no']."</td>";
                echo "<td>".$product['i_name']."</td>";
                echo "<td>".$product['c_name']."</td>";
                echo "<td>".$product['i_unit']."</td>";
                echo "<td>".$product['i_size']."</td>";
                echo "<td>".$product['p_unit_price']."</td>";
                echo "<td>".$product['p_req_qty']." / ".$product['total_recive']."</td>";
                echo "<td>".$product['total_price']."</td>";
                echo "<td><div class=\"btn-group\">";

                if($product['total_recive'] == $product['p_req_qty']){
                    echo "<button type=\"button\" class=\"btn btn-success btn-xs\">Completed</button>";
                }elseif($product['p_recive']=='1'){
                    echo "<button type=\"button\" class=\"btn btn-primary btn-xs\">Received</button>";
                }elseif ($_SESSION['role'] == 'admin'){

                    if($product['p_request']=='0'){
                        echo "<a href=\"purchase_list_process_request.php?p_id=".$product['p_id']."\"><button type=\"button\" class=\"btn btn-success btn-xs\">Accept</button></a>";
                    } else {
                        if($product['p_recive']=='0'){
                            echo "<a href=\"purchase_list_process_request_unaccept.php?p_id=".$product['p_id']."\"><button type=\"button\" class=\"btn btn-success btn-xs\">Unaccept</button></a>";
                        } else {
                            echo "<span class=\"text-success\">Accepted | </span>";
                        }
                    }
                }


                if($product['p_recive']=='0' and $product['p_request']=='0'){
                    echo "<a href=\"purchase_list_process_delete.php?p_id=".$product['p_id']."\"><button type=\"button\" class=\"btn btn-danger btn-xs\">Delete</button></a>";
                } else {
                    echo "<span class=\"text-danger\">  </span>";
                }

                echo "</div></td>";
               
                ?>
                <td>              
                <form method="post" action="">
                <input hidden type="text" name="view" value="true">
                    <input hidden type="text" name="p_request_datetime" value="<?php echo $product['p_request_datetime'];?>">
                    <input hidden type="text" name="s_name" value="<?php echo $product['s_name'];?>">
                    <input hidden type="text" name="p_purchase_by" value="<?php echo $product['p_purchase_by'];?>">
                    <input hidden type="text" name="p_request_accept_by" value="<?php echo $product['p_request_accept_by'];?>">
                    <input hidden type="text" name="p_id" value="<?php echo $product['p_id'];?>">
                    <input hidden type="text" name="total_recive" value="<?php echo $product['total_recive'];?>">
                    <input hidden type="text" name="p_req_qty" value="<?php echo $product['p_req_qty'];?>">
                    <input hidden type="text" name="p_request" value="<?php echo $product['p_request'];?>">
                    
                   
                    <button type="submit" class="btn btn-info btn-xs">Select</button>
                    </form>
                     
                    <!--close modal  ///////////////////////////-->
                </td>
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

