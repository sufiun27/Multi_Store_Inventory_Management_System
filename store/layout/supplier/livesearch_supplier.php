<?php
session_start();

$user_name = $_SESSION['username'];
$user_company = $_SESSION['company'];
$user_role = $_SESSION['role'];

$database = $user_company;

try {
    $serverName = 'BDAPPSS02V\SQLEXPRESS';
    $database = $database;
    
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$database", "sa", "sa@123");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['input'])) {
        $input = $_POST['input'];
        $param = "%$input%";
        // Prepare the SQL statement with parameters to prevent SQL injection
        $sql = "SELECT * FROM supplier WHERE s_name LIKE ? OR s_email LIKE ? OR s_phone LIKE ?";
        $stmt = $conn->prepare($sql);
        
        //$stmt->bindParam(':input', $param);

        if ($stmt->execute([$param,$param,$param])) {
            echo '<table class="table table-striped" style="background: rgba(217, 217, 217,90%);">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Contract</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>';

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>
                            <td>' . $row["s_name"] . '</td>
                            <td>' . $row["s_phone"] . '</td>
                            <td>' . $row["s_email"] . '</td>
                            <td>' . $row["s_address"] . '</td>';

                if ($row["s_active"] == 1) {
                    echo '<td class="text-success">
                            <i class="fa-solid fa-check"></i>
                            <a href="supplier_deactive.php?id=' . $row["s_id"] . '" class="btn btn-warning btn-sm"><i class="fa-solid fa-xmark"></i></a>
                            </td>';
                } else {
                    echo '<td class="text-danger">
                            <i class="fa-solid fa-xmark"></i>
                            <a href="supplier_active.php?id=' . $row["s_id"] . '" class="btn btn-success btn-sm"><i class="fa-solid fa-check"></i></a>
                            </td>';
                }

                echo '<td>
                        <a href="supplier_edit.php?id=' . $row["s_id"] . '" class="btn btn-primary btn-sm"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href="supplier_delete.php?id=' . $row["s_id"] . '" class="btn btn-danger btn-sm"><i class="fa-solid fa-xmark"></i></a>
                        </td>
                        </tr>';
            }

            echo '</tbody></table>';
        } else {
            echo "No options found.";
        }

        // Close the database connection
        $conn = null;
        exit;
    }
} catch (Exception $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
