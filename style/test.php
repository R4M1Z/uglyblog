<?php
$st="rmiz1325df";
$ste="ramizə2";
if(!preg_match('/[^a-z0-9]/', $st)){
  echo "It is valid";
}
else if(preg_match('/[^a-z0-9]/', $st)){
  echo "It is invalid";
}

 ?>
