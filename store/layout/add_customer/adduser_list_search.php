
<!--### Header Part ##################################################-->
<?php
include '../template/header.php';
?>
<!--#####################################################-->

            <div id="layoutSidenav_content">
<!--view user list -////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->                            

                <main>
                    <div class="container-fluid px-4">
                        <h1>hi</h1>
                        <?php
                        $search = $_POST['search'];
                        include '../layoutdbconnection.php';                     
                        // Fetch company names from the database
                        $sql = "SELECT * FROM employee WHERE e_com_id like '%$search%'";
                        $result = mysqli_query($conn, $sql);
                
                        if (mysqli_num_rows($result) > 0) {
                            echo '<table class="table">
                                    <thead>
                                        <tr>
                                            <th>Customer ID</th>
                                            <th>Name</th>
                                            <th>Department</th>
                                            <th>Designation</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<tr>
                                        <td>'.$row["e_com_id"].'</td>
                                        <td>'.$row["e_name"].'</td>
                                        <td>'.$row["d_name"].'</td>
                                        <td>'.$row["e_designation"].'</td>
                                        <td>
                                        <a href="adduser_list_edit.php?id='.$row["e_id"].'&name='.$row["e_name"].'&department='.$row["d_name"].'&designation='.$row["e_designation"].'&comid='.$row["e_com_id"].'" class="btn btn-primary">Edit</a>                          
                                        <a href="delete_customer.php?id='.$row["e_id"].'" class="btn btn-danger">Delete</a>
                                        </td>
                                      </tr>';
                            }
                
                            echo '</tbody></table>';
                        } else {
                            echo "No records found.";
                        }
                
                        // Close database connection
                        mysqli_close($conn);
                        ?>
                    </div>
                </main>
<!--end view user list -////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->                            

<!--###### Footer Part ###############################################-->
<?php
include '../template/footer.php';
?>
<!--#####################################################-->
