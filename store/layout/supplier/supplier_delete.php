<?php
require 'db.php';

// Retrieve the form values
$s_id = isset($_GET['id']) ? $_GET['id'] : '';

class DeleteSupplier extends Dbhs
{
    public function deleteSupplier($s_id)
    {
        // Input validation and sanitization (You can use filter_var for validation)
        $s_id = filter_var($s_id, FILTER_VALIDATE_INT);

        if ($s_id === false) {
            // Handle invalid input
            $deleteProcessMessage = "Invalid input";
        } else {
            $pdo = $this->connect(); // Assuming the 'connect' method returns a PDO connection object

            // Use a prepared statement to prevent SQL injection
            $sql = "DELETE FROM supplier WHERE s_id = :s_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':s_id', $s_id, PDO::PARAM_INT);

            try {
                if ($stmt->execute()) {
                    // Display success message
                    $value = "Record deleted successfully";
                } else {
                    // Display error message
                    $value = "Error deleting record";
                }
            } catch (PDOException $ex) {
                // Handle exceptions, if needed
                //$deleteProcessMessage = "Error: " . $ex->getMessage();
                $value="Can't delete, Thank you";
            }
        }

        // Redirect to a new page with the value included as a query parameter
        header("Location: supplier_list.php?value=" . urlencode($value));
        exit();
    }
}

$supplier = new DeleteSupplier();
$supplier->deleteSupplier($s_id);
?>
