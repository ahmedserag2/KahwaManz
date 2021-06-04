<html>
<head>
 
<link rel="stylesheet" href="CSS/style.css" type="text/css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    
    </head>
   
    
<body>
<?php include_once "../classes.php";
 ?>



 
<?php 
    $errormsg = "";
    if(isset($_POST['username']))
    {
        $email = $_POST['username'];
        $password = $_POST['upassword'];

        $user = new User(null); 
        $logged = $user->by_login($email,$password);
        if($logged)
        {
            session_start();
            $_SESSION['user'] = $user;
            header("Location:admin_drinks.php");

        }
        else{
            $errormsg = "invalid email or password";
        }

    }
?>

<form action="" method="post">
  <div class="imgcontainer wow fadeIn">
    
      <div class="line"></div>
  </div>
  <div class="container">
      <h2 class="title wow flipInX" data-wow-delay="0.5s">Sign In</h2>
    
    <label for="uname"><b>Email</b></label><br>
    <input type="email" class="form-control" placeholder="Enter email"  id="uname" name="username" required><br>

    <label for="psw"><b>Password</b></label><br>
    <input type="password" class="form-control" placeholder="Enter Password"  id="pass" name="upassword" required><br><br>
    <?php echo "<h4 style='color: red'>".$errormsg."</h4>"; ?>
    <button class="btn mybtn" name="Submit" type="submit">Login</button><br>
    
      
  </div>

</form>

    
    
</body>
</html>