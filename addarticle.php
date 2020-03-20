<?php
$title="Add article";
include 'header.php';
$empty_e=$title=$content="";
if($loggedin!=true){
  header("Location:login.php");
}
if(isset($_POST['submit'])){
  $username=$_SESSION['username'] ?? $_COOKIE['username'];
  $title=$_POST['title'];
  $content=$_POST['content'];
  if(trim($title)=="" || trim($content)==""){
    $empty_e="Don't leave any field empty!";
  }
  if($empty_e==""){
  $title=mysqli_real_escape_string($conn,$_POST['title']);
  $content=mysqli_real_escape_string($conn,$_POST['content']);
  $created_by=mysqli_real_escape_string($conn,$username);
  $sql = "INSERT INTO articles (title,content,created_by) VALUES ('$title','$content','$created_by')";
  if(mysqli_query($conn,$sql)){
    header("Location:index.php");
  }else{
    echo mysqli_connect_error($conn);
  }}
}

?>
    <form class="container" action="addarticle.php" method="post">
      <div class="error"><?= $empty_e; ?></div><br>
      <label>Title</label><br>
      <input type="text" name="title" value="<?= htmlspecialchars($title) ?>"><br>
      <label>Content</label><br>
      <textarea style="width: 510px; height: 250px;" name="content"><?= htmlspecialchars($content) ?></textarea><br><br>
      <input class="btn" type="submit" name="submit" value="Add">
    </form>
  </body>
</html>
