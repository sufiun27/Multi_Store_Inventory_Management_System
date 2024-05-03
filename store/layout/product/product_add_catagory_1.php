<?php
include '../template/header.php';
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Add 'show' class to the element with ID "collapseLayouts2"
    $(document).ready(function() {
        $("#collapseLayouts1").addClass("show");
        $("#collapseLayouts1_add_category").addClass("active bg-success");
    });
</script>

            <div id="layoutSidenav_content">
<!--main content////////////////////////////////////////////////////////////////////////////////-->
                
                <main>
                    
                    <div class="container-fluid px-4">
                    
                    <div class="row">
            
            <!----add department //////////////////////////////---->
            <div class="col-md-6">
                <div class="text-dark p-3" style="background: rgba(217, 217, 217,90%);">


                <!----add catagory---->
                <h1>Add Catagory</h1>
                <form action="product_add_catagory.php" method="POST" >
                <?php 
                date_default_timezone_set('Asia/Dhaka');
                $defaultDateTime = date('Y-m-d H:i:s');
                ?>
  <div class="form-group">
    <label for="cataogory_name">Cataogory Name</label>
    <input type="text" class="form-control" name="category_name" id="category_name" aria-describedby="category_name" placeholder="">
     <input type="hidden" name="datetime" id="datetime" value="<?php echo $defaultDateTime; ?>">
    <button type="submit" class="btn btn-primary">Submit</button>
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

            echo "Add New Catagory";
        }
                ?>
            </h4>
        </form>
                <!----add department---->   
            </div>
        </div>
        <!---show departments name tabulear from--->
        <div>
                 <h3>Catagory</h3>
                 <table  >
                    
                    <?php
                    include '../layoutdbconnection.php';
                 // Fetch company names from the database
                 $section = $_SESSION['section'];
                 //echo $section;
                $sql = "SELECT c_name FROM category_item where section = '$section' ORDER BY c_id desc";
                $result = $conn->query($sql);
                
                // Display company names as options in the select input
                
                  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<span>" . $row['c_name'] . " | </span> ";
                  }
                
                // Close the database connection
               // $conn->close();
                ?>
      
                 </table>
                </div>
                    
                    </div><!-----main container -->
                </main>
                       
<?php
include '../template/footer.php';
?>
