<!--### Header Part ##################################################-->
<?php
include '../template/header.php';
?>
<style>
    td, th {
        font-size: 10px; /* Increase the font size */
         /* Make the text bold */
    }
    th{
        font-weight: bold;
    }
</style>
<!--#####################################################-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Add 'show' class to the element with ID "collapseLayouts2"
    $(document).ready(function() {
        $("#collapseLayouts").addClass("show");
        $("#collapseLayouts_department").addClass("active bg-success");
    });
</script>

<div id="layoutSidenav_content">
    <!--view user list -////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

    <main>
        <div class="container-fluid px-4">

            <!--display this massage for 3 seconds-->
            <div id="message">
                <?php
                if (isset($_GET['massage'])) {

                    $message = $_GET['massage'];
                    echo $message;
                }
                ?>
            </div>
            <script>
                setTimeout(function() {
                    var messageElement = document.getElementById('message');
                    messageElement.style display = 'none';
                }, 3000);
            </script>
            <!--display this massage for 3 seconds-->

            <?php
            // Include your SQL Server connection file here (e.g., 'sqlsrv_connection.php')
            include('../../../hostingDBinfo.php');
            
            $user_company = $_SESSION['company'];
            $database = $user_company;
            
            try {
                $conn = new PDO("sqlsrv:Server=$servername;Database=$database", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                // Fetch department information from the database
                $sql = "SELECT d.d_active, d.d_id, d.d_full_name, d.d_name , ISNULL(e.total_employee, 0) as total_employee
                        FROM department d 
                        LEFT JOIN (
                            SELECT d_id, COUNT(e_id) as total_employee from employee GROUP BY d_id
                        ) e 
                        ON e.d_id = d.d_id";

                $result = $conn->query($sql);

                if ($result) {
                    echo '<div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            DataTable Example
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Department</th>
                                        <th>Name</th>
                                        <th>Total employee</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>';

                    foreach ($result as $row) {
                        echo '<tr>
                                <td>' . $row["d_name"] . '</td>
                                <td>' . $row["d_full_name"] . '</td>
                                <td>' . $row["total_employee"] . '</td>';

                        if ($row["d_active"] == 1) {
                            echo '<td class="text-success">
                                <i class="fa-solid fa-check"></i>
                                <a href="adduser_Department_list_deactive.php?id=' . $row["d_id"] . '" class="btn btn-warning btn-xs"><i class="fa-solid fa-xmark"></i></a>
                                </td>';
                        } else {
                            echo '<td class="text-danger">
                                <i class="fa-solid fa-xmark"></i>
                                <a href="adduser_Department_list_active.php?id=' . $row["d_id"] . '" class="btn btn-success btn-xs"><i class="fa-solid fa-check"></i></a>
                                </td>';
                        }

                        echo '<td>
                                <a href="adduser_list_department_edit.php?id=' . $row["d_id"] . '" class="btn btn-primary btn-xs"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="adduser_dep_delete.php?id=' . $row["d_id"] . '" class="btn btn-danger btn-xs"><i class="fa-solid fa-xmark"></i></a>
                                </td>
                              </tr>';
                    }

                    echo '</tbody></table>';
                } else {
                    echo "No records found.";
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            } finally {
                // Close the SQL Server connection
                $conn = null;
            }
            ?>
        </div>
    </main>
    <!--end view user list -////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

    <!--###### Footer Part ###############################################-->
    <?php
    include '../template/footer.php';
    ?>
    <!--#####################################################-->
