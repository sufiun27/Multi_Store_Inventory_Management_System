
    <!--### Header Part ##################################################-->
    <?php
    include '../template/header.php';
    ?>
    <!--#####################################################-->
<?php
include '../layoutdbconnection.php';
?>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Add 'show' class to the element with ID "collapseLayouts2"
    $(document).ready(function() {
        $("#collapseLayouts4").addClass("show");
        $("#collapseLayouts4_list").addClass("active bg-success");
    });
</script>

<style>
    th,td{
        font-size: 14px;
    }
    
</style>

<div id="layoutSidenav_content">
    <!--main content////////////////////////////////////////////////////////////////////////////////-->
    <main>
        <div class="container-fluid px-4">
           
<!---table------////////////////////---->        
<div class="card mb-4">
<div class="card-header " style="background: rgba(100, 210, 200,0.2);">
        
</div>
        
        
<div class="card-body">           
<table id="datatablesSimple">
    <thead>
        <tr>
            <th>Po No</th>
            <th>Employee</th>
            <th>Issue time</th>
            <th>Item</th>
            <th>Category</th>
            <th>Brand</th>
            <th>Unit</th>
            <th>Size</th>
            <th>Unit Price</th>
            <th>Issue By</th>
            <th>Quantity</th>
            <th>Return By</th>
            <th>Return Time</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
        <th>Po No</th>
        <th>Employee</th>
            <th>Issue time</th>
            <th>Item</th>
            <th>Category</th>
            <th>Brand</th>
            <th>Unit</th>
            <th>Size</th>
            <th>Unit Price</th>
            <th>Issue By</th>
            <th>Quantity</th>
            <th>Return By</th>
            <th>Return Time</th>
        </tr>
    </tfoot>
    
    <?php
        $section = $_SESSION['section'];
        // Fetch company names from the database

        if($_SESSION['table']=='short'){
        $sql = "SELECT TOP (50) *
        FROM item_return as r
		INNER JOIN item as i ON i.i_id = r.i_id
		INNER JOIN category_item as c ON c.c_id =i.c_id
        INNER JOIN employee as e ON e.e_id = r.e_id
        WHERE i.section = '$section'
        ORDER BY return_datetime DESC";
        }
        if($_SESSION['table']=='all'){
            $sql = "SELECT *
            FROM item_return as r
                INNER JOIN item as i ON i.i_id = r.i_id
                INNER JOIN category_item as c ON c.c_id =i.c_id
                INNER JOIN employee as e ON e.e_id = r.e_id
                WHERE i.section = '$section'
            ORDER BY return_datetime DESC";
            }

        $stmt = $conn->prepare($sql);
     ?>

    <tbody>
        <?php

        if ($stmt->execute()) {
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($products as $product) {
              //  print_r($product);
                echo "<tr>";
                echo "<td>".$product['is_po_no']."</td>";
                echo "<td>".$product['e_name']."</td>";   
                echo "<td>".$product['is_datetime']."</td>";
                echo "<td>".$product['i_name']."</td>";
                echo "<td>".$product['c_name']."</td>";
                echo "<td>".$product['i_manufactured_by']."</td>";                
                echo "<td>".$product['i_unit']."</td>";
                echo "<td>".$product['i_size']."</td>";
                echo "<td>".$product['i_price']."</td>";
                echo "<td>".$product['is_item_issue_by']."</td>";
                echo "<td>".$product['is_qty']."</td>";
                echo "<td>".$product['return_by']."</td>";
                echo "<td>".$product['return_datetime']."</td>";
/////////////////////////ACTION Button///////////////////////////////
               

                
/////////////////////////End ACTION Button///////////////////////////////               
                ?>
<!--Submit button  ///////////////////////////-->
                
 <!--close submit button  ///////////////////////////-->
             <?php   
                echo "</tr>";
            }
        }
        ?>
    </tbody>

</table>
</div>
</div>
<!---table------////////////////////---->    


    </main>
    <!--main content//////////////////////////////////////////////////////////////////////////////////-->
    <!--###### Footer Part ###############################################-->
    <?php
    include '../template/footer.php';
    ?>
    <!--#####################################################-->
</div>

