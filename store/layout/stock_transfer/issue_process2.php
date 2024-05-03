<?php
include '../template/header.php';
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Add 'show' class to the element with ID "collapseLayouts2"
    $(document).ready(function() {
        $("#collapseLayouts3").addClass("show");
        $("#collapseLayouts3_add").addClass("active bg-success");
    });
</script>


<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <?php
            /////////receiving data
            $item_po_no=filter_input(INPUT_POST, 'item_po_no', FILTER_SANITIZE_STRING);
            $item_id = filter_input(INPUT_POST, 'i_id', FILTER_VALIDATE_INT);
            ///////////////////////////////////////////////////
            // $emp_id_combine = filter_input(INPUT_POST, 'flexRadioDefault', FILTER_SANITIZE_STRING);
            // $values = explode(',', $emp_id_combine);
            $emp_id = $_POST['e_id'];
            $emp_dep = filter_input(INPUT_POST, 'd_name', FILTER_SANITIZE_STRING);

            //echo "hi i love you".$emp_id;
            /////////////////////////////////////////////////////////
            $real_price = filter_input(INPUT_POST, 'real_price', FILTER_VALIDATE_FLOAT);
            $avg_price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
            $quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);
            $profit = filter_input(INPUT_POST, 'profit', FILTER_VALIDATE_FLOAT);
            $ad_datetime = filter_input(INPUT_POST, 'item_add_date', FILTER_SANITIZE_STRING);
            $user = $_SESSION['username'];

            // Validate the filtered inputs
            if ($item_id === null || $emp_id === null || $emp_dep === null || $real_price === false || $avg_price === false || $quantity === false || $profit === false || $ad_datetime === null || $user === null) {
                // Display error message or handle the validation failure
                $adduser_process_message = "Invalid input data";
                // Redirect to a new page with the value included as a query parameter
                header("Location: issue.php?value=" . urlencode($adduser_process_message));
                exit;
            }
            ///////// Database connection
            include '../layoutdbconnection.php';

            $sql = "SELECT ir.r_id, i.i_name, c.c_name, s.s_name, i.i_manufactured_by, i.i_size, i.i_unit, ip.p_unit_price, ir.p_stock 
            FROM tem_purchase_recive ir
            INNER JOIN item_purchase ip ON ip.p_id = ir.p_id
            INNER JOIN item i ON i.i_id = ip.i_id
            INNER JOIN category_item c ON c.c_id = i.c_id
            INNER JOIN supplier s ON s.s_id = ip.s_id            
            WHERE p_stock != 0 AND i.i_id = '$item_id'";

            $stmt = $conn->prepare($sql);
            if ($stmt->execute()) {
                // Output data of each row
                $records = array();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $records[] = $row;
                }
            } else {
                echo "0 results";
            }

            $qty = $records;
            $targetSum = $quantity;
            $currentSum = 0;
            $firstArray = array();
            $secondArray = array();
            for ($i = 0; $i < count($qty); $i++) {
                $currentSum += $qty[$i]['p_stock']; // Access the quantity number at index 1 of each sub-array
                // Continuous index.
                if ($currentSum < $targetSum) {
                    // First array
                    $firstArray[$i] = $qty[$i];
                }

                if ($currentSum == $targetSum || $currentSum > $targetSum) {
                    // This is the last index

                    $secondArray = $qty[$i];

                    $secondArray['p_stock'] = $qty[$i]['p_stock'] - ($currentSum - $targetSum) ;
                    //echo"<br>{$secondArray['p_stock']}<br>";

                    break;
                }
            }
            // Instead of using array_merge, we will directly assign the values from the secondArray to the last index of the firstArray
            $firstArray[count($firstArray)] = $secondArray;
            $issueArray = $firstArray; // The corrected issueArray
            ?>
            <?php
            $sql1="SELECT i_name FROM item WHERE i_id='$item_id'";
            $sql2="SELECT e_name,e_com_id FROM employee WHERE e_id='$emp_id'";
            

            
            $item_name = '';
            $employee_name = '';

            if ($result1 = $conn->query($sql1)) {
                $row = $result1->fetch(PDO::FETCH_ASSOC);
                $item_name = $row['i_name'];
            }

            if ($result2 = $conn->query($sql2)) {
                $row = $result2->fetch(PDO::FETCH_ASSOC);
                $employee_name = $row['e_name'];
                $employee_id= $row['e_com_id'];
            }
            ?>
            <h3 class="text-primary">Issue Information</h3>
            <table border='1'>
                <tr>
                    <td>Employee ID:</td>
                    <td><?php echo $employee_id; ?></td>
                    <td> Name:</td>
                    <td><?php echo $employee_name; ?></td>
                    
                </tr>
                <tr>
                    <td>Item PO Number:</td>
                    <td><?php echo $item_po_no; ?></td>
                    <td>Department:</td>
                    <td><?php echo $emp_dep; ?></td>
                    
                </tr>



                <tr>
                    
                    <td>Quantity:</td>
                    <td><?php echo $quantity; ?></td>
                    <td>Item Name:</td>
                    <td><?php echo $item_name; ?></td>
                </tr>



                <tr>
                    <td>Added Datetime:</td>
                    <td><?php echo $ad_datetime; ?></td>
                    <td>Issue by:</td>
                    <td><?php echo $_SESSION['username']; ?></td>
                </tr>

            </table>

            <style>
                table {
                    border-collapse: collapse;
                    width: 100%;
                }
                th{
                    background-color: rgba(203, 239, 167, 0.75);
                }
                th,
                td {
                    border: 1px solid black;
                    padding: 8px;
                    text-align: left;
                }
                tbody{
                    background-color: rgba(239, 248, 223, 0.6);
                }
            </style>

            <h4 class="text-success">Issue Items (materials details)</h4>
            <table>
                <thead>
                <tr>
                    <th>Lot No</th>
                    <th>Item</th>
                    <th>Category</th>
                    <th>Supplier</th>
                    <th>Brand</th>
                    <th>Size</th>
                    <th>Unit</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                </tr>
                </thead>

                <tbody>
                <?php
                $totalQuantity=0;
                $totalPrice=0;
                for ($i = 0; $i < count($issueArray); $i++) : ?>
                    <tr>
                        <td><?php echo $issueArray[$i]['r_id']; ?></td>
                        <td><?php echo $issueArray[$i]['i_name']; ?></td>
                        <td><?php echo $issueArray[$i]['c_name']; ?></td>
                        <td><?php echo $issueArray[$i]['s_name']; ?></td>
                        <td><?php echo $issueArray[$i]['i_manufactured_by']; ?></td>
                        <td><?php echo $issueArray[$i]['i_size']; ?></td>
                        <td><?php echo $issueArray[$i]['i_unit']; ?></td>
                        <td><?php echo $issueArray[$i]['p_unit_price']; ?></td>
                        <td><?php echo $issueArray[$i]['p_stock']; ?></td>
                        <td><?php echo $issueArray[$i]['p_stock'] * $issueArray[$i]['p_unit_price']; ?></td>
                        <?php
                        $totalQuantity += $issueArray[$i]['p_stock'];
                        $totalPrice += $issueArray[$i]['p_stock'] * $issueArray[$i]['p_unit_price'];
                        ?>
                    </tr>
                <?php endfor;
                echo '<tr><td colspan="8" style="text-align: right";>Total</td><td> '.$totalQuantity.' </td> <td> '.$totalPrice.'</td></tr>';
                ?>

                </tbody>
            </table>

            <h2></h2>
            <form action="issue_process3.php" method="post">
                <!-- Hidden input fields to store the data -->
                <input type="hidden" name="e_id" value="<?php echo htmlspecialchars($emp_id); ?>">
                <input type="hidden" name="d_name" value="<?php echo htmlspecialchars($emp_dep); ?>">

                <input type="hidden" name="item_po_no" value="<?php echo htmlspecialchars($item_po_no); ?>">
                <input type="hidden" name="i_id" value="<?php echo htmlspecialchars($item_id); ?>">
                <!-- <input type="hidden" name="flexRadioDefault" value="<?php //echo htmlspecialchars($emp_id_combine); ?>"> -->
                <input type="hidden" name="real_price" value="<?php echo htmlspecialchars($real_price); ?>">
                <input type="hidden" name="price" value="<?php echo htmlspecialchars($avg_price); ?>">
                <input type="hidden" name="quantity" value="<?php echo htmlspecialchars($quantity); ?>">
                <input type="hidden" name="profit" value="<?php echo htmlspecialchars($profit); ?>">
                <input type="hidden" name="item_add_date" value="<?php echo htmlspecialchars($ad_datetime); ?>">
                <input type="hidden" name="username" value="<?php echo htmlspecialchars($_SESSION['username']); ?>">
                <input type="hidden" name="issueArray" value="<?php echo htmlspecialchars(json_encode($issueArray)); ?>">

                <!-- Add other input fields or elements as needed -->

                <input type="submit" value="Confirm">
            </form>
            <br><br>

            <?php
            //$stmt->close();
            unset($conn);
            exit;
            ?>

        </div>
    </main>
        <!--######################################################################################################-->
    <!--###### Footer Part ###############################################-->
    <?php
    include '../template/footer.php';
    ?>
    <!--#####################################################-->





