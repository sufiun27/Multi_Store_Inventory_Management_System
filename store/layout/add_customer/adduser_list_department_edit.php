<!--### Header Part ##################################################-->
<?php
include '../template/header.php';
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Add 'show' class to the element with ID "collapseLayouts2"
    $(document).ready(function() {
        $("#collapseLayouts").addClass("show");
        $("#collapseLayouts_department").addClass("active bg-success");
    });
</script>
<!--#####################################################-->
            <div id="layoutSidenav_content">
<!--exit add customer portion -////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->                            


<!--fetch employee record-->
<?php

include '../layoutdbconnection.php'; 
$depid = $_GET['id'];
$sql = "SELECT * FROM  department  where d_id = $depid";
$result = $conn->query($sql);
$row=$result->fetch(PDO::FETCH_ASSOC);

?>




            <!---------------------------->
                <main>
                  
                    <div class="container-fluid px-4">
                    <div class="row">
            <div class="col-md-6">
                <div class=" text-dark p-3" style="background: rgb(217, 217, 217);">
                <!----add department---->
                <h4>Current Department: <?php echo $row['d_name'];?> </h4>
                <h1>Update Department</h1>
                <form action="adduser_dep_update.php" method="POST" >
                    <div class="form-group">
                        <label for="department_short_name">Department Name (short)</label>
                        <input type="text" class="form-control" name="department_short_name" id="department_short_name" aria-describedby="department_short_name" value="<?php echo $row['d_name'];?>">
                        
                    </div>
                    <div class="form-group">
                        <label for="department_full_name">Department Name (Full)</label>
                        <input type="text" class="form-control" id="department_full_name" value="<?php echo $row['d_full_name'];?>" name="department_full_name">
                    </div>

                    <input hidden type="number" name="depid" value="<?php echo $row['d_id'];?>">
                    
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <?php

                    if(isset($_GET['value_dep'])){
                        if($_GET['value_dep']=="Record updated successfully"){
                            echo "<h4 class=\"bg-success p-3 m-2 text-center\">";
                        }
                        else {
                            # code...
                            echo "<h4 class=\"bg-danger p-3 m-2 text-center\">";
                        }
                        
                        echo $_GET['value_dep'];
                    }
                    else{

                        echo "add new department";
                    }
                            ?>
                                </h4>
                </form>
                <!----add department---->
        

                    <!-- exit add user -->
                </div>
            </div>
                </main>
<!--exit add customer portion -////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->     

<!--###### Footer Part ###############################################-->
<?php
include '../template/footer.php';
?>
<!--#####################################################-->
