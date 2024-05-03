<?php
// Place this code at the beginning of your PHP file
error_reporting(E_ALL & ~E_NOTICE);

if(!isset($_GET['id'])){header("Location: supplier_search.php?value=");}
else{
include 'db.php';
$s_id=$_GET['id'];
class SupplierEdit extends Dbhs{
    public function viewSupplier($id){
        $sql = "SELECT * FROM supplier WHERE s_id = '$id'";
        $result = $this->connect()->query($sql);
        $supplier=$result->fetchAll();
        return $supplier;
    }
}

$supp=new SupplierEdit();
$suppinfo = $supp->viewSupplier($s_id);
//print_r($suppinfo);
 //   echo $suppinfo[0]['s_name'];
}

?>
<?php
include '../template/header.php';
?>
<!--#####################################################-->


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Add 'show' class to the element with ID "collapseLayouts2"
    $(document).ready(function() {
        $("#collapseLayouts0").addClass("show");
        $("#collapseLayouts0_search").addClass("active bg-success");
    });
</script>



<div id="layoutSidenav_content">
    <!--exit add customer portion -////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

    <!---------------------------->
    <main >
        <div class="container-fluid px-4">
            <div class="row">

                <div class="col-md-6">
                    <div class="text-dark p-3" style="background: rgba(217, 217, 217,0.8);">


                        <!----add department---->
                        <h1>Add Supplier</h1>
                        <form action="update_supplier_process.php" method="POST" >
                            <input required type="number" value="<?php echo $s_id; ?>" hidden name="s_id" id="s_id">
                            <div class="form-group">
                                <label for="supplier_name">Supplier Name</label>
                                <input type="text" class="form-control" name="supplier_name" id="supplier_name" value="<?php echo $suppinfo[0]['s_name']; ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" name="address" id="address" value="<?php echo $suppinfo[0]['s_address']; ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" class="form-control" name="phone" id="phone" value="<?php echo $suppinfo[0]['s_phone']; ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" value="<?php echo $suppinfo[0]['s_email']; ?>" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                            <?php

                            if(isset($_GET['value_dep'])){
                                if($_GET['value_dep']=="Record inserted successfully"){

                                    echo "<h4 class=\"bg-success p-3 m-2 text-center\">";
                                }
                                else {
                                    # code...
                                    echo "<h4 class=\"bg-danger p-3 m-2 text-center\">";
                                }

                                echo $_GET['value_dep'];
                            }
                            else{

                                echo "Update supplier";
                            }
                            ?>
                            </h4>
                        </form>
                        <!----add department---->

                    </div>

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