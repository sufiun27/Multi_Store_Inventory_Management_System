<?php

session_start();


  if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true && $_SESSION['csrf_index']==true) {
    // Redirect the user to the login page or display an error message
    header("Location: http://".$_SESSION['base_url']."/store/layout/start/");
    exit();
  }
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login Form</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f4f4f4;
      background-image: url('bg.jpg'); /* Replace 'path/to/your/image.jpg' with the actual path to your image */
    background-size: cover; /* Adjusts the background image size to cover the entire body */
    background-repeat: no-repeat; /* Prevents the background image from repeating */

    }
    .container {
      margin-top: 100px;
    }
    .card {
      box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
      
      padding: 30px;
      border-radius: 10px;
      background-color: #fff;
    }
    .form-group {
      margin-bottom: 20px;
    }
    .logo-img {
    width: 80px; /* Adjust the width to your preferred size */
    height: auto; /* Maintain the aspect ratio */
    margin-right: 10px; /* Add some space between the logo and the text */
}
  </style>
</head>
<body >
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <h4 class="text-center mb-4"><img src="logo.jpg" alt="Logo" class="logo-img"> Login Form</h4>
          <form action="login.php" method="post">
            <div class="form-group">
              <label for="username">Username</label>
              <input required type="text" class="form-control" id="username" name="username" placeholder="Enter your username">
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input required type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
