<!--### Header Part ##################################################-->
<?php
include '../template/header.php';
?>
<!--#####################################################-->


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Add 'show' class to the element with ID "collapseLayouts2"
    $(document).ready(function() {
        $("#collapseLayouts0").addClass("show");
        $("#collapseLayouts0_add").addClass("active bg-success");
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
                        <h1>Add Supplier</h1>
                        <form action="add_supplier_process.php" method="POST" >
                            <div class="form-group">
                                <label for="supplier_name">Supplier Name</label>
                                <input type="text" class="form-control" name="supplier_name" id="supplier_name" placeholder="Name..." required>
                            </div>

                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" name="address" id="address" placeholder="Address..." required>
                            </div>

                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" class="form-control" name="phone" id="phone" placeholder="Phone Number..." required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="example@example.com" required>
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

                                echo "add new supplier";
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