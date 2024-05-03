<?php
include '../template/header.php';
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Add 'show' class to the element with ID "collapseLayouts2"
    $(document).ready(function() {
        $("#collapseLayouts3").addClass("show");
        $("#collapseLayouts3_add").addClass("active bg-success");
    });
</script>


            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h2></h2>

            <form id="submitForm" action="http://<?php echo $_SESSION['base_url'];?>/store/layout/issue_item/issue.php" method="POST">
            <!--////////////category button///////////////////////////////////////////////////////////////////////////-->
            <div class="form-group" >
                <div class="">
                <h4 class="text-light">Issue product</h4>
                </div>
                <label for="live_search">Search By Employee</label>
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
                                url: "livesearch.php",
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
                    
                    </form>









                    </div>
                </main>
                <div id="valueDiv" class="bg-success h3"></div>
                    <script>
                    // Get the value from the URL query parameter
                    const urlParams = new URLSearchParams(window.location.search);
                    const value = urlParams.get('value');

                    // Display the value
                    document.getElementById('valueDiv').innerText = value;

                    // Vanish after 3 seconds
                    setTimeout(function() {
                    document.getElementById('valueDiv').innerText = '';
                    }, 3000);
                </script>
                
<!--######################################################################################################-->
<!--###### Footer Part ###############################################-->
<?php
include '../template/footer.php';
?>
<!--#####################################################-->
