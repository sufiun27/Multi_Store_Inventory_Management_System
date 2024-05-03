<!--### Header Part ##################################################-->
<?php
include '../template/header.php';
?>
<style>
    td{
        font-size: 12px;
    }
</style>
<!--#####################################################-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Add 'show' class to the element with ID "collapseLayouts2"
    $(document).ready(function() {
        $("#collapsePages_report").addClass("show");
        $("#pagesCollapseStoreReport").addClass("show");
        $("#dateWiseRecive").addClass("active bg-success");
    });
</script>



<!--#####################################################-->
<div id="layoutSidenav_content">
    <main >
        <div class="container-fluid px-4">
            <!--body#####################################################-->
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                include './db/db.php';
                include 'Date_Wise_Receive_Class.php';
                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];
                $item_name = $_POST['item_name'];
                $obj= new DateWiseReceive();
                if(isset($start_date) and isset($end_date) and isset( $item_name)){
                    $reportData=$obj->DateWiseNameReceiveReport($start_date,$end_date,$item_name);
                }elseif (isset($start_date) and isset($end_date)){
                    $reportData=$obj->DateWiseReceiveReport($start_date,$end_date);
                }
            }
            ?>
            <!-------------------------------------------------->
            <?php
            try {
                require 'vendor/autoload.php';
            if (isset($reportData)) {


                // Export the report to an Excel file
                $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $rowNumber = 1;

                // Set headers in the Excel file
                $headers = ['PO No', 'Supplier', 'Date', 'Category', 'Item', 'Brand', 'Size', 'item_price', 'Purchase Price', 'Quantity', 'Units', 'Total Price' , 'Purchase by'];
                $columnNumber = 1;
                foreach ($headers as $header) {
                    $sheet->setCellValueByColumnAndRow($columnNumber, $rowNumber, $header);
                    $columnNumber++;
                }

                // Set data in the Excel file
                $rowNumber = 2;
                foreach ($reportData as $row) {
                    $columnNumber = 1;
                    foreach ($row as $cellData) {
                        $sheet->setCellValueByColumnAndRow($columnNumber, $rowNumber, $cellData);
                        $columnNumber++;
                    }
                    $rowNumber++;
                }

                // Save the Excel file
                $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
                $filename = 'Date_Wise_Receive.xlsx';
                $writer->save($filename);
            }
            } catch (Exception $e) {
                echo 'An error occurred: ' . $e->getMessage();
            }
            
            ?>
            <!----------------------------------------------------------->
            <b><span class="text-success">Date Wise Receive</span></b>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

                <label for="start_date">Start Date:</label>
                <input type="datetime-local" name="start_date" required>

                <label for="end_date">End Date:</label>
                <input type="datetime-local" name="end_date" required>

                <label for="item_name">Item Name:</label>
                <input type="text" name="item_name" >

                <input type="submit" value="Generate Report">
                <span><a href="<?php echo $filename; ?>"><i class="fas fa-file-export"></i> Export</a></span>

            </form>

<!-------------------------------------------------------------------------->

<!------------------------------------------------------------------------>

<!----------------------------------------------------------------------------------->
            <style>
                #customers {
                    font-family: Arial, Helvetica, sans-serif;
                    border-collapse: collapse;
                    width: 100%;
                }

                #customers td, #customers th {
                    border: 1px solid #ddd;
                    padding: 2px;
                }

                #customers tr:nth-child(even){background-color: #f2f2f2;}

                #customers tr:hover {background-color: #ddd;}

                #customers th {
                    padding-top: 2px;
                    padding-bottom: 2px;
                    text-align: left;
                    background-color: #04AA6D;
                    color: white;
                }
            </style>
<!----------------------------------------------------------------------------------->
            <?php if(isset($reportData)): ?>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Date Wise Receive
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                        <tr>
                            <th>PO No</th>
                            <th>Supplier</th>
                            <th>Date</th>
                            <th>Category</th>
                            <th>Item</th>
                            <th>Brand</th>
                            <th>Size</th>
                            <th>Item Price</th>
                            <th>Purchase Price</th>
                            <th>Quantity</th>
                            <th>Units</th>
                            <th>Total Price</th>
                            <th>Purchase by</th>
                        </tr>
                        </thead>
                <?php foreach ($reportData as $row): ?>
                    <tr>
                        <td><?php echo $row['po_no']; ?></td>
                        <td><?php echo $row['supplier']; ?></td>
                        <td><?php echo $row['date']; ?></td>
                        <td><?php echo $row['category']; ?></td>
                        <td><?php echo $row['item']; ?></td>
                        <td><?php echo $row['brand']; ?></td>
                        <td><?php echo $row['size']; ?></td>
                        <td><?php echo $row['item_price']; ?></td>
                        <td><?php echo $row['purchase_price']; ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td><?php echo $row['units']; ?></td>
                        <td><?php echo $row['total_price']; ?></td>
                        <td><?php echo $row['cash1_creadit0']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>



            <?php endif; ?>




            <!--#####################################################-->
        </div>
    </main>


<!--###### Footer Part ###############################################-->
<?php
include '../template/footer.php';
?>
<!--#####################################################-->