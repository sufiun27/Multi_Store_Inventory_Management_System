<!--main content////////////////////////////////////////////////////////////////////////////////-->

<table class="table table-striped">
    <thead>
    <tr>
        <th></th>
        <th>Po No</th>
        <th>Item Name</th>
        <th>Category</th>
        <th>Unit</th>
        <th>Size</th>
        <th>Unit Price</th>
        <th>Req/Accept Qty</th>
        <th>Total Price</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php
    session_start();
    include '../layoutdbconnection.php';

    if (isset($_POST['input'])) {
        //$input = filter_input(INPUT_POST, 'input', FILTER_SANITIZE_STRING);

        // Prepare the SQL statement using prepared statements
        $input = $_POST['input'];
        //echo $input;
        $input = "%$input%";

        // Prepare the SQL statement
        $sql = "SELECT 
                    COALESCE(r.total_recive, 0) AS total_recive, 
                    ip.p_req_qty, 
                    ip.p_id, 
                    ip.p_po_no, 
                    i.i_name, 
                    c.c_name, 
                    i.i_unit, 
                    i.i_size, 
                    ip.p_unit_price, 
                    ip.p_unit_price * ip.p_req_qty AS total_price, 
                    ip.p_profit, 
                    ip.p_request_datetime, 
                    s.s_name, 
                    ip.p_purchase_by, 
                    ip.p_request, 
                    ip.p_recive, 
                    ip.p_request_accept_by
                FROM item_purchase ip
                INNER JOIN item i ON ip.i_id = i.i_id 
                INNER JOIN supplier s ON ip.s_id = s.s_id 
                INNER JOIN category_item c ON i.c_id = c.c_id
                LEFT JOIN (
                    SELECT p_id, SUM(p_recive_qty) AS total_recive 
                    FROM tem_purchase_recive 
                    GROUP BY p_id
                ) r ON ip.p_id = r.p_id
                WHERE i.i_name LIKE ? OR c.c_name LIKE ? OR s.s_name LIKE ? OR ip.p_purchase_by LIKE ? OR CONVERT(varchar, ip.p_request_datetime, 120) LIKE ?
                ORDER BY ip.p_request_datetime DESC";
        
        $stmt = $conn->prepare($sql);
        
        
        echo "search:".$input."<br>";

        if ($stmt->execute([$input, $input, $input, $input, $input])) {
            //$result = $stmt->get_result();
                   // echo "ok";
         //if ($result->num_rows > 0) {
            $product = $stmt->fetchAll(PDO::FETCH_ASSOC);
                //print_r($product);
                foreach ($product as $product) {
                    echo "<tr>";
                    echo "<td><button class=\"info-button\" type=\"button\">+</button></td>";
                    echo "<td>" . htmlspecialchars($product['p_po_no']) . "</td>";
                    echo "<td>" . htmlspecialchars($product['i_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($product['c_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($product['i_unit']) . "</td>";
                    echo "<td>" . htmlspecialchars($product['i_size']) . "</td>";
                    echo "<td>" . htmlspecialchars($product['p_unit_price']) . "</td>";
                    echo "<td>" . htmlspecialchars($product['p_req_qty']) . " / " . htmlspecialchars($product['total_recive']) . "</td>";
                    echo "<td>" . htmlspecialchars($product['total_price']) . "</td>";
                    echo "<td><div class=\"btn-group\">";

                    if ($product['total_recive'] == $product['p_req_qty']) {
                        echo "<button type=\"button\" class=\"btn btn-success btn-sm\">Completed</button>";
                    } elseif ($product['p_recive'] == '1') {
                        echo "<button type=\"button\" class=\"btn btn-primary btn-sm\">Received</button>";
                    } elseif ($_SESSION['role'] == 'admin') {
                        if ($product['p_request'] == '0') {
                            echo "<a href=\"purchase_list_process_request.php?p_id=" . htmlspecialchars($product['p_id']) . "\"><button type=\"button\" class=\"btn btn-success btn-sm\">Accept</button></a>";
                        } else {
                            if ($product['p_recive'] == '0') {
                                echo "<a href=\"purchase_list_process_request_unaccept.php?p_id=" . htmlspecialchars($product['p_id']) . "\"><button type=\"button\" class=\"btn btn-success btn-sm\">Unaccept</button></a>";
                            } else {
                                echo "<span class=\"text-success\">Accepted | </span>";
                            }
                        }
                    }

                    if ($product['p_recive'] == '0' && $product['p_request'] == '0') {
                        echo "<a href=\"purchase_list_process_delete.php?p_id=" . htmlspecialchars($product['p_id']) . "\"><button type=\"button\" class=\"btn btn-danger btn-sm\">Delete</button></a>";
                    } else {
                        echo "<span class=\"text-danger\">  </span>";
                    }

                    echo "</div></td>";
                    echo "</tr>";

                    echo '<tr class="info-row bg-light" style="display: none;">
                                <td colspan="10">
                                    <div class="hidden-heading">
                                        
                                    </div>
                                    <div class="info-content " style="background: rgba(245, 39, 183, 0.50);">
                                        <table class="table table-striped">
                                            <tr>
                                                <th>Add Date Time</th>
                                                
                                                <th>Supplier</th>
                                                <th>Purchase by</th>
                                                <th>Accepted by</th>
                                                
                                            </tr>
                                            <tr>
                                                <td>' . htmlspecialchars($product['p_request_datetime']) . '</td>
                                                
                                                <td>' . htmlspecialchars($product['s_name']) . '</td>
                                                <td>' . htmlspecialchars($product['p_purchase_by']) . '</td>
                                                <td>' . htmlspecialchars($product['p_request_accept_by']) . '</td>
                                            </tr>
                                        </table>';

                                        $p_id = $product['p_id'];
$sql_receive = "SELECT * FROM tem_purchase_recive WHERE p_id = ?";
$stmt = $conn->prepare($sql_receive);

if ($stmt->execute([$p_id])) {
    $count = 0;
    echo '<table class="table table-striped">';
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
                <td>' . htmlspecialchars($receive_product['p_recive_qty']) . '</td>
                <td>' . htmlspecialchars($receive_product['p_recive_datetime']) . '</td>
                <td>' . htmlspecialchars($receive_product['p_expaired_datetime']) . '</td>
                <td>' . htmlspecialchars($receive_product['p_recive_by']) . '</td>
            </tr>
        ';
    }

    echo '</table>';
}

echo '<h5><u>Receive - total receive Qty (' . htmlspecialchars($product['total_recive']) . ') - Remaining Qty (' . (htmlspecialchars($product['p_req_qty']) - htmlspecialchars($product['total_recive'])) . ')</u></h5>';

if ($product['p_request'] == '1') {
    if ($product['total_recive'] < $product['p_req_qty']) {
        echo '
            <form action="purchase_list_process_recive_search.php" method="post" onsubmit="return validateNumber();">
                <label for="receive_qty_' . $product['p_id'] . '">Receive Quantity:</label>
                <input name="receive_qty" id="receive_qty_' . $product['p_id'] . '" type="number" placeholder="Receive Quantity" required />
                <input name="p_id" id="p_id" type="number" value="' . htmlspecialchars($product['p_id']) . '" hidden />
                <label for="expaired_datetime_' . $product['p_id'] . '">Expiry Date and Time:</label>
                <input name="expaired_datetime" id="expaired_datetime_' . $product['p_id'] . '" type="datetime-local"  />
                <button class="bg-success text-light">Submit</button>
                <p id="message_' . $product['p_id'] . '" style="display: none;"></p>
            </form>
        ';
    }
}
?>

<script>
<?php
// JavaScript loop to add event listeners for each unique form
if ($product['p_request'] == '1' && $product['total_recive'] < $product['p_req_qty']) {
    echo "document.addEventListener('DOMContentLoaded', function() {\n";
    echo "    const inputNumber = document.getElementById('receive_qty_" . $product['p_id'] . "');\n";
    echo "    const message = document.getElementById('message_" . $product['p_id'] . "');\n";
    echo "    inputNumber.addEventListener('input', function() {\n";
    echo "        const value = parseInt(inputNumber.value);\n";
    echo "        if (value > " . ($product['p_req_qty'] - $product['total_recive']) . ") {\n";
    echo "            message.style.display = 'block';\n";
    echo "            message.textContent = 'Input is greater than " . ($product['p_req_qty'] - $product['total_recive']) . ".';\n";
    echo "        } else {\n";
    echo "            message.style.display = 'none';\n";
    echo "        }\n";
    echo "    });\n";
    echo "});\n";
}
?>
</script>
                                            <?php
                                            } else {
                                                echo "<span class=\"text-primary\">Received</span>";
                                            }
                                        } else {
                                            echo "<span class=\"text-primary\">| After accept can be received</span>";
                                        }
                                       

                    echo '</div>
                                </td>
                            </tr>';

                    // Row for receiving items
                }
            // } else {
            //     echo "No records found.";
            // }

            // Close the statement and database connection
            unset($conn);
    exit;
        }
    }
    ?>
    </tbody>
</table>
