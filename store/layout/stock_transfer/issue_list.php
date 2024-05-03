<!--### Header Part ##################################################-->
<?php
include '../template/header.php';
?>
<!--#####################################################-->

<!-- Include the jQuery library -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Add 'show' class to the element with ID "collapseLayouts2"
    $(document).ready(function() {
        $("#collapseLayouts3").addClass("show");
        $("#collapseLayouts3_list").addClass("active bg-success");
    });
</script>

<!-- Add CSS styles to hide the custom-info-row initially -->
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

<!-- Main content -->
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
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
                include '../layoutdbconnection.php';
                $section = $_SESSION['section'];
                // Fetch company names from the database
                
                if($_SESSION['table']=='short'){                
                $sql = "SELECT TOP (50) iss.is_po_no, iss.is_id, i.i_name, c.c_name, 
                i.i_manufactured_by, i.i_size, i.i_unit, iss.is_avg_price, 
                iss.is_qty, ist.total_price as total_price, 
                iss.is_datetime, iss.is_item_issue_by, e.e_com_id, e.e_name
                     from item_issue iss 
                     INNER JOIN item i ON iss.i_id = i.i_id 
                     INNER JOIN employee e ON iss.e_id = e.e_id
                     INNER JOIN category_item c ON i.c_id = c.c_id
                     INNER JOIN (SELECT SUM(ist_qty*ist_price) as total_price, is_id FROM item_issue_trac GROUP BY is_id) ist ON ist.is_id = iss.is_id
                     WHERE iss.is_active = 1 and i.section = '{$section}'
                     ORDER BY iss.is_datetime DESC";
                }
                if($_SESSION['table']=='all'){
                    $sql = "SELECT iss.is_po_no, iss.is_id, i.i_name, c.c_name, 
                i.i_manufactured_by, i.i_size, i.i_unit, iss.is_avg_price, 
                iss.is_qty, ist.total_price as total_price, 
                iss.is_datetime, iss.is_item_issue_by, e.e_com_id, e.e_name
                     from item_issue iss 
                     INNER JOIN item i ON iss.i_id = i.i_id 
                     INNER JOIN employee e ON iss.e_id = e.e_id
                     INNER JOIN category_item c ON i.c_id = c.c_id
                     INNER JOIN (SELECT SUM(ist_qty*ist_price) as total_price, is_id FROM item_issue_trac GROUP BY is_id) ist ON ist.is_id = iss.is_id
                     WHERE iss.is_active = 1 and i.section = '{$section}'
                     ORDER BY iss.is_datetime DESC";
                }
            
                $stmt = $conn->prepare($sql);

                if ($stmt->execute()) {
                   // $product = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    while ($product = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>".$product['is_po_no']."</td>";
                        echo "<td>".$product['i_name']."</td>";
                        echo "<td>".$product['c_name']."</td>";
                        echo "<td>".$product['i_manufactured_by']."</td>";
                        echo "<td>".$product['i_size']."</td>";
                        echo "<td>".$product['i_unit']."</td>";
                        echo "<td>".$product['is_avg_price']."</td>";
                        echo "<td>".$product['is_qty']."</td>";
                        echo "<td>".$product['total_price']."</td>";
                        echo "<td>".$product['is_datetime']."</td>";
                        echo "<td>".$product['is_item_issue_by']."</td>";
                        echo "<td>".$product['e_com_id']."</td>";
                        echo "<td>".$product['e_name']."</td>";
                        echo '<td><button class="custom-info-button">+</button></td>';
                        echo "</tr>";

                        // Include the custom-info-row within each loop iteration
                        echo '<tr class="custom-info-row">
                        <td colspan="13">
                          
                          <div class="custom-info-content">';
                        $issueid = $product['is_id'];
                        $sql1 = "SELECT r_id, ist_qty, ist_price FROM item_issue_trac WHERE is_id='{$issueid}'";
                        $stmt1 = $conn->prepare($sql1);
                        $stmt1->execute();
    
                        echo '<table style="background-color: rgba(239,245,180,0.72);">
                                <tr>
                                    <th>Lot No</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                </tr>';
                        while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                           // print_r($row);
                            echo '<tr>
                                    <td>'.$row['r_id'].'</td>
                                    <td>'.$row['ist_qty'].'</td>
                                    <td>'.$row['ist_price'].'</td>
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

                // Close database connection
               // unset($conn);
                
                ?>
                </tbody>
            </table>
        </div>
    </main>

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


    <!--###### Footer Part ###############################################-->
    <?php
    include '../template/footer.php';
    ?>
    <!--#####################################################-->
