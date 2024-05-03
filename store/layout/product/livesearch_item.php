<?php


session_start();
include '../layoutdbconnection.php';

if (isset($_POST['input'])) {
    $input = $_POST['input'];
    $input = "%$input%";
    $section = $_SESSION['section'];
    // Prepare the SQL statement
    $sql = "SELECT
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
            WHERE
                (i.section = '$section') AND
                (i.i_name LIKE ? OR
                i.i_manufactured_by LIKE ? OR
                c.c_name LIKE ?)
            ORDER BY
                i.i_add_datetime DESC";

    $stmt = $conn->prepare($sql);
    //$stmt->bindParam(':input', $input, PDO::PARAM_STR);
    $stmt->execute([$input, $input, $input]);
    
    echo '<table class="table">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Size</th>
                        <th>Unit</th>                            
                        <th>Unit Price</th>
                        <!--<th>Issue Avg Price</th>-->
                        <th>Stock</th>
                        <th>Remainder</th>
                        <th>Added DateTime</th>
                        <th>Update DateTime</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';
    
        // Display the options
        while ($product = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($product['i_name']) . "</td>";
            echo "<td>" . htmlspecialchars($product['c_name']) . "</td>";
            echo "<td>" . htmlspecialchars($product['i_manufactured_by']) . "</td>";
            echo "<td>" . htmlspecialchars($product['i_size']) . "</td>";
            echo "<td>" . htmlspecialchars($product['i_unit']) . "</td>";
            echo "<td>" . htmlspecialchars($product['i_price']) . "</td>";
            //echo "<td>" . htmlspecialchars($product['item_issue_avg_price']) . "</td>";
            echo "<td>" . htmlspecialchars($product['qty_balance']) . "</td>";
            echo "<td>" . htmlspecialchars($product['stock_out_reminder_qty']) . "</td>";
            echo "<td>" . htmlspecialchars($product['i_add_datetime']) . "</td>";
            echo "<td>" . htmlspecialchars($product['i_update_datetime']) . "</td>";

            if ($product['i_active'] == 1) {
                echo '<td class="text-success">
                        <i class="fa-solid fa-check"></i>
                        <a href="product_list_status_deactive.php?id=' . htmlspecialchars($product["i_id"]) . '" class="btn btn-warning btn-sm">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    </td>';
            } else {
                echo '<td class="text-danger">
                        <i class="fa-solid fa-xmark"></i>
                        <a href="product_list_status_active.php?id=' . htmlspecialchars($product["i_id"]) . '" class="btn btn-success btn-sm">
                            <i class="fa-solid fa-check"></i>
                        </a>
                    </td>';
            }

            echo "<td>
                    <div class=\"btn-group\">";
            if ($_SESSION['role'] == 'admin') {
                echo "<a href=\"product_edit.php?p_id=" . htmlspecialchars($product['i_id']) . "\">
                        <button type=\"button\" class=\"btn btn-success btn-sm\">
                            <i class=\"fa-solid fa-pen-to-square\"></i>
                        </button>
                    </a>";

                if ($product['total_item_purchase'] == 0 && $product['total_item_issue'] == 0) {
                    echo "<a href=\"product_delete.php?p_id=" . htmlspecialchars($product['i_id']) . "\">
                            <button type=\"button\" class=\"btn btn-danger btn-sm\">
                                <i class=\"fa-solid fa-xmark\"></i>
                            </button>
                        </a>";
                } else {
                    echo '<span ><i class="fa-solid fa-lock"></i></sapan>';
                }
            }

            echo "</td>";
            echo "</tr>";
        }

        echo '</tbody></table>';
        }
  
    
    // Release the connection resources
    unset($conn);
    exit;

?>
