<?php 
include 'partials/_database.php';
$login = false;
$invalid = false;
$pssInvalid = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST["username"];
    $password = $_POST["password"];

    if(($username != null) && ($password != null)) {
        $sql = "Select * from users where username='$username'";
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        if ($num == 1){
            while($row=mysqli_fetch_assoc($result)){
                if (password_verify($password, $row['password'])){ 
                    $login = true;
                    session_start();
                    $_SESSION['loggedin'] = true;
                    $_SESSION['username'] = $username;
                    header("location: welcome.php");
                } 
                else{
                    $pssInvalid=true;
                }
            }
        } else {
            $pssInvalid = true;
        }
    }else {
        $invalid = true;
    }
}    
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  </head>
  <body>
  <?php require 'partials/_nav.php' ?>
    <?php
    if($login){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>You Successfully Signup on our website.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    if($invalid){
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Fill the form.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    if($pssInvalid){
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Password not match.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    ?>
    <div class="container mt-3">
        <h3 class="text-center">Login here</h3>
        <form action="login.php" method="post">
  <div class="mb-3">
    <label for="username" class="form-label">Username</label>
    <input type="text" class="form-control" name="username" id="username">
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" name="password" class="form-control" id="password">
  </div>
  <button type="submit" class="btn btn-primary">login</button>
</form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
</html>