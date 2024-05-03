<!--### Header Part ##################################################-->
<?php
include '../template/header.php';
?>
<!--#####################################################-->
           
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Add 'show' class to the element with ID "collapseLayouts2"
    $(document).ready(function() {
        $("#collapseLayouts2").addClass("show");
        $("#collapseLayouts2_search").addClass("active bg-success");
    });
</script>
<!--///////////////////////////////////////////////////////////-->
<style>
    .info-row {
        display: none; /* Hide the info rows by default */
    }

    .info-content {
        background-color: #f0f0f0;
        padding: 10px;
    }

    .hidden-heading {
        font-weight: bold;
        background-color: #f0f0f0;
        padding: 10px;
    }

    /* Apply styles to the .info-row that is a direct child of tbody */
    tbody > .info-row:nth-child(even) {
        background-color: #f9f9f9;
    }

    tbody > .info-row:nth-child(odd) {
        background-color: #ffffff;
    }
</style>
<style>
    .custom-info-row {
        display: none; /* Hide the info rows by default */
    }

    .custom-info-content {
        background-color: #f0f0f0;
        padding: 10px;
    }

    .custom-hidden-heading {
        font-weight: bold;
        background-color: #f0f0f0;
        padding: 10px;
    }

</style>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Add 'show' class to the element with ID "collapseLayouts2"


    // Add event listeners to the buttons
    $(document).on("click", ".info-button", function() {
        var row = $(this).closest("tr").next(".info-row");

        if (row.hasClass("info-row")) {
            if (row.css("display") === "table-row") {
                row.css("display", "none");
            } else {
                row.css("display", "table-row");
            }
        }
    });
</script>
<!--/////////////////////////////////////////////////////////////-->

<div id="layoutSidenav_content">
<!--main content////////////////////////////////////////////////////////////////////////////////-->
                <main>
                    <div class="container-fluid px-4">
                    <div class=".bg-light .bg-gradient  p-3">
<!-- Add Product //////////////////////////////////////////////////////////////////////-->
                    <h2 class="mt-5 mb-4 text-light">Search Purchase Product </h2>


        <form id="submitForm"  method="POST">
 <!--////////////category button///////////////////////////////////////////////////////////////////////////-->
            <div class="form-group" >
                <div class="">
                
                </div>
                <input type="text" class="form-control" id="live_search" autocomplete="off" placeholder="Search...">
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
                                url: "livesearch_list.php",
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
<!--//////end catagory button /////////////////////////////////////////////////////////////////////////////////-->

                                                
                
<!--main content//////////////////////////////////////////////////////////////////////////////////-->
 <!--###### Footer Part ###############################################-->
<?php
include '../template/footer.php';
?>
<!--#####################################################-->