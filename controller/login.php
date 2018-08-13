<?php
include "config.class.php";
include "database.fnc.php";

if(!isset($_POST['username'])){
  disconnect($conn);
  die();
}

if(!isset($_POST['password'])){
  disconnect($conn);
  die();
}

$email = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, base64_encode($_POST['password']));


$strSQL = "SELECT * FROM useraccount WHERE (email = '$email' AND password = '$password') AND use_status = '1' AND active_status = '1' AND delete_status = '0'";
$result = select($conn, $strSQL);
if($result){
  $strSQL = "INSERT INTO access_log (access_datetime, access_ip, access_uid)
             VALUES ('$sys_datetime', '$ip', '".$result[0]['uid']."')
            ";
            insert($conn, $strSQL, false);

  echo json_encode($result);
}

disconnect($conn);
die();
?>
