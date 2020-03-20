<?php
$title="Delete account";
include 'header.php';
if(!$loggedin){
  echo "<script>alert('You must log in to delete account');
  window.location = 'login.php';</script>";
  exit;
}
$errors = array('empty' =>'','incorrect'=>'');
if(isset($_POST['submit'])){
  $submit=$_POST['submit'];
  $username=$_POST['username'];
  $password=$_POST['password'];
  if(trim($username)==''|| trim($password)==''){
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
      $username=mysqli_real_escape_string($conn,$_POST['username']);
      $sql="DELETE FROM users WHERE username='$username'";
      if(isset($_POST['delete_articles'])){
        $sqla="DELETE FROM articles WHERE created_by='$username'";
      }
      if(mysqli_query($conn,$sql)){
        if(isset($_POST['delete_articles'])){
            $sql="DELETE FROM articles WHERE created_by='$username'";
            mysqli_query($conn,$sql);
        }
        setcookie('username','',time()-3600);
        session_unset();
        echo "<script> alert('DELETED');
        window.location = 'login.php?action=deleted';</script>";
        exit;
      }
      else{
          echo "Cannot delete ".mysqli_error($conn);
      }
  }
}

?>
          <div class=container>
              <h3>Delete Account</h3>
        <form class="getinfo" action="delete.php" method="post">
          <label>Username:</label><br>
          <input type="text" name="username"readonly='readonly'placeholder="username" value="<?= htmlspecialchars($current_user) ?>"><br>
          <label>Password:</label><br>
          <input minlength="5" type="password" name="password" placeholder="password"><br>
          <input type="checkbox" checked name="delete_articles">
          <label>Do you want to delete your articles too?</label><br><br>
          <input class="btn" type='submit' name="submit" value='Delete'><br><br>
        </form>
                  <div style="color:red;"><?php
          foreach ($errors as $error) {
            echo $error;
          }
           ?></div>
      </div>
  </body>
</html>
