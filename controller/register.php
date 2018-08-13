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

if(!isset($_POST['fullname'])){
  disconnect($conn);
  die();
}

if(!isset($_POST['phone'])){
  disconnect($conn);
  die();
}

$uid = mysqli_real_escape_string($conn, base64_encode($_POST['email'].$_POST['fullname'].$sys_datetime));
$password = mysqli_real_escape_string($conn, base64_encode($_POST['password']));
$fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);

$strSQL = "SELECT * FROM useraccount WHERE email = '$email' AND use_status = '1' AND active_status = '1' AND delete_status = '0'";
$result = select($conn, $strSQL);
if($result){
  echo "D1";
  disconnect($conn);
  die();
}

$strSQL = "SELECT * FROM useraccount WHERE phone = '$phone' AND use_status = '1' AND active_status = '1' AND delete_status = '0'";
$result = select($conn, $strSQL);
if($result){
  echo "D2";
  disconnect($conn);
  die();
}

$strSQL = "INSERT INTO useraccount (uid, email, password, fullname, phone, regdatetime)
           VALUES ('$uid', '$email', '$password', '$fullname', '$phone', '$sys_datetime')
          ";
$result = insert($conn, $strSQL, false);
if($result){

  $strSQL = "INSERT INTO userinfo_completeness (c_uid, c_udatetime)
             VALUES ('$uid', '$sys_datetime')
            ";
            insert($conn, $strSQL, false);

  echo "Y";
  disconnect($conn);
  die();
}else{
  echo "N";
  disconnect($conn);
  die();
}
?>
