<?php

session_start();


  if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true && $_SESSION['csrf_index']==true) {
    // Redirect the user to the login page or display an error message
    header("Location: http://".$_SESSION['base_url']."/store/layout/start/");
    exit();
  }
  
?>


<!doctype html>
<html lang="en">

<head>
  <title>Title</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body class="d-flex align-items-center justify-content-center" style="min-height: 100vh;">
  <header>
    <!-- place navbar here -->
  </header>
  <main class="container" style="background-color: rgba(0,0,0,0.2);">
    <!-- Section: Design Block -->
    <section class="text-center text-lg-start">
      <style>
        body {
          background-color: #f4f4f4;
          background-image: url('bg.jpg');
          /* Replace 'path/to/your/image.jpg' with the actual path to your image */
          background-size: cover;
          /* Adjusts the background image size to cover the entire body */
          background-repeat: no-repeat;
          /* Prevents the background image from repeating */
        }

        .rounded-t-5 {
          border-top-left-radius: 0.5rem;
          border-top-right-radius: 0.5rem;
        }

        @media (min-width: 992px) {
          .rounded-tr-lg-0 {
            border-top-right-radius: 0;
          }

          .rounded-bl-lg-5 {
            border-bottom-left-radius: 0.5rem;
          }
        }
      </style>
      <div class="card mb-3 " style="background-color: rgba(255,255,255,0.6);">
      <div class="row">
        <?php
        if(isset($_GET['error'])){
          echo "<div class='alert alert-danger' role='alert'>
          Invalid username or password.";
        }
        ?>
      </div>
        <div class="row g-0 d-flex align-items-center">
          <div class="col-lg-4 d-none d-lg-flex">
            <img src="site_logo.jpg" alt="Trendy Pants and Shoes"
              class="w-100 rounded-t-5 rounded-tr-lg-0 rounded-bl-lg-5" />
          </div>
          <div class="col-lg-8">
            <div class="card-body py-5 px-md-5">

              <form method="POST" action="index_process1.php">
                <!-- Email input -->
                <div class="form-outline mb-4">
                  <input type="email" name="email" id="form2Example1" class="form-control" />
                  <label class="form-label"  for="form2Example1">Email address</label>
                </div>

                <!-- Password input -->
                <div class="form-outline mb-4">
                  <input type="password" name="password" id="form2Example2" class="form-control" />
                  <label class="form-label"  for="form2Example2">Password</label>
                </div>

                <!-- 2 column grid layout for inline styling -->
                <div class="row mb-4">
                  <div class="col d-flex justify-content-center">
                    <!-- Checkbox -->
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="form2Example31" checked />
                      <label class="form-check-label" for="form2Example31"> Remember me </label>
                    </div>
                  </div>

                  
                </div>

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block mb-4">Sign in</button>

              </form>

            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Section: Design Block -->
  </main>
  <footer>
    <!-- place footer here -->
  </footer>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
</body>

</html>
