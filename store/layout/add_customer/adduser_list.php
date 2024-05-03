<!--### Header Part ##################################################-->
<?php
include '../template/header.php';
?>
<style>
    td,th {
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
        $("#collapseLayouts_list").addClass("active bg-success");
    });
</script>

<div id="layoutSidenav_content">
    <!--view user list -////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

    <main>
        <div class="container-fluid px-4">
            <h4 class="bg-success text-light p-1"><?php if(isset($_GET['value'])){echo $_GET['value'];} else{echo "";}?></h4>
            <?php
include '../layoutdbconnection.php';
// Fetch company names from the database
$sql = "SELECT * FROM employee INNER JOIN department ON employee.d_id = department.d_id ORDER BY e_add_date_time DESC ";

try {
    $result = $conn->query($sql);

    if ($result !== false) {
        echo '<div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                DataTable Example
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                    <tr>
                        <th>Customer ID</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Designation</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>';

        $count = 0;
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $count++;
            echo '<tr>
                    <td>'.$row["e_com_id"].'</td>
                    <td>'.$row["e_name"].'</td>
                    <td>'.$row["d_name"].'</td>
                    <td>'.$row["e_designation"].'</td>
                    <td>'.$row["user_type"].'</td>
                    ';
                    

            if($row["e_active"]==1){
                echo '<td >
                        ok
                        <a href="adduser_list_status_deactive.php?id='.$row["e_id"].'" class="btn btn-warning btn-xs">X</a>
                    </td>';
            } else {
                echo '<td >
                        x
                        <a href="adduser_list_status_active.php?id='.$row["e_id"].'" class="btn btn-success btn-xs">ok</a>
                    </td>';
            }

            echo '<td>
                    <a href="adduser_list_edit.php?id='.$row["e_id"].'&name='.$row["e_name"].'&department='.$row["d_name"].'&designation='.$row["e_designation"].'&comid='.$row["e_com_id"].'" class="btn btn-primary btn-xs">Edit</a>
                    <a href="adduser_list_delete.php?id='.$row["e_id"].'" class="btn btn-danger btn-xs">X</a>
                </td>';
              echo'</tr>';
        }

        echo '</tbody></table>';
    } else {
        echo "No records found.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close database connection
$conn = null;
?>








        </div>
    </main>
    <!--end view user list -////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

    <!--###### Footer Part ###############################################-->
    <?php
    include '../template/footer.php';
    ?>
    <!--#####################################################-->

    <style>
        /* Reduce row spacing */


        /* Apply styles to every second row */
        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</div>
