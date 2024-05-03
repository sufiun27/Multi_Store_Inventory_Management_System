<!--### Header Part ##################################################-->
<?php
include '../template/header.php';
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Add 'show' class to the element with ID "collapseLayouts2"
    $(document).ready(function() {
        $("#collapseLayouts1").addClass("show");
        $("#collapseLayouts1_category").addClass("active bg-success");
    });
</script>
<!--#####################################################-->
            <div id="layoutSidenav_content">
<!--exit add customer portion -////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->                            


<!--fetch employee record-->
<?php

include '../layoutdbconnection.php'; 
$depid = $_GET['id'];
$sql = "SELECT * FROM  category_item  where c_id = $depid";
$result = $conn->query($sql);
$row=$result->fetch(PDO::FETCH_ASSOC);

?>




            <!---------------------------->
                <main>
                  
                    <div class="container-fluid px-4">
                    <div class="row">
            <div class="col-md-6">
                <div class="  p-3" style="background: rgba(217, 217, 217,90%);">
                <!----add department---->
                <h4>Current Category: <?php echo $row['c_name'];?> </h4>
                <h1>Update Category</h1>
                <form action="product_category_update.php" method="POST" >
                    <div class="form-group">
                        <label for="c_name">Category Name</label>
                        <input type="text" class="form-control" name="c_name" id="c_name" aria-describedby="c_name" value="<?php echo $row['c_name'];?>">
                        
                    </div>
                    

                    <input hidden type="number" name="c_id" value="<?php echo $row['c_id'];?>">
                    
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <?php

                    if(isset($_GET['value_dep'])){
                        if($_GET['value_dep']=="Record update successfully"){
                            echo "<h4 class=\"bg-success p-3 m-2 text-center\">";
                        }
                        else {
                            # code...
                            echo "<h4 class=\"bg-danger p-3 m-2 text-center\">";
                        }
                        
                        echo $_GET['value_dep'];
                    }
                    else{

                        echo "";
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
