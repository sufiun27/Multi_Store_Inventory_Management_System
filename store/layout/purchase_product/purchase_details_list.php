
<!--### Header Part ##################################################-->
<?php
include '../template/header.php';
?>
<!--#####################################################-->

<style>
    .info-row {
        display: none; /* Hide the info rows by default */
    }

    .info-content {
        background-color: #f0f0f0;
        padding: 10px;
    }

    .hidden-heading {
        font-weight: bold;
        background-color: #f0f0f0;
        padding: 10px;
    }

    /* Apply styles to the .info-row that is a direct child of tbody */
    tbody > .info-row:nth-child(even) {
        background-color: #f9f9f9;
    }

    tbody > .info-row:nth-child(odd) {
        background-color: #ffffff;
    }
</style>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Add 'show' class to the element with ID "collapseLayouts2"
    $(document).ready(function() {
        $("#collapseLayouts2").addClass("show");
        $("#collapseLayouts2_list").addClass("active bg-success");
    });

    // Add event listeners to the buttons
    $(document).on("click", ".info-button", function() {
        var row = $(this).closest("tr").next(".info-row");

        if (row.hasClass("info-row")) {
            if (row.css("display") === "table-row") {
                row.css("display", "none");
            } else {
                row.css("display", "table-row");
            }
        }
    });
</script>

<div id="layoutSidenav_content">
    <!--main content////////////////////////////////////////////////////////////////////////////////-->
    <main>
        <div class="container-fluid px-4">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th></th>
                    <th>Po No</th>
                    <th>Item Name</th>
                    <th>Category</th>
                    <th>Unit</th>
                    <th>Size</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                include '../layoutdbconnection.php';

                // Fetch company names from the database
                $sql = "SELECT ip.p_req_qty, ip.p_id, ip.p_po_no, i.i_name, c.c_name, i.i_unit, i.i_size, ip.p_unit_price, ip.p_qty, ip.p_unit_price*ip.p_qty as total_price, ip.p_profit, ip.p_add_datetime, ip.p_expaired_datetime, s.s_name, ip.p_purchase_by, ip.p_request, ip.p_recive
            FROM item_purchase ip
            INNER JOIN item i ON ip.i_id = i.i_id 
            INNER JOIN supplier s ON ip.s_id = s.s_id 
            INNER JOIN category_item c ON i.c_id = c.c_id
            ORDER BY ip.p_add_datetime DESC";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($product = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td><button class=\"info-button\">+</button></td>";
                        echo "<td>".$product['p_po_no']."</td>";
                        echo "<td>".$product['i_name']."</td>";
                        echo "<td>".$product['c_name']."</td>";
                        echo "<td>".$product['i_unit']."</td>";
                        echo "<td>".$product['i_size']."</td>";
                        echo "<td>".$product['p_unit_price']."</td>";
                        echo "<td>".$product['p_qty']."</td>";
                        echo "<td>".$product['total_price']."</td>";
                        echo "<td><div class=\"btn-group\">";

                        if ($_SESSION['role'] == 'admin'){
                            if($product['p_request']=='0'){
                                echo "<a href=\"purchase_list_process_request.php?p_id=".$product['p_id']."\"><button type=\"button\" class=\"btn btn-success btn-sm\">Accept</button></a>";
                            } else {
                                if($product['p_recive']=='0'){
                                    echo "<a href=\"purchase_list_process_request_unaccept.php?p_id=".$product['p_id']."\"><button type=\"button\" class=\"btn btn-success btn-sm\">Unaccept</button></a>";
                                } else {
                                    echo "<span class=\"text-success\">Accepted | </span>";
                                }
                            }
                        }

                    if($product['p_request']=='1'){
                    if(  $product['p_qty'] <= $product['p_req_qty']  ){ ?>
                        <script>
                            function validateNumber() {
                                var input = document.getElementById('numberInput').value;
                                var errorSpan = document.getElementById('errorSpan');

                                if (isNaN(input) || input <= 10) {
                                    errorSpan.textContent = ""; // Clear previous error message
                                } else {
                                    errorSpan.textContent = "Please enter a number less than or equal to 10.";
                                    return false; // Prevent form submission
                                }
                            }
                        </script>
                    <?php
                    echo '<button class="custom-info-button">Show Info</button>';
                    /*
                     echo '
                     <form action="purchase_list_process_recive.php" onsubmit="return validateNumber(); method="post">
                     <input type="text" placeholder="qty" id="numberInput" name="numberInput">
                     <span id="errorSpan"></span>

                     <input type="submit" value="Recive">
                   </form>
                     ';
                      */
                    // echo "<a href=\"purchase_list_process_recive.php?p_id=".$product['p_id']."\"><button type=\"button\" class=\"btn btn-primary btn-sm\">Receive</button></a>";
                    } else {
                        echo "<span class=\"text-primary\">Received</span>";
                    }
                    } else {
                        echo "<span class=\"text-primary\">| on progress</span>";
                    }

                    if($product['p_recive']=='0' and $product['p_request']=='0'){
                        echo "<a href=\"purchase_list_process_delete.php?p_id=".$product['p_id']."\"><button type=\"button\" class=\"btn btn-danger btn-sm\">Delete</button></a>";
                    } else {
                        echo "<span class=\"text-danger\"> | can't delete</span>";
                    }

                    echo "</div></td>";
                    echo "</tr>";

                    echo '<tr class="info-row" style="display: none;">
                                <td colspan="10">
                                    <div class="hidden-heading">
                                        
                                    </div>
                                    <div class="info-content">
                                        <table class="table table-striped">
                                            <tr>
                                                <th>Add Date Time</th>
                                                <th>Expaired Date Time</th>
                                                <th>Subbpier</th>
                                                <th>Purchase by</th>
                                            </tr>
                                            <tr>
                                                <td>'.$product['p_add_datetime'].'</td>
                                                <td>'.$product['p_expaired_datetime'].'</td>
                                                <td>'.$product['s_name'].'</td>
                                                <td>'.$product['p_purchase_by'].'</td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                            </tr>';
                    ?>
                        <style>
                            .custom-info-row {
                                display: none; /* Hide the info rows by default */
                            }

                            .custom-info-content {
                                background-color: #f0f0f0;
                                padding: 10px;
                            }

                            .custom-hidden-heading {
                                font-weight: bold;
                                background-color: #f0f0f0;
                                padding: 10px;
                            }
                        </style>
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
                        <?php
                        //row for recive item
                        echo '<tr class="custom-info-row">
                              <td colspan="3">
                                <div class="custom-hidden-heading">Hidden Information Heading</div>
                                <div class="custom-info-content">
                                  More information can go here.
                                </div>
                              </td>
                            </tr>';
                    }
                } else {
                    echo "No records found.";
                }

                // Close database connection
                mysqli_close($conn);
                ?>
                </tbody>
            </table>
        </div>
    </main>
    <!--main content//////////////////////////////////////////////////////////////////////////////////-->
    <!--###### Footer Part ###############################################-->
    <?php
    include '../template/footer.php';
    ?>
    <!--#####################################################-->
</div>

