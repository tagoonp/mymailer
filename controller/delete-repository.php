<?php
include "config.class.php";
include "database.fnc.php";

if(!isset($_POST['id'])){
  disconnect($conn);
  die();
}

$id = mysqli_real_escape_string($conn, $_POST['id']);

$strSQL = "UPDATE email_repo SET ea_deletestatus = '1' WHERE ea_id = '$id'";
$result = update($conn, $strSQL);
if($result){
  echo "Y";
}

disconnect($conn);
die();
?>
