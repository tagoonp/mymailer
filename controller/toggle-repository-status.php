<?php
include "config.class.php";
include "database.fnc.php";

if(!isset($_POST['id'])){
  disconnect($conn);
  die();
}

if(!isset($_POST['next_stage'])){
  disconnect($conn);
  die();
}

$id = mysqli_real_escape_string($conn, $_POST['id']);
$next_stage = mysqli_real_escape_string($conn, $_POST['next_stage']);

$strSQL = "UPDATE email_repo SET ea_status = '$next_stage' WHERE ea_id = '$id'";
$result = update($conn, $strSQL);
if($result){
  echo "Y";
}

disconnect($conn);
die();
?>
