<!--### Header Part ##################################################-->
<?php
include '../template/header.php';
?>
<style>
    td,th{
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
        $("#Balance_Items").addClass("active bg-success");
    });
</script>



<!--#####################################################-->
<div id="layoutSidenav_content">
    <main >
        <div class="container-fluid px-4">
            <!--body#####################################################-->
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                //////////////////////////////////////////
                include './db/db.php';
                include 'Balance_Items_Class.php';
                //////////////////////////////////////////
                // $start_date = $_POST['start_date'];
                // $end_date = $_POST['end_date'];
                $item_name = $_POST['item_name'];
                $obj= new DateWiseReceive();
                if(isset($item_name)){
                    $reportData=$obj->DateWiseNameReceiveReport($item_name);
                }elseif (empty($start_date)){
                    $reportData=$obj->DateWiseReceiveReport();
                }
            }
            ?>
            <!-------------------------------------------------->
            <?php
            //print_r($reportData);
            require 'vendor/autoload.php';
            if (isset($reportData)) {


                // Export the report to an Excel file
                $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $rowNumber = 1;

                // Set headers in the Excel file
                $headers = ['Category', 'Item', 'Size', 'Unit', 'Price', 'Total Purchase', 'Total Purchase Price', 'Total Issue', 'Total Issue Price', 'Stock', 'Stock Price'];
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
                $filename = 'Balance_Items.xlsx';
                $writer->save($filename);
            }
            ?>
            <!----------------------------------------------------------->
            <b><span class="text-success">Balane Items</span></b>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

                <!-- <label for="start_date">Start Date:</label>
                <input type="datetime-local" name="start_date" >

                <label for="end_date">End Date:</label>
                <input type="datetime-local" name="end_date" > -->

                <label for="item_name">Item/Category Name:</label>
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
                    Balance Items
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                        <tr>

                            <th>Category</th>
                            <th>item</th>
                            <th>size</th>
                            <th>unit</th>
                            <th>price</th>
                            <th>Total Purchase</th>
                            <th>Total Purchase Price</th>
                            <th>Total Issue</th>
                            <th>Total Issue Price</th>
                            <th>Stock</th>
                            <th>Stock Price</th>

                        </tr>
                        </thead>
                    <?php foreach ($reportData as $row): ?>
                        <tr>
                            <td><?php echo $row['category']; ?></td>
                            <td><?php echo $row['item']; ?></td>
                            <td><?php echo $row['size']; ?></td>
                            <td><?php echo $row['unit']; ?></td>
                            <td><?php echo $row['price']; ?></td>
                            <td><?php echo $row['total_purchase']; ?></td>
                            <td><?php echo $row['total_purchase_price']; ?></td>
                            <td><?php echo $row['total_issue']; ?></td>
                            <td><?php echo $row['total_issue_price']; ?></td>
                            <td><?php echo $row['Stock']; ?></td>
                            <td><?php echo $row['stock_price']; ?></td>
                            
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