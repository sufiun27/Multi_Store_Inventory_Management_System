<?php

session_start();
include '../layoutdbconnection.php';

if (isset($_POST['input'])) {
    $input = filter_input(INPUT_POST, 'input', FILTER_SANITIZE_STRING);

    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT e_id,store, e_com_id,e_name,d_name 
    from employee INNER JOIN department ON department.d_id=employee.d_id
    WHERE store is not null AND (e_name LIKE ? OR e_com_id LIKE ?)
    ");

    // Bind and execute the statement with the filtered input
    $searchInput = "%{$input}%";
    //$stmt = $conn->prepare($sql);
    //$stmt->bind_param("sss", $searchInput, $searchInput, $searchInput);
    //$stmt->execute([$searchInput, $searchInput]);

    // Get the result set
    //$result = $stmt->get_result();

    if ($stmt->execute([$searchInput, $searchInput])) {
        echo '<table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Department</th>
                <th>Store</th>
                
                <th></th>
            </tr>
        </thead>
        <tbody>';

        // Display the options
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr>
            <td>' . $row["e_com_id"] . '</td>
            <td>' . $row["e_name"] . '</td>
            <td>' . $row["d_name"] . '</td>
            <td>' . $row["store"] . '</td>
            
            <td>
            <a href="issue_process1.php?id='.$row["e_id"].'" class="btn btn-primary">Select</a>
            </td>
          </tr>';
        }

        echo '</tbody></table>';
    } else {
        echo "No options found.";
    }

    // Close the statement and database connection
    unset($conn);
    exit;
}
?>
