<?php
require 'db.php';

// Retrieve the form values
$supplierName = isset($_POST['supplier_name']) ? $_POST['supplier_name'] : '';
$address = isset($_POST['address']) ? $_POST['address'] : '';
$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$defaultDateTime = isset($_SESSION['Asia_Dhaka_time']) ? $_SESSION['Asia_Dhaka_time'] : '';
$s_id = isset($_POST['s_id']) ? $_POST['s_id'] : '';

class UpdateSupplier extends Dbhs
{
    public function addSupplier($supplierName, $address, $phone, $email, $defaultDateTime, $username, $s_id)
    {
        $conn = $this->connect(); // Get the PDO connection object

        // Input validation and sanitization
        $supplierName = $conn->quote($supplierName);
        $address = $conn->quote($address);
        $phone = $conn->quote($phone);
        $email = $conn->quote($email);
        $username = $conn->quote($username);
        $defaultDateTime = $conn->quote($defaultDateTime);
        $s_id = $conn->quote($s_id);

        $sql = "UPDATE supplier
                SET s_name = $supplierName,
                    s_address = $address,
                    s_phone = $phone,
                    s_email = $email,
                    s_update_date_time = $defaultDateTime,
                    s_update_by = $username
                WHERE s_id = $s_id";
        $stmt = $conn->query($sql);

        if ($stmt) {
            // Display success message
            $adduser_process_message = "Record updated successfully";
            // Redirect to a new page with the value included as a query parameter
            header("Location: supplier_search.php?value=" . urlencode($adduser_process_message));
            exit();
        } else {
            // Display error message
            $adduser_process_message = "Duplicate record!";
            // Redirect to a new page with the value included as a query parameter
            header("Location: supplier_search.php?value=" . urlencode($adduser_process_message));
            exit();
        }
    }
}

$supplier = new UpdateSupplier();
$supplier->addSupplier($supplierName, $address, $phone, $email, $defaultDateTime, $username, $s_id);
?>
