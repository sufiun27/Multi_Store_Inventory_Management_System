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
        $("#collapseLayouts_add_department").addClass("active bg-success");
    });
</script>



            <div id="layoutSidenav_content">
<!--exit add customer portion -////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->                            

            <!---------------------------->
                <main >
                    <div class="container-fluid px-4">
                    <div class="row">
            
                    <div class="col-md-6">
                <div class="text-dark p-3" style="background: rgb(217, 217, 217);">

                <!----add department---->
                <h1>Add Department</h1>
                <form action="adduser_dep_process.php" method="POST" >
                    <div class="form-group">
                        <label for="department_short_name">Department Name (short)</label>
                        <input type="text" class="form-control" name="department_short_name" id="department_short_name" aria-describedby="department_short_name" placeholder="example: HR">
                        
                    </div>
                    <div class="form-group">
                        <label for="department_full_name">Department Name (Full)</label>
                        <input type="text" class="form-control" id="department_full_name" placeholder="Human Resource" name="department_full_name">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <?php

                    if(isset($_GET['value_dep'])){
                        if($_GET['value_dep']=="Record inserted successfully"){
                            echo "<h4 class=\"bg-Success p-3 m-2 text-center\">";
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
                
                </div>
                <!---show departments name tabulear from--->
                <div>
                 <h3>Departments</h3>
                 
                    
<?php
include '../layoutdbconnection.php';

// Fetch department names from the database
$sql = "SELECT d_name FROM department ORDER BY d_name DESC";

$result = $conn->query($sql);

if (!$result) {
    die("Error in SQL query: " . $conn->errorInfo()[2]);
}

//$rowno = $result->rowCount();
//echo "<p>Total departments: " . $rowno=0 . "</p>";
$rowno=0;
echo "<p>";
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    echo "" . $row['d_name'] . " | "; ++$rowno;
}
echo "</p>";

echo "Total department no:".$rowno;

// if ($rowno > 0) {
//     echo "<p>";
//     while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
//         echo "" . $row['d_name'] . " | ";
//     }
//     echo "</p>";
// } else {
//     echo "No departments found.";
// }

$conn = null;
?>


      
               
                </div>
            </div>
        </div>


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