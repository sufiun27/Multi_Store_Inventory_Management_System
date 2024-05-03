<?php


session_start();
include '../layoutdbconnection.php';

if (isset($_POST['input'])) {
    $input = $_POST['input'];
    $input = "%$input%";
    $section = $_SESSION['section'] ?? '';
    // Prepare the SQL statement
    $sql = "SELECT c_id, c_name FROM category_item WHERE c_name LIKE :input AND c_active = 1 AND section = '$section' ORDER BY c_name ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':input', $input, PDO::PARAM_STR);
    $stmt->execute();

    
        // Display the options
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '
            <div class="form-check">
                <input required class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="' . $row['c_id'] . '">
                <label class="form-check-label" for="flexRadioDefault1">' . $row['c_name'] . '</label>
            </div>';
        }
  
    
    // Release the connection resources
    unset($conn);
    exit;
}
?>
