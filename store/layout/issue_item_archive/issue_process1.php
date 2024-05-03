<!--### Header Part ##################################################-->
<?php
include '../template/header.php';
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!--main content////////////////////////////////////////////////////////////////////////////////-->
<div id="layoutSidenav_content">           
<main>
<div class="container-fluid">

    <?php
$serverName = "BDAPPSS02V\SQLEXPRESS";
$database = "hlfs";
$username = "sa";
$password = "sa@123";


try {
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

         $query = "SELECT i_name FROM item";
         $stmt = $conn->prepare($query);
         $stmt->execute();
         $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
//////////////////////////////////////////////
         function query($sql,$conn){
            $query = $sql;
         $stmt = $conn->prepare($query);
         $stmt->execute();
         $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
         return $result;
         }

   ///////////////////////

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $products = $_POST['product'];
    $quantities = $_POST['quantity'];
     print_r($products);
     print_r($quantities);
    if (count($products) === count($quantities)) {
        echo "<h3>Issued Items: count product".count($products)." count item ".count($quantities)."</h3>";
        for ($i = 0; $i < count($products); $i++) {
            echo "<p>Product: " . htmlspecialchars($products[$i]) . ", Quantity: " . htmlspecialchars($quantities[$i]) . "</p>";
        }
    } else {
        echo "<p>Product and Quantity counts do not match.</p>";
    }
}


?>
      
    <h2>Issue Item</h2>
    

        <form method="post" action="">
        <div >
                <h4 class="fs-2 font-weight-bold"><b>Select Employee</b></h4>
                </div>
                <input type="text" class="form-control" id="live_search" autocomplete="off" placeholder="Search..." required>
                
                </div>

                <div id="search_result"></div>
               

                 <!-- jQuery -->
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
                    <!-- Optional Bootstrap JavaScript -->
                    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

                    <script type="text/javascript">
                        $(document).ready(function() {
                        $("#live_search").keyup(function() {
                            var input = $(this).val();
                            if (input !== "") {
                            $.ajax({
                                url: "livesearch_employee.php?var=<?php echo $_GET['id']; ?>",
                                method: "POST",
                                data: { input: input },
                                success: function(data) {
                                $("#search_result").html(data);
                                }
                            });
                            } else {
                            $("#search_result").empty();
                            }
                        });
                        });
                    </script>
            
        <div class="row">
            <div class="col-6">
                    <div class="form-group">
                        <label for="invoice">Invoice</label>
                        <input type="text" class="form-control" id="invoice" name="invoice" >
                    </div>
            </div>

            <div class="col-6">
                    <div class="form-group">
                        <label for="e_id">Employee Information</label>
                        <?php
                        $e_id=$_GET['id'];
                        $sql="SELECT e_com_id,e_name,d_name 
                        from employee INNER JOIN department ON department.d_id=employee.d_id 
                        WHERE e_id= $e_id";
                        $emp=query($sql,$conn);
                        //print_r($emp);
                        
                        ?>
                        <input readonly class="form-control" id="e_id" name="e_id" 
                        placeholder="<?php echo "Name:".$emp[0]['e_name']." ID:".$emp[0]['e_com_id']." Dep:".$emp[0]['e_name'].""; ?>" >
                    </div>
            </div>
        </div>
         
 
    <div class="row">
    <div class="col-2">
                <div class="form-group">
                <label for="search">Item</label>
                <input list="items" class="form-control" id="product" name="product[]" placeholder="Search...">
                <datalist id="items">
                 <?php
                 ///Fetch item record
                  if ($result) {
                      foreach ($result as $row) {
                          echo '<option value="' . $row['i_name'] . '"></option>';
                      }    
                  } else {
                      echo "<p>No results found.</p>";
                  }
                 ?>
                </datalist>
                </div>
    </div>


    <div class="col-2">
    <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" class="form-control" id="quantity" name="quantity[]" required>
            </div>
    </div>
    </div>
    
    

            <div class="form-group" id="itemsContainer">
                <!-- Dynamic items will be added here -->
            </div>



            <div class="row">
                  <div class="col-6">
                  <button type="button" class="btn btn-primary" onclick="addNew()">Add New</button>                 
                  </div>

                  <div class="col-6">
                  <button type="submit" class="btn btn-success mt-3" name="submit">Issue</button>
                  </div>
            </div>
        </form>    
   
        

        <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    let itemCount = 1;
    let items = <?php echo json_encode($result); ?>;             
    function addNew() {
        let newItem = `
            <div class="form-group" id="item${itemCount}">
                <label for="product${itemCount}">Search Product by Name:</label>
                <input list="items" class="form-control" id="product${itemCount}" name="product[]" required placeholder="Search...">
                <datalist id="items${itemCount}">
                                ${items.map(item => `<option value="${item.i_name}"></option>`).join('')}
                </datalist>

                <label for="quantity${itemCount}">Quantity:</label>
                <input type="number" class="form-control" id="quantity${itemCount}" name="quantity[]" required>
            </div>
        `;
        document.getElementById('itemsContainer').insertAdjacentHTML('beforeend', newItem);
        itemCount++;
    }
</script>




</div>
</main>

<!--main content//////////////////////////////////////////////////////////////////////////////////-->

<!--###### Footer Part ###############################################-->
<?php
include '../template/footer.php';
?>
<!--#####################################################-->