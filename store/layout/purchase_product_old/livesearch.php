<?php
// Database configuration for different stores
session_start();
include '../layoutdbconnection.php';

if (isset($_POST['input'])) {
    $input = filter_input(INPUT_POST, 'input', FILTER_SANITIZE_STRING);

    // Prepare the SQL statement using prepared statements with question mark placeholders
    $sql = "SELECT i.i_id, i.i_name, b.qty_balance, c.c_name, i.i_manufactured_by, i.i_size, i.i_unit, i.i_price
            FROM item i
            LEFT JOIN balance b ON i.i_id = b.i_id
            INNER JOIN category_item c ON i.c_id = c.c_id
            WHERE i.i_active = 1 AND c.c_active = 1 and i.section = ?
            AND (i.i_name LIKE ? OR c.c_name LIKE ? OR i.i_manufactured_by LIKE ?)";

    $stmt = $conn->prepare($sql);

    // Bind the input parameter to the placeholders
    $likeInput = "%$input%";
    $stmt->bindParam(1, $_SESSION['section'], PDO::PARAM_STR);
    $stmt->bindParam(2, $likeInput, PDO::PARAM_STR);
    $stmt->bindParam(3, $likeInput, PDO::PARAM_STR);
    $stmt->bindParam(4, $likeInput, PDO::PARAM_STR);
    
    if ($stmt->execute()) {
        echo '<table class="table table-striped">
                <thead>
                <tr>
                    <th>Item</th>
                    <th>Category</th>
                    <th>Brand</th>
                    <th>Size</th>
                    <th>Unit</th>
                    <th>Price</th>
                    <th>Stock</th>
                </tr>
                </thead>
                <tbody>';

        // Display the options
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr>
                    <td>' . htmlspecialchars($row["i_name"]) . '</td>
                    <td>' . htmlspecialchars($row["c_name"]) . '</td>
                    <td>' . htmlspecialchars($row["i_manufactured_by"]) . '</td>
                    <td>' . htmlspecialchars($row["i_size"]) . '</td>
                    <td>' . htmlspecialchars($row["i_unit"]) . '</td>
                    <td>' . htmlspecialchars($row["i_price"]) . '</td>
                    <td>' . htmlspecialchars($row['qty_balance']) . '</td>
                    <td>
                        <a href="purchase_item_process.php?id=' . $row["i_id"] . '" class="btn btn-primary">Select</a>
                    </td>
                </tr>';
        }

        echo '</tbody></table>';
    } else {
        echo "Error executing the search query.";
    }
    
    // Close the statement and database connection
    unset($conn);
    exit;
}
?>
