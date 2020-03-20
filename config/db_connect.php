<?php
# Edit these variables:
$servername="localhost";
$username="root";
$password="";
$dbname="data";

$conn=mysqli_connect($servername,$username,$password,$dbname);
if(!$conn){
  echo "ERROR: ".mysqli_connect_error($conn);
}
 ?>
