<?php 
include 'partials/_database.php';
$showAlert = false;
$passNotMatch = false;
$exitUser = false;
$nullError = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST["username"];
    $password = $_POST["password"];
    $passwordConfirm = $_POST["passwordConfirm"];

    if(($username != null) && ($password != null)) {
        $exitUserSql = "Select * from users where username='$username'";
        $result = mysqli_query($conn, $exitUserSql);
        $num = mysqli_num_rows($result);
        if($num>0){
            $exitUser = true;
        } else {
            if($password == $passwordConfirm) {
                $hasPass = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO `users` (`username`, `password`) VALUES ('$username', '$hasPass')";
                $result = mysqli_query($conn, $sql);
                if($result){
                    $showAlert = true;
                }
            }
            else {
                $passNotMatch = true;
            }
        }
    }else {
        $nullError = true;
    }
}    
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Signup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  </head>
  <body>
    <?php require 'partials/_nav.php' ?>
    <?php
    if($showAlert){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>You Successfully Signup on our website.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    if($passNotMatch){
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Password not match.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    if($exitUser){
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>User allready exit.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    if($nullError){
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Fill the all required input.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    ?>
    <div class="container mt-3">
        <h3 class="text-center">Login here</h3>
        <form action="signup.php" method="post">
  <div class="mb-3">
    <label for="username" class="form-label">Username</label>
    <input type="text" class="form-control" maxlength="10" name="username" id="username">
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" name="password" maxlength="10" class="form-control" id="password">
  </div>
  <div class="mb-3">
    <label for="passwordConfirm" class="form-label">Confirm Password</label>
    <input type="password" name="passwordConfirm" maxlength="10" class="form-control" id="passwordConfirm">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
</html>