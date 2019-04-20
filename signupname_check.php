<?php
header("Content-Type:application/json;charset=utf-8");
require_once './config.php';
require_once './function.php';
if(isset($_POST['signupmail'])){
  $mail=$_POST['signupmail'];
  $sql="SELECT * FROM member WHERE mem_mail = '".$mail."'";
  $link=mysqli_connect(HOST,DB_USER,DB_PASS,DB_NAME);
  if(!$link){
    return false;
  }
  mysqli_set_charset($link , 'utf8');
  $query=mysqli_query($link,$sql);
  if(is_array(mysqli_fetch_array($query))){
    $result='{"success":false,"msg":"このメールアドレスもう登録されました"}';
  }
  else{
    $result='{"success":true,"msg":"使えます"}';
  }
  echo $result;
}

?>
