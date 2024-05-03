<?php
require 'db.php';
// Retrieve the form values
$supplierName = $_POST['supplier_name'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$username = $_SESSION['username'];
$section=$_SESSION['section'];
$defaultDateTime=$_SESSION['Asia_Dhaka_time'];
//$site= $_SESSION['site'] ;

// Echo the received values
//echo "Supplier Name: " . $supplierName . "<br>";
//echo "Address: " . $address . "<br>";
//echo "Phone Number: " . $phone . "<br>";
//echo "Email: " . $email . "<br>";

class Supplier extends Dbhs
{
    public function addSupplier($supplierName, $address, $phone, $email, $defaultDateTime, $username, $section,  )
    {
        $sql = "INSERT INTO supplier (s_name, s_address, s_phone, s_email, s_add_datetime, s_add_by, section) 
                VALUES ('$supplierName', '$address', '$phone', '$email', '$defaultDateTime', '$username', '$section' )";
        $stmt = $this->connect()->query($sql);

        if ($stmt) {
            // Display success message
            $adduser_process_massae = "Record inserted successfully";
         // echo $site;
            // Redirect to a new page with the value included as a query parameter
            header("Location: supplier_add.php?value_dep=" . urlencode($adduser_process_massae));

        } else {
            // Display error message
            $adduser_process_massae = "Dublicate record!";

            // Redirect to a new page with the value included as a query parameter
            header("Location: supplier_add.php?value_dep=" . urlencode($adduser_process_massae));
        }
    }


}
$addSupplier= new Supplier();
$addSupplier->addSupplier($supplierName, $address, $phone, $email, $defaultDateTime, $username, $section);

?>
