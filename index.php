<?php
$title="Home";
include 'header.php';
if($loggedin==true){
  $sql="SELECT * FROM articles ORDER BY created_at DESC";
  $result=mysqli_query($conn,$sql);
  $articles=mysqli_fetch_all($result, MYSQLI_ASSOC);
  mysqli_free_result($result);
}
else{
header("Location: login.php");
}
?>
    <style >
      a{
        color:blue;
        text-decoration:none;
      }
      h3 a{
        color:#000;
      }
    </style>
    <?php foreach ($articles as $article) {?>
      <h3><?= "<a href='articles.php?id=".$article['id']."'>".htmlspecialchars($article['title'])."</a>"?></h3>
      <p><?= htmlspecialchars(mb_substr($article['content'], 0, 200))."<a href='articles.php?id=".$article['id']."'> ...read more </a>" ?></p>
      <span><?= "written by: <a href='profile.php?username=".htmlspecialchars($article['created_by'])."'>".htmlspecialchars($article['created_by'])."</a>" ?></span><br>
      <span> <?= $article['created_at'] ?></span>
      <hr>
    <?php } ?>
  </body>
</html>
