<?php
header("Access-Control-Allow-Origin: *");
function select($conn, $strSQL){
  $query = mysqli_query($conn, $strSQL);
  if($query){
    $return = '';
    while ($row = mysqli_fetch_array($query)) {
      $buf = '';
      foreach ($row as $key => $value) {
          if(!is_int($key)){
            $buf[$key] = $value;
          }
      }
      $return[] = $buf;
    }

    if($return != ''){
      return $return;
    }else{
      return false;
    }
  }else{
    return false;
  }
}

function insert($conn, $strSQL, $isID){
  $query = mysqli_query($conn, $strSQL);
  if($query){
    if($isID){
      return mysqli_insert_id($conn);
    }else{
      return true;
    }
  }else{
    return false;
  }
}

function delete($conn, $strSQL){
  $query = mysqli_query($conn, $strSQL);
  if($query){
    return true;
  }else{
    return false;
  }
}

function update($conn, $strSQL){
  $query = mysqli_query($conn, $strSQL);
  if($query){
    return true;
  }else{
    return false;
  }
}

function disconnect($conn){
  mysqli_close($conn);
}

function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>
