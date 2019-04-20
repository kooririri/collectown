<?php
header("Content-Type: text/html;charset=utf-8");
require_once './config.php';
if(!isset($_POST['signup'])){
  header('location:./index.php');
  exit;
}
if(isset($_POST['signup'])&&!empty($_POST['signup'])){
  $mail=$_POST['signupmail'];
  $pass=$_POST['signuppass'];
  $sql="INSERT INTO member(mem_mail,mem_pass) VALUES ('".$mail."','".$pass."')";
  $link=mysqli_connect(HOST,DB_USER,DB_PASS,DB_NAME);
  if(!$link){
    return false;
  }
  mysqli_set_charset($link , 'utf8');
  $query=mysqli_query($link,$sql);
  if(!$query){
    mysqli_close($link);
    $result="エラー";
    return false;
  }
  else{
    $result="ご登録ありがとうございます";
    mysqli_close($link);
  }
  echo $result;
  header("refresh:2;url=./index.php");
  
}



//header("Content-Type: text/html;charset=utf-8");
// header("Content-Type:application/json;charset=utf-8");
// require_once './config.php';
// require_once './function.php';
// $mail=$_POST['signupmail'];
// $pass=$_POST['signuppass'];
// $sql="INSERT INTO member(mem_mail,mem_pass) VALUES ('".$mail."','".$pass."')";
// $link=mysqli_connect(HOST,DB_USER,DB_PASS,DB_NAME);
// if(!$link){
//   return false;
// }
// mysqli_set_charset($link , 'utf8');
// $query=mysqli_query($link,$sql);
// if(!$query){
//   mysqli_close($link);
//   $result='{"success":false,"msg":"エラー"}';
//   return false;
// }
// else{
//   $result='{"success":true,"msg":"ご登録ありがとうございます"}';
// }
// if(execute($sql,HOST,DB_USER,DB_PASS,DB_NAME)){
//   $msg="エラー";
// }
// else{
//   $msg="会員登録完了しました。ありがとうございます。";
// }
// echo $msg;

?>
