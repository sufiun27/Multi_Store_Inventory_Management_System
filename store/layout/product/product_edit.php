<!--### Header Part ##################################################-->
<?php
include '../template/header.php';
?>
<!--#####################################################-->





            <div id="layoutSidenav_content">

            <?php
            include '../layoutdbconnection.php';
            $p_id=$_GET['p_id'];
            $sql=' SELECT * FROM item WHERE i_id='.$p_id.'';
            $result=$conn->query($sql);
            $row=$result->fetch(PDO::FETCH_ASSOC);
            //print_r($row);
            ?>
<!--main content////////////////////////////////////////////////////////////////////////////////-->
                <main>
                    <div class="container-fluid px-4">
                    <div class="row">
            <div class="col-md-6">


                <div class="  p-3" style="background: rgba(217, 217, 217,90%);">
                    <!-- add user //////////////////////////////////////////////////////////////////////-->
                    <h2 class="mt-5 mb-4"><b>Update  Items</b></h2>
        <form id="submitForm" action="product_item_process_update.php" method="POST">
 <!--////////////category button///////////////////////////////////////////////////////////////////////////-->
              
           <input hidden type="text" name="pid" value="<?php echo $p_id; ?>">


            <div class="form-group" >
                <div class="">
                <h4>Select Catagory</h4>
                </div>
                <input required type="text" class="form-control" id="live_search" autocomplete="off" placeholder="Search...">
                </div>

                <div id="search_result"></div>

                 <!-- jQuery -->
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
                    <!-- Optional Bootstrap JavaScript -->
                    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

                    <script type="text/javascript">
                        $(document).ready(function() {
                        $("#live_search").keyup(function() {
                            var input = $(this).val();
                            if (input !== "") {
                            $.ajax({
                                url: "livesearch.php",
                                method: "POST",
                                data: { input: input },
                                success: function(data) {
                                $("#search_result").html(data);
                                }
                            });
                            } else {
                            $("#search_result").empty();
                            }
                        });
                        });
                    </script>
<!--///////////////////////////////////////////////////////////////////////////////////////-->
            <div class="form-group">
                <label for="item_name">Item Name</label>
                <input type="text" class="form-control" id="item_name" name="item_name" value="<?php echo $row['i_name']; ?>" required>
            </div>

            <div class="form-group">
                <label for="item_code">Item Code</label>
                <input type="text" class="form-control" id="item_code" name="item_code" value="<?php echo $row['i_code']; ?>" required>
            </div>
            <div class="form-group">
                <label for="brand">Brand</label>
                <input type="text" class="form-control" id="brand" name="brand" value="<?php echo $row['i_manufactured_by']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="Unit">Unit</label>
                <input type="text" class="form-control" id="Unit" name="Unit" value="<?php echo $row['i_unit']; ?>" required>
            </div>
            <div class="form-group">
                <label for="size">size</label>
                <input type="text" class="form-control" id="size" name="size" value="<?php echo $row['i_size']; ?>" required>
            </div>
            <div class="form-group">
                <label for="price">price</label>
                <input type="text" class="form-control" id="price" name="price" value="<?php echo $row['i_price']; ?>" required>
            </div>
            <div class="form-group">
                <label for="price">Stock Out Reminder Quantity</label>
                <input type="number" class="form-control" id="stock_out_reminder_qty" name="stock_out_reminder_qty" value="<?php echo $row['stock_out_reminder_qty']; ?>" required>
            </div>
            <!--
                <div class="form-group">
                <label for="item_add_date">Add Date</label>
                <input type="datetime-local" class="form-control" id="item_add_date" name="item_add_date" required>
            </div>
            -->
           
            <button type="submit" class="btn btn-primary">Submit</button>
            
            
            <?php

            if(isset($_GET['value_emp'])){
                if($_GET['value_emp']=="Record inserted successfully"){
                    echo "<h4 class=\"bg-Success p-3 m-2 text-center\">";
                }
                else {
                    # code...
                    echo "<h4 class=\"bg-danger p-3 m-2 text-center\">";
                }
                
                echo $_GET['value_emp'];
            }
            else{

                echo "Update Item";
            }
            ?>
            </h4>
        </form>
        

                    <!-- exit add user -->
                </div>
            </div>
                      
                    </div>
                </main>
            
<!--main content//////////////////////////////////////////////////////////////////////////////////-->
<!--###### Footer Part ###############################################-->
<?php
include '../template/footer.php';
?>
<!--#####################################################-->