<?php
session_start();
require_once './config.php';
require_once './function.php';
// var_dump($_SESSION);
header("content-type:text/html;charset=utf-8");

$ra_id=$_GET['ra_id'];
$link=mysqli_connect(HOST,DB_USER,DB_PASS,DB_NAME);
if(!$link){
  return false;
}
mysqli_set_charset($link , 'utf8');
$sql="SELECT * FROM ra_content INNER JOIN images on ra_content.img_id = images.img_id WHERE ra_content.ra_id =".$ra_id ;
$query = mysqli_query($link,$sql);
$res=mysqli_fetch_assoc($query);
// var_dump($res);

require_once './tmp/acting_content.php';
?>
