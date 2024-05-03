<?php

        //start session
        session_start();

        include '../layoutdbconnection.php';

        $is_id= $_GET['id'];
        $is_inactive_reason=$_GET['reason'];
        $item_update_by=$_SESSION['username'];
        //echo $is_id;
        //echo $emp_main_id;


        date_default_timezone_set('Asia/Dhaka');
        $defaultDateTime = date('Y-m-d H:i:s');

        $active = 0;
        // Fetch company names from the database
        $sql = "UPDATE item_issue SET 
                is_active='$active',
                is_inactive_datetime='$defaultDateTime', is_inactive_by = '$item_update_by', is_inactive_reason='$is_inactive_reason'
                 WHERE is_id = '$is_id'";
        //$result = $conn->query($sql);

        if ($conn->query($sql) === TRUE) {
            // Display success message
            $adduser_process_massae = "Deactivate successfully";
             //echo $adduser_process_massae;
            // Redirect to a new page with the value included as a query parameter
            header("Location: issue_search.php?value=" . urlencode($adduser_process_massae) . "&id=" . urlencode($emp_main_id));

        } else {
            //echo $conn->error;
            // Display error message
             $adduser_process_massae = "ERROR!";
              //echo $conn->error;
            // Redirect to a new page with the value included as a query parameter
            header("Location: issue_search.php?value=" . urlencode($adduser_process_massae));
        }

        // Close the database connection

        $conn->close();
