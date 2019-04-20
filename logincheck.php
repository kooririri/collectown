<?php
header("Content-Type:application/json;charset=utf-8");
require_once './config.php';
require_once './function.php';
if(isset($_POST['loginmail'])){
  $mail=$_POST['loginmail'];
  $pass=$_POST['loginpass'];
  $sql="SELECT * FROM member WHERE mem_mail = '".$mail."' AND mem_pass ='".$pass."'" ;
  $link=mysqli_connect(HOST,DB_USER,DB_PASS,DB_NAME);
  if(!$link){
    return false;
  }
  mysqli_set_charset($link , 'utf8');
  $query=mysqli_query($link,$sql);
  if(is_array(mysqli_fetch_array($query))){
    $result='{"success":true,"msg":"ok","check":true}';
  }
  else{
    $result='{"success":false,"msg":"メールアドレスとパスワードを確認してください","check":false}';
  }
  echo $result;
}
