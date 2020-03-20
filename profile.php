<?php
$title="Profile Page";
include 'header.php';
$deleted=false;
if($loggedin){

  if(!isset($_GET['username']) || $_GET['username']==$current_user){
    $itsme=true;
    $username=mysqli_real_escape_string($conn,$current_user);
  }
  if(isset($_GET['username']) && $_GET['username']!=$current_user){
  $itsme=false;
  $username=mysqli_real_escape_string($conn,$_GET['username']);
  }
  $sql="SELECT * FROM users WHERE username='$username'";
  $uresult=mysqli_query($conn,$sql);
  $user=mysqli_fetch_assoc($uresult);
  echo "<script> document.title = '".htmlspecialchars($user['name'])."'</script>";
  $sql="SELECT * FROM articles WHERE created_by='$username'";
  $aresult=mysqli_query($conn,$sql);
  $articles=mysqli_fetch_all($aresult,MYSQLI_ASSOC);
  if(empty($user) && empty($articles)){
    header("Location: 404.html");
    exit;
  }else if(empty($user) && !empty($articles)){
    $deleted=true;
    echo "<script> document.title = 'Deleted'</script>";
  }
  mysqli_free_result($aresult);
  mysqli_free_result($uresult);
}
else{
    header("Location: login.php");
    exit;
}
?>
      <div class="container">
        <?php if($deleted)echo "<h1>This account is deleted.</h1>";else{ ?>
          <h2><?= htmlspecialchars($user['name']) ?></h2>
          <p><?= htmlspecialchars($user['about']) ?></p>
        <?php } ?>
      </div>
<hr>
        <h2 style="margin-left:40%;"><?php echo count($articles)!=0 ? "Articles" : "There is not any articles to show"?></h2>
        <?php foreach ($articles as $article) {?>
          <h3><?= "<a href='articles.php?id=".$article['id']."'>".htmlspecialchars($article['title'])."</a>"?></h3>
          <p><?= htmlspecialchars(mb_substr($article['content'], 0, 200))."<a href='articles.php?id=".$article['id']."'> ...read more </a>" ?></p>
          <?php if($itsme){?><span><?= "<a href='deletearticle.php?id=".htmlspecialchars($article['id'])."'> Delete this article</a>" ?></span><?php } ?>
          <hr>
        <?php } ?>
        <footer>
          <a style="margin-left: 80%;" href="delete.php">Delete your account</a>
        </footer>
    </body>
</html>
