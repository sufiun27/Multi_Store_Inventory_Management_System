<?php


// Perform your search logic here and generate the search results

// Example: Return a simple message with the searched inpu


//database configuration for diferrent stores
    session_start();
    include '../layoutdbconnection.php';
        
        
        if(isset($_POST['id'])){
            echo "hi baby";
            $input = $_POST['id'];
               // Prepare the SQL statement
                $sql = "SELECT e_name,e_id,e_com_id FROM employee WHERE e_name LIKE '%$input%' or e_com_id LIKE '%$input%' ";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {

                    
                    // Display the options
                    while ($row = mysqli_fetch_assoc($result)) {
                        //echo '<option class="option">' . $row['d_name'] . '</option>';
                           echo '
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="'. $row['e_id'] .'">
                            <label class="form-check-label" for="flexRadioDefault1" >' 
                            . $row['e_name'] .' ('. $row['e_com_id'] .' )
                            </label>
                            </div>';
                    }
                    
                } else {
                    echo "No options found.";
                }

                // Close database connection
                mysqli_close($conn);
                exit;

        }

        

        

      ?>
