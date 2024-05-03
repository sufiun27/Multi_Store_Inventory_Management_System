<!--### Header Part ##################################################-->
<?php
include '../template/header.php';
?>
<style>
    td, th {
        font-size: 10px;
        /* Increase the font size */
        /* Make the text bold */
    }

    th {
        font-weight: bold;
    }
</style>

<!--#####################################################-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Add 'show' class to the element with ID "collapseLayouts2"
    $(document).ready(function () {
        $("#collapseLayouts4").addClass("show");
        $("#collapseLayouts4_add").addClass("active bg-success");
    });
</script>

<div id="layoutSidenav_content">
    <!--view user list -////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

    <main>
        <div class="container-fluid px-4">
            <h4 class="bg-success text-light p-1"><?php if (isset($_GET['value'])) {
                                                    echo $_GET['value'];
                                                } else {
                                                    echo "";
                                                } ?></h4>
            <?php
            include '../layoutdbconnection.php';

            if (!isset($_GET['id'])) {
                echo "No ID provided.";
                exit;
            }
            $section = $_SESSION['section'];
            //echo $section;
            $id = $_GET['id'];
            //echo $id;
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);

            // Fetch company names from the database
            $sql = "SELECT *
        FROM employee AS e
        INNER JOIN department AS d ON d.d_id = e.d_id
        INNER JOIN item_issue AS iss ON iss.e_id = e.e_id 
        INNER JOIN item AS i ON i.i_id = iss.i_id
        INNER JOIN category_item AS c ON c.c_id = i.c_id
        WHERE e.e_id LIKE :id AND i.section = :section
        AND iss.is_datetime BETWEEN DATEADD(MONTH, -1, GETDATE()) AND GETDATE()
        ORDER BY iss.is_datetime DESC";
            $stmt = $conn->prepare($sql);

            // Bind parameters and execute the statement
            $searchInput = "%{$id}%";
            $stmt->bindParam(':id', $searchInput, PDO::PARAM_STR);
            $stmt->bindParam(':section', $section, PDO::PARAM_STR);

            try {
                $stmt->execute(); // Execute the statement
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($result) {
                    echo '<div class="card mb-4">
            <div class="card-header">
                
                
                <table class="table table-striped">
                <thead>
                    <tr>
                        <th><i class="fas fa-table me-1"></i></th>
                        <th>ID : ' . $result[0]["e_com_id"] . '</th>
                        <th>Name : ' . $result[0]["e_name"] . '</th>
                        <th>Department : ' . $result[0]["d_name"] . '</th>                       
                    </tr>
                    <tr>';
                    if ($_SERVER["REQUEST_METHOD"] == "GET") {
                        // Retrieve values from the form
                        $is_id = isset($_GET["is_id"]) ? $_GET["is_id"] : '';
                        $e_id = isset($_GET["id"]) ? $_GET["id"] : '';
                        $brand = isset($_GET["brand"]) ? $_GET["brand"] : '';
                        $i_name = isset($_GET["i_name"]) ? $_GET["i_name"] : '';
                        $is_qty = isset($_GET["is_qty"]) ? $_GET["is_qty"] : '';
                        // $return_qty = isset($_GET["return_qty"]) ? $_GET["return_qty"] : '';
                        
                        // Output the received information
                        echo '<div class="row">';
                        
                        
                        echo '<div class="col-3">';
                        echo "Item : $i_name <br> ";
                        echo '</div>';

                        echo '<div class="col-3">';
                        echo "Brand: $brand<br>";
                        echo '</div>';
                        
                        echo '<div class="col-3">';
                        echo "Total Quantity: $is_qty<br>";
                        echo '</div>';
                        
                        echo '<div class="col-3">';
                        echo'<form action="transfer_process2.php" method="GET">
                        <input type="hidden" name="is_id" value="' . $is_id . '">
                        <input type="hidden" name="e_id" value="' . $e_id . '">
                        <input type="number" name="return_qty" min="1" max="' . $is_qty . '">';
                        echo '<input type="submit" class="btn btn-xs btn-success"> </form>';
                        echo '</div>';

                     

                        
                    }
                    echo'</div>';
                    echo  '</tr>
                </thead>
                
            </table>
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                    <tr>
                        <th>Po No</th>
                        <th>Item</th>
                        <th>Brand</th>
                        <th>Unit</th>
                        <th>Size</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Issue Date</th>
                        <th>Issue By</th>
                        
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>';

                    $count = 0;
                    foreach ($result as $row) {
                        $count++;
                        echo '<tr>
                    <td>' . $row["is_po_no"] . '</td>
                    <td>' . $row["i_name"] . '</td>
                    <td>' . $row["i_manufactured_by"] . '</td>
                    <td>' . $row["i_unit"] . '</td>
                    <td>' . $row["i_size"] . '</td>
                    <td>' . $row["c_name"] . '</td>
                    <td>' . $row["is_qty"] . '</td>
                    <td>' . $row["is_datetime"] . '</td>
                    <td>' . $row["is_item_issue_by"] . '</td>
                    <td>
                    
                    <a href="transfer_process1.php?is_id='.$row["is_id"].'&id='.$id.'&brand='.$row["i_manufactured_by"].'&i_name='.$row["i_name"].'&is_qty='.$row["is_qty"].' " class="btn btn-xs btn-info">SELECT</a>

                    
                    </td>

                    </tr>';
                    // <td><a href="transfer_process2.php?is_id='.$row["is_id"].'&e_id='.$id.'" class="btn btn-xs btn-danger">Return</a></td>
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
