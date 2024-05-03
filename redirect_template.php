<?php 


session_start();
        $purchase_id = $_GET['p_id'];
        //echo $catagory;
        //echo $datetime;
        include '../layoutdbconnection.php';
        $extra_url='store/layout/purchase_product/purchase_list.php';
        $base_url=$_SESSION['base_url'];      
        // Fetch company names from the database
        $sql = "UPDATE item_purchase
        SET p_request = 1
        WHERE p_id = '$purchase_id';";
        //$result = $conn->query($sql);

        if ($conn->query($sql) === TRUE) {
            // Display success message
            //$adduser_process_massae = "Record inserted successfully";
           //echo $adduser_process_massae;
            // Redirect to a new page with the value included as a query parameter
            header("Location:http://$base_url/$extra_url");
         
        } else {
            // Display error message
            //$adduser_process_massae = "Error";
            //echo $conn->error;
            // Redirect to a new page with the value included as a query parameter
            header("Location:http://$base_url/$extra_url");
        }

        // Close the database connection
        $conn->close();

?>