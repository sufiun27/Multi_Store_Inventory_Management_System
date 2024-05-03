<style>
    .custom-info-row {
        display: none;
    }

    /* Add styles to the main table */
    .table {
        width: 100%;
    }

    .table th {
        background-color: #a3f8a3;
        text-align: center;
    }

    .table td {
        text-align: center;
    }

    /* Add styles to the materials information table */
    .custom-info-content table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .custom-info-content th,
    .custom-info-content td {
        padding: 5px;
        border: 1px solid #dee2e6;
    }

    .custom-info-content th {
        background-color: #f8f9fa;
    }
</style>

<table class="table table-striped">
    <thead>
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
        <th>Added DateTime</th>
        <th>issue By</th>
        <th>Employee ID</th>
        <th>Employee</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
    session_start();
    include '../layoutdbconnection.php';

    if (isset($_POST['input'])) {
        $input = filter_input(INPUT_POST, 'input', FILTER_SANITIZE_STRING);
        $section = $_SESSION['section'];

        // Prepare the SQL statement with parameterized query
        $sql = "SELECT iss.is_po_no, iss.is_id, i.i_name, c.c_name,
                  i.i_manufactured_by, i.i_size, i.i_unit, iss.is_avg_price, 
                  iss.is_qty, ist.total_price as total_price, iss.is_datetime, 
                  iss.is_item_issue_by, e.e_com_id, e.e_name
                  FROM item_issue iss 
                  INNER JOIN item i ON iss.i_id = i.i_id 
                  INNER JOIN employee e ON iss.e_id = e.e_id
                  INNER JOIN category_item c ON i.c_id = c.c_id
                  INNER JOIN (SELECT SUM(ist_qty*ist_price) as total_price, is_id FROM item_issue_trac GROUP BY is_id) ist ON ist.is_id = iss.is_id
                  WHERE i.section=? AND ( iss.is_po_no LIKE ? OR i.i_name LIKE ? OR c.c_name LIKE ? OR e.e_name LIKE ? OR e.e_com_id LIKE ? OR iss.is_datetime LIKE ? )
                  
                  ORDER BY iss.is_datetime DESC";

        $stmt = $conn->prepare($sql);
        if ($stmt) {
            // Bind parameters and execute the query
            $param = "%{$input}%";
            // $stmt->bind_param("sssss", $param, $param, $param, $param, $param);
            // $stmt->execute();
            // $result = $stmt->get_result();

            if ($stmt->execute([$section, $param, $param, $param, $param, $param , $param])) {
                while ($product = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($product['is_po_no']) . "</td>";
                    echo "<td>" . htmlspecialchars($product['i_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($product['c_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($product['i_manufactured_by']) . "</td>";
                    echo "<td>" . htmlspecialchars($product['i_size']) . "</td>";
                    echo "<td>" . htmlspecialchars($product['i_unit']) . "</td>";
                    echo "<td>" . htmlspecialchars($product['is_avg_price']) . "</td>";
                    echo "<td>" . htmlspecialchars($product['is_qty']) . "</td>";
                    echo "<td>" . htmlspecialchars($product['total_price']) . "</td>";
                    echo "<td>" . htmlspecialchars($product['is_datetime']) . "</td>";
                    echo "<td>" . htmlspecialchars($product['is_item_issue_by']) . "</td>";
                    echo "<td>" . htmlspecialchars($product['e_com_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($product['e_name']) . "</td>";
                    echo '<td><button class="custom-info-button" type="button">+</button></td>';
                    echo "</tr>";

                    // Include the custom-info-row within each loop iteration
                    echo '<tr class="custom-info-row">
                              <td colspan="14">
                                <div class="custom-info-content">';
                    $issueid = $product['is_id'];
                    $stmt2 = "SELECT r_id, ist_qty, ist_price FROM item_issue_trac WHERE is_id='{$issueid}'";
                    $result2 = $conn->prepare($stmt2);
                    $result2->execute();
                    echo '<table style="background-color: rgba(239,245,180,0.72);">
                              <tr>
                                  <th>Lot No</th>
                                  <th>Quantity</th>
                                  <th>Price</th>
                              </tr>';
                    while ($row = $result2->fetch(PDO::FETCH_ASSOC)) {
                        echo '<tr>
                                  <td>' . htmlspecialchars($row['r_id']) . '</td>
                                  <td>' . htmlspecialchars($row['ist_qty']) . '</td>
                                  <td>' . htmlspecialchars($row['ist_price']) . '</td>
                                </tr>';
                    }
                    echo '</table>';

                    echo  '</div>
                            </td>
                          </tr>';
                }
            } else {
                echo "No records found.";
            }

            // Close result and statement
           // $result->close();
            //$stmt->close();
        } else {
            echo "Error in preparing the statement.";
        }

        // Close database connection
        //mysqli_close($conn);
    }
    ?>
    </tbody>
</table>

<script>
    // Add event listeners to the buttons
    var buttons = document.getElementsByClassName("custom-info-button");

    for (var i = 0; i < buttons.length; i++) {
        buttons[i].addEventListener("click", toggleInfo);
    }

    // Function to toggle the visibility of the info row
    function toggleInfo() {
        var row = this.parentNode.parentNode.nextElementSibling;

        if (row.classList.contains("custom-info-row")) {
            if (row.style.display === "table-row") {
                row.style.display = "none";
            } else {
                row.style.display = "table-row";
            }
        }
    }
</script>