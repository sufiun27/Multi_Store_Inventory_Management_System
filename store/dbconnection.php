<?php
//database configuration for diferrent stores
     session_start();
     $user_name = $_SESSION['username'];
     $user_company = $_SESSION['company'];
     $user_role = $_SESSION['role'];
     /*
     echo $user_name; 
     echo $user_company; 
     echo $user_role;
     */
//database configuration for diferrent stores


         ///////////////////////////////////////////////////////////
        // PHP code to fetch company names from the database
        include '../hostingDBinfo.php';
        //////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////
        $database = $user_company;

        // Create a connection
        $conn = new mysqli($servername, $username, $password, $database);

        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }
        else {
            
            /* 
            // Prepare the SQL query
             $sql = "SELECT * FROM cataory_item where c_id=1";
             
             // Execute the query
             $result = $conn->query($sql);
             
             // Fetch records as associative arrays
             $row = $result->fetch_assoc();
                
                echo $row['c_name'];

            */
            
            header("Location:http://localhost:8080/storehl/store/layout/");
            
            
        }

        

        

        // Close the database connection
        $conn->close();
      ?>