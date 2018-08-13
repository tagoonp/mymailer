<?php
include "config.class.php";
include "database.fnc.php";

if(!isset($_POST['uid'])){
  disconnect($conn);
  die();
}

$uid = mysqli_real_escape_string($conn, $_POST['uid']);

$strSQL = "SELECT * FROM email_repo WHERE 1";
if($uid != ''){
  $strSQL = "SELECT * FROM email_repo WHERE ea_uid = '$uid' AND ea_deletestatus = '0'";
}

$result = select($conn, $strSQL);
if($result){
  echo json_encode($result);
}

// echo $strSQL;

disconnect($conn);
die();
?>
