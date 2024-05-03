<<<?php
           //start session
        session_start();


$emp_id = filter_input(INPUT_GET, 'p_id', FILTER_SANITIZE_NUMBER_INT);
if ($emp_id === false || $emp_id === null) {
    header("Location:http://$base_url/$extra_url");
}
       // echo $emp_id;
       $extra_url='store/layout/purchase_product/purchase_list_search.php';
       $base_url=$_SESSION['base_url'];

        include '../layoutdbconnection.php';

        // Fetch company names from the database
        $sql = "delete from item_purchase where p_id='$emp_id'";


        if ($conn->query($sql) === TRUE) {

           header("Location:http://$base_url/$extra_url");

        } else {

            header("Location:http://$base_url/$extra_url");
        }

        // Close the database connection
        $conn->close();
?>>>