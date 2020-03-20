<?php
include 'config/db_connect.php';
session_start();
if(isset($_SESSION['username']) || isset($_COOKIE['username'])){
  $loggedin=true;
  $current_user=$_SESSION['username'] ?? $_COOKIE['username'];
}else{
  $loggedin=false;
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style/style.css">
    <title><?= htmlspecialchars($title) ?></title>
  </head>
  <body>
    <?php if($loggedin){ ?>
      <span style="margin-left:10px"><?= "<a href='index.php'>Home</a>"; ?></span> |
      <span><?= "<a href='addarticle.php'>Add article</a>"; ?></span>
      <span style="margin-left:70%"><?= "<a href='profile.php'>".htmlspecialchars($current_user)."</a>"; ?></span> |
      <span><?= "<a href='login.php?action=logout'>Log out</a>"; ?></span><hr><br>
    <?php } ?>
