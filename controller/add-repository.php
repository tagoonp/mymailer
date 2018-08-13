<?php
include "config.class.php";
include "database.fnc.php";

if(!isset($_POST['email'])){
  disconnect($conn);
  die();
}

if(!isset($_POST['password'])){
  disconnect($conn);
  die();
}

if(!isset($_POST['mailer_name'])){
  disconnect($conn);
  die();
}

if(!isset($_POST['uid'])){
  disconnect($conn);
  die();
}


$password = mysqli_real_escape_string($conn, base64_encode($_POST['password']));
$uid = mysqli_real_escape_string($conn, $_POST['uid']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$api_key = mysqli_real_escape_string($conn, base64_encode($_POST['email'].$sys_datetime.$ip));
$mailer_name = mysqli_real_escape_string($conn, $_POST['mailer_name']);

$strSQL = "INSERT INTO email_repo (ea_uid, ea_email, ea_keyemail, ea_password, ea_mailername, ea_regdatetime)
           VALUES ('$uid', '$email', '$api_key', '$password', '$mailer_name', '$sys_datetime')
          ";
$result = insert($conn, $strSQL, false);
if($result){
  echo "Y";
  disconnect($conn);
  die();
}else{
  echo "N";
  disconnect($conn);
  die();
}
?>
