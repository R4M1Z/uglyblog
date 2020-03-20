<?php
$title="Sign up";
include 'header.php';
if($loggedin==true){
  header("Location: profile.php");
}else{

$errors = ['not_secure'=>'','email'=> '', 'empty'=>'','pass'=>'','username_taken'=>'','email_taken'=>'','encode'=>'','invalid_uname'=>''];
if(isset($_POST['submit'])){
  $submit=$_POST['submit'];
  $name=$_POST['name'];
  $email=$_POST['email'];
  $username=$_POST['username'];
  $password=$_POST['password'];
  $confirm=$_POST['confirm'];
  $about=$_POST['about'];
  if(trim($name)=='' || trim($email)=='' || trim($username)=='' || trim($password)=='' || trim($confirm)==''){
    $errors['empty']="You can't leave empty any of these fields! ";
  }
  if($password!=$confirm){
    $errors['pass']="Passwords does not match!";
  }
  if (!preg_match('/[a-zA-Z]/', $password) || !preg_match('/\d/', $password)){
    $errors['not_secure']="Your password must contain numbers and letters";
  }
  if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    $errors['email']='It is not a valid address';
  }
  if(preg_match('/[^\x20-\x7e]/', $username) || preg_match('/[^\x20-\x7e]/', $password)){
      $errors['encode']="Please don't use non-ASCII characters";
  }
  if(preg_match('/[^a-z0-9]/', $username)){
      $errors['invalid_uname']="It is not a valid username";
  }
  $username=mysqli_real_escape_string($conn,$_POST['username']);
  $sql="SELECT * FROM users WHERE username = '$username'";
  $result=mysqli_query($conn,$sql);
  $uname=mysqli_fetch_all($result,MYSQLI_ASSOC);

  $email=mysqli_real_escape_string($conn,$_POST['email']);
  $sql="SELECT * FROM users WHERE email = '$email'";
  $result=mysqli_query($conn,$sql);
  $uemail=mysqli_fetch_all($result,MYSQLI_ASSOC);
  if(!empty($uname)){
    $errors['username_taken']="This username is already taken!";
  }
  if(!empty($uemail)){
    $errors['email_taken']="This email is already taken!";
  }
  mysqli_free_result($result);
  if(!array_filter($errors)){
    $name  = mysqli_real_escape_string($conn,$_POST['name']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $password = mysqli_real_escape_string($conn,password_hash($_POST['password'], PASSWORD_DEFAULT));
    $about = mysqli_real_escape_string($conn,$_POST['about']);
    $sql = "INSERT INTO users (name,email,username,password,about) VALUES ('$name','$email','$username','$password','$about')";
    if(mysqli_query($conn,$sql)){
      header("Location: login.php");
    }
    else{
      echo "Oops!";
    }
  }
}

}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" type="text/css"  href="style/style.css">
  </head>
  <body>
    <div class="container">

    <form action="signup.php" id="registerform" method="post">
      <div class="error"><?php echo $errors['empty']; ?></div>
      <label><span style='color:red;'>*</span> Full Name: </label><br>
      <input type="text" name="name" placeholder="Full Name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ""?>"><br>

      <label> <span style='color:red;'>*</span> Email: </label>
      <div class="error"> <?php echo $errors['email']; ?> </div>
      <div class="error"> <?php echo $errors['email_taken']; ?> </div>
      <input type="text" name="email" placeholder="Your email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ""?>"><br>

      <label> <span style='color:red;'>*</span> Username: </label><br>
      <div class="error"> <?php echo $errors['username_taken'];echo $errors['encode'];echo $errors['invalid_uname']; ?> </div>
      <input type="text" name="username" placeholder="Pick a username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ""?>"><br>

      <label> <span style='color:red;'>*</span> Password: </label><br>
      <div class="error"> <?php echo $errors['encode'];echo $errors['not_secure']; ?> </div>
      <input id="password" type="password" name="password" minlength="5" placeholder="Set a password"><br>

      <label> <span style='color:red;'>*</span> Confirm: </label><br>
      <div class="error"> <?php echo $errors['pass']; ?> </div>
      <input id="password" type="password"  name="confirm" minlength="5" placeholder="Confirm password"><br>

      <label> About you: </label><br>
      <textarea name="about" form="registerform" placeholder="Bio..(optional)"><?php echo isset($_POST['about']) ? htmlspecialchars($_POST['about']) : ""?></textarea>

      <input class="btn" type="submit" name="submit" value="Get registered now!">
    </form>
  </div>

  </body>
</html>
