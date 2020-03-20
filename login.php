<?php
$title="Log in";
include 'header.php';
if($loggedin){
  if(isset($_GET['action']) && $_GET['action']=='logout'){
    setcookie('username','',time()-3600);
    session_unset();
    header("Location: login.php");
  }
  header("Location:profile.php");
}
$errors = array('empty' =>'','incorrect'=>'');
$username='';
if(isset($_POST['submit'])){
  $submit=$_POST['submit'];
  $username=$_POST['username'];
  $password=$_POST['password'];
  if(trim($username)==''||trim($password)==''){
    $errors['empty']="Don't leave any field empty";
  }
  else{
    $username=mysqli_real_escape_string($conn,$_POST['username']);
    $sql="SELECT * FROM users WHERE username='$username'";
    $result=mysqli_query($conn,$sql);
    $user=mysqli_fetch_assoc($result);
    if(!password_verify($password,$user['password'])){
      $errors['incorrect']="Username or password is incorrect";
    }
  }
  if(!array_filter($errors)){
      if(isset($_POST['remember_me'])){
      setcookie('username',$user['username'],time()+172800);

      }else{
      $_SESSION['username']=$user['username'];}
      header("Location: index.php");
      }
    }
?>
      <div class=container>
        <form class="getinfo" action="login.php" method="post">
          <label>Username:</label><br>
          <input type="text" name="username" placeholder="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ""?>"><br>
          <label>Password:</label><br>
          <input minlength="5" type="password" name="password" placeholder="password"><br>
          <div style="padding-bottom:20px;">
          <input type="checkbox" name="remember_me">
          <label style="margin-left:0;color:#000;">Remember me</label>
          </div>
          <input class="btn" type='submit' name="submit" value='Log in'><br><br>
          <a type="button" class="btn" style="margin-top: -40px;margin-left:40px;" href='signup.php' target="_blank">SignUp</a>
        </form>
      </div>
          <div style="color:red;"><?php
          foreach ($errors as $error) {
            echo $error;
          }
           ?></div>
  </body>
</html>
