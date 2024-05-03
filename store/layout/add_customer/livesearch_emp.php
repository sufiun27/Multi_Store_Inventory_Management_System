<?php
session_start();
include '../layoutdbconnection.php';

if (isset($_POST['input'])) {
    $input = $_POST['input'];

    $db=$_SESSION['company'];

    // Create a connection to your SQL Server database
    $serverName = "BDAPPSS02V\SQLEXPRESS";
    $connectionOptions = array(
        "Database" => "$db",
        "Uid" => "sa",
        "PWD" => "sa@123"
    );

    $conn = sqlsrv_connect($serverName, $connectionOptions);

    if (!$conn) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Prepare the SQL statement with a parameterized query
    $sql = "SELECT * FROM employee 
            INNER JOIN department ON employee.d_id = department.d_id 
            WHERE employee.e_com_id LIKE ? OR employee.e_name LIKE ?";

    $params = array("%$input%", "%$input%");
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Fetch results
    echo '<table class="table">
            <thead>
                <tr>
                    <th>Customer ID</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Designation</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>';

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        echo '<tr>
                <td>'.$row["e_com_id"].'</td>
                <td>'.$row["e_name"].'</td>
                <td>'.$row["d_name"].'</td>
                <td>'.$row["e_designation"].'</td>';

        if ($row["e_active"] == 1) {
            echo '<td class="text-success">
                    <i class="fa-solid fa-check"></i>
                    <a href="adduser_list_status_deactive.php?id='.$row["e_id"].'" class="btn btn-warning btn-sm"><i class="fa-solid fa-xmark"></i></a>
                  </td>';
        } else {
            echo '<td class="text-danger">
                    <i class="fa-solid fa-xmark"></i>
                    <a href="adduser_list_status_active.php?id='.$row["e_id"].'" class="btn btn-success btn-sm"><i class="fa-solid fa-check"></i></a>
                  </td>';
        }

        echo '<td>
                <a href="adduser_list_edit.php?id='.$row["e_id"].'&name='.$row["e_name"].'&department='.$row["d_name"].'&designation='.$row["e_designation"].'&comid='.$row["e_com_id"].'" class="btn btn-primary btn-sm"><i class="fa-solid fa-pen-to-square"></i></a>
                <a href="adduser_list_delete.php?id='.$row["e_id"].'" class="btn btn-danger btn-sm"><i class="fa-solid fa-xmark"></i></a>
              </td>
            </tr>';
    }

    echo '</tbody></table>';

    // Clean up the statement and close the connection
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);
} else {
    echo "No input provided.";
}
?>
