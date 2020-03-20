<?php
$title="Delete article";
include 'header.php';
if($loggedin){
  if(!isset($_GET['id'])){
    header("Location:index.php");
  }
  else{
    $id=mysqli_real_escape_string($conn,$_GET['id']);
    $sql="SELECT * FROM articles WHERE id='$id'";
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)===0){
      header("Location:404.html");
    }
    else{
      $article=mysqli_fetch_assoc($result);
      mysqli_free_result($result);
      if($article['created_by']!=$current_user){
        echo "<script>alert('You don\'t have permission to delete this article');
        window.location = 'index.php';</script>";
      }
      else{
        $sql="DELETE FROM articles WHERE id='$id'";
        if(isset($_POST['yes'])){
          if(mysqli_query($conn,$sql)){
            echo "<script> alert('DELETED');
            window.location = 'profile.php';</script>";
          }else{
            echo "e ".mysqli_error($conn);
          }
        }else if(isset($_POST['no'])){
          header("Location:profile.php");
        }
      }
    }
  }
}
else{
  header("Location: login.php");
}
?>
<div class="container">

<strong>Deleting article: <?= htmlspecialchars($article['title']) ?></strong>
<p> Are you really want to delete this article? </p><br>
<label>Press yes if you are:</label><br>
<form action="<?= "deletearticle.php?id=".htmlspecialchars($id)?>" method="post">
  <input type="submit" name="yes" value="YES">
  <input type="submit" name="no" value="NO">
</form>
</div>
</body>
</html>
