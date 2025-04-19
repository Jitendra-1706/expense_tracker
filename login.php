<?php
require_once "./config.php";

session_start();
if(!empty($_SESSION['id'])){
  header("Location:index.php");
}
if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $result = mysqli_query($link, "SELECT * FROM user WHERE  username ='$username' OR email='$username' ");
    $row = mysqli_fetch_assoc($result);

    if (mysqli_num_rows($result) > 0) {
      if (password_verify($password, $row['password'])) {
        $_SESSION["login"] = true;
        $_SESSION["id"] = $row["id"];
        $_SESSION["username"] = $row["username"];
        header("Location: index.php");
      } else {
        echo
        "<script> alert('Wrong Password'); </script>";
      }
    } else {
      echo
      "<script> alert('User Not Registered'); </script>";
    }
  }













?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="/expense_tracker/assets/css/login.css?v=timestamp">

  </head>
  <body>
    
<div class="wrapper-1">
<form action="" method="POST">
  <h1>Login</h1>

  <div class="input-box">
    <input type="text" name="username" id="user" class="input-field" required>
    <label for="user" class="label">Username</label>
    <i class='bx bxs-user'></i>
  </div>

  <div class="input-box">
    <input type="password" name="password" id="pass" class="input-field"  required>
    <label for="pass" class="label">Password</label>
    <i class='bx bxs-lock-alt'></i>
  </div>

  <div class="remember-forgot">
    <label><input type="checkbox"> Remember me</label>
    <a href="#">Forgot Password?</a>
  </div>

  <button type="submit" name="submit" class="btn-1">Login</button>

  <div class="register-link">
    <p>Don't have an account? <a href="./register.php">Register</a></p>
  </div>
</form>

</div>

    

























<?php include("./includes/footer.php") ?>

  </body>
</html>