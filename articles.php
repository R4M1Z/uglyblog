<?php
include 'header.php';
if($loggedin==true){
  if(!isset($_GET['id'])){
    header("Location:index.php");
  }else{
    $id=mysqli_real_escape_string($conn,$_GET['id']);
    $sql="SELECT * FROM articles WHERE id='$id'";
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)===0){
      header("Location:404.html");
      exit;
    }
    $article=mysqli_fetch_assoc($result);
    echo "<script> document.title = '".addslashes(htmlspecialchars($article['title']))."'</script>";
    mysqli_free_result($result);
  }
}else{
  header("Location:login.php");
}
?>
    <h3><?= htmlspecialchars($article['title']) ?></h3>
    <p><?= htmlspecialchars($article['content']) ?></p>
    <span><?= "<a href='profile.php?username=".htmlspecialchars($article['created_by'])."'>".htmlspecialchars($article['created_by'])."</a>"?></span><br>
    <span><?= htmlspecialchars($article['created_at'])?></span>

  </body>
</html>
