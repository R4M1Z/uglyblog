<?php
$conn=mysqli_connect('localhost:3306','root','','data');
if(!$conn){
  echo "ERROR: ".mysqli_connect_error($conn);
}
 ?>
