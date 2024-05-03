<?php


// Perform your search logic here and generate the search results

// Example: Return a simple message with the searched inpu


//database configuration for diferrent stores
    session_start();
    include '../layoutdbconnection.php';
        
        
        if(isset($_POST['input'])){
            $input = $_POST['input'];
               // Prepare the SQL statement
                $sql = "SELECT s_name,s_id FROM supplier WHERE s_active=1 AND s_name LIKE '%$input%'";
                $stmt = $conn->prepare($sql);

                if ($stmt->execute([$input])) {

                    
                    // Display the options
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        //echo '<option class="option">' . $row['d_name'] . '</option>';
                           echo '
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="'. $row['s_id'] .'">
                            <label class="form-check-label" for="flexRadioDefault1" >' 
                            . $row['s_name'] .
                            '</label>
                            </div>';
                    }
                    
                } else {
                    echo "No options found.";
                }

                // Close database connection
                unset($conn);
                exit;

        }

        

        

      ?>
