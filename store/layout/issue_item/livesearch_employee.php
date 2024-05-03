<?php
session_start();
include '../layoutdbconnection.php';

if (isset($_POST['input']) && isset($_GET['var'])) {
    $input = $_POST['input'];
    $item_id = $_GET['var'];

    if ($input === null || $item_id === null || $item_id === false) {
        echo "Invalid input data.";
        exit;
    }

    // Create a PDO connection to your Microsoft SQL Server database
    $serverName = "BDAPPSS02V\SQLEXPRESS";
    $connectionOptions = array(
        "Database" => "hlfs",
        "Uid" => "sa",
        "PWD" => "sa@123"
    );

    try {
        $conn = new PDO("sqlsrv:Server=$serverName;Database={$connectionOptions['Database']}", $connectionOptions['Uid'], $connectionOptions['PWD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }

    // Prepare and execute the SQL statement with parameter binding
    $searchInput = "%{$input}%";
    $stmt = $conn->prepare("
        SELECT e.e_name, e.e_id, d.d_name, e.e_com_id, 
            COALESCE(iss.is_qty, 0) AS is_qty, 
            COALESCE(iss.is_item_issue_by, '-') AS is_item_issue_by, 
            ISNULL(CONVERT(VARCHAR, TRY_CAST(iss.is_datetime AS DATETIME), 120), '-') AS is_datetime, 
            iss.is_active
        FROM employee e
        LEFT JOIN (
            SELECT ii.e_id, ii.is_qty, ii.is_datetime, ii.is_item_issue_by, ii.is_active
            FROM item_issue ii
            WHERE ii.i_id = ? AND ii.is_active = 1
                AND ii.is_datetime = (
                    SELECT MAX(ii2.is_datetime)
                    FROM item_issue ii2
                    WHERE ii2.e_id = ii.e_id
                        AND ii2.i_id = ii.i_id
                )
        ) iss ON iss.e_id = e.e_id
        INNER JOIN department d ON d.d_id = e.d_id
        WHERE e.e_active = 1 AND (e.e_name LIKE ? OR e.e_com_id LIKE ?)");

    if ($stmt->execute([$item_id, $searchInput, $searchInput])) {
        echo '<table class="table table-striped bg-white">';
        echo '<thead>';
        echo '<tr><th>Select</th><th>Name</th><th>ID</th><th>Department</th><th>Last Quantity</th><th>Issue Data Time</th><th>Issue by</th></tr>';
        echo '</thead>';
        echo '<tbody>';

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr>';
            echo '<td><input required type="radio" name="flexRadioDefault" value="' . $row['e_id'] . ',' . $row['d_name'] . '"></td>';
            echo '<td>' . $row['e_name'] . '</td>';
            echo '<td>' . $row['e_com_id'] . '</td>';
            echo '<td>' . $row['d_name'] . '</td>';
            echo '<td>' . $row['is_qty'] . '</td>';
            echo '<td>' . $row['is_datetime'] . '</td>';
            echo '<td>' . $row['is_item_issue_by'] . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo "No options found.";
    }

    // Close the statement and database connection
    $stmt = null;
    $conn = null;
    exit;
}
?>
