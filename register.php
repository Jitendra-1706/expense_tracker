<?php
require_once "./config.php";


if (isset($_POST['submit'])) {

  // data from user
  $username =  $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $reEnterPassword = $_POST['re-enterpassword'];
  $encryptedPassword = password_hash($password,PASSWORD_DEFAULT);
  $checkUser = mysqli_query($link, "SELECT * FROM user WHERE email = '$email'");

  // used to check the user exists 
  if (mysqli_num_rows(($checkUser)) > 0) {
    echo "<script>alert('Email Already Registered')</script>";
  }else{
    // password validation
    if($password === $reEnterPassword){
      $query = "INSERT INTO user(username, email,password) VALUES('$username','$email','$encryptedPassword')";
      
      // used to insert the data and redirect
      if(mysqli_query($link, $query)){
        echo "<script>alert('Registered Successfully')</script>";
        header("refresh:4; url=login.php");
      }else{
        echo "<script>alert('Failed to register')</script>";
      }
    }else{
      echo "<script>alert('Password doesnt match')</script>";
    }
  }
}






?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="/expense_tracker/assets/css/register.css">

</head>

<body>


<div class="wrapper-1">
<form action="" method="POST">
  <h1>Login</h1>

  <div class="input-box">
    <input type="text" name="username" placeholder="Enter your name" required>
    <i class='bx bxs-user'></i>
  </div>
  <div class="input-box">
    <input type="email" name="email" placeholder="Enter your  Email" required>
    <i class='bx bxs-user'></i>
  </div>

  <div class="input-box">
    <input type="password" name="password" placeholder="Password" required>
    <i class='bx bxs-lock-alt'></i>
  </div>
  <div class="input-box">
    <input type="password" name="re-enterpassword" placeholder="Password" required>
    <i class='bx bxs-lock-alt'></i>
  </div>



  <button type="submit" name="submit" class="btn-1">Register</button>

  <div class="register-link">
    <p>Already have account? <a href="./login.php">Login</a></p>
  </div>
</form>

</div>





























  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>