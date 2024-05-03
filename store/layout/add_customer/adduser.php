<!--### Header Part ##################################################-->
<?php
include '../template/header.php';
?>
<!--#####################################################-->


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Add 'show' class to the element with ID "collapseLayouts2"
    $(document).ready(function() {
        $("#collapseLayouts").addClass("show");
        $("#collapseLayouts_add").addClass("active bg-success");
    });
</script>



            <div id="layoutSidenav_content">
<!--exit add customer portion -////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->                            

            <!---------------------------->
                <main >
                    <div class="container-fluid px-4">
                    <div class="row">
            <div class="col-md-6">
                <div class=" text-dark p-3 " style="background: rgb(217, 217, 217);">
                    <!-- add user //////////////////////////////////////////////////////////////////////-->
                    <h2 class="mt-5 mb-4">Employee Registration</h2>
        <form action="adduser_emp_process.php" method="POST">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="id">ID</label>
                <input type="text" class="form-control" id="id" name="id" required>
            </div>
            <div class="form-group">
                <label for="designation">Designation</label>
                <input type="text" class="form-control" id="designation" name="designation" required>
            </div>

            <div class="form-group">
            <label for="mn">Designation</label>
                <select class="form-control" id="mn" name="mn" required>
                    <option value="Management">Management</option>
                    <option value="Non-Management">Non-Management</option>
                </select>
            </div>


            

            <div class="form-group">
            <label for="department">Department</label>

            <select class="form-control form-control-sm" id="department" name="department" >
            <?php
                // Start session
                session_start();

                include '../layoutdbconnection.php';

                // Fetch department names from the database (MS SQL Server)
                $sql = "SELECT d_id, d_name FROM department WHERE d_active = 1";
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                // Display department names as options in the select input
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='" . $row['d_id'] . "'>" . $row['d_name'] . "</option>";
                }

                // Close the database connection
                $conn = null;
                ?>

            </select>
            </div>

            <input hidden type="datetime-local"  id="emp_add_datetime" name="emp_add_datetime"  value="<?php echo $defaultDateTime; ?>" >
            <input hidden type="text"  id="emp_add_by" name="emp_add_by"  value="<?php echo $_SESSION['username']; ?>" >

            <button type="submit" class="btn btn-primary">Register</button>
           
            
            <?php

            if(isset($_GET['value'])){
                if($_GET['value']=="Record inserted successfully"){
                    echo "<h4 class=\"bg-Success p-3 m-2 text-center\">";
                }
                else {
                    # code...
                    echo "<h4 class=\"bg-danger p-3 m-2 text-center\">";
                }
                
                echo $_GET['value'];
            }
            else{

                echo "add new user";
            }
                    ?>
            </h4>
        </form>
        

                    <!-- exit add user -->
                </div>
            </div>
           
            
                    
                    </div><!-----main container -->
                </main>
<!--exit add customer portion -////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->     


<!--###### Footer Part ###############################################-->
<?php
include '../template/footer.php';
?>
<!--#####################################################-->