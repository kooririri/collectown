<?php
/*
if(session_start()==true){
	$_SESSION['ra_id'] = $ra_id;
	$_SESSION['mem_id'] = $mem_id;
	$_SESSION['bid_price'] = $bid_price;
	$_SESSION['lineorder'] = $lineorder;
}
*/
session_start();
require_once './function.php';
require_once './config.php';
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

$sql1="SELECT * FROM (ra_content INNER JOIN ra_demand on ra_content.ra_id = ra_demand.ra_id)INNER JOIN member ON ra_demand.mem_id = member.mem_id WHERE ra_content.ra_id =".$ra_id ;
$query1 = mysqli_query($link,$sql1);
$res1=mysqli_fetch_assoc($query1);
// var_dump($res1);

$sql2="SELECT *,MIN(bid_price) FROM ra_content INNER JOIN ra_application on ra_content.ra_id = ra_application.ra_id GROUP BY ra_application.ra_id HAVING ra_content.ra_id =".$ra_id;
$query2 = mysqli_query($link,$sql2);
$res2=mysqli_fetch_assoc($query2);
// var_dump($res2);

$sql3 = "SELECT COUNT(*), MIN(bid_price) FROM ra_application WHERE ra_id = '".$ra_id."' AND cancel_flag = 0 ";
$query3 = mysqli_query($link,$sql3);
$res3=mysqli_fetch_assoc($query3);
// var_dump($res3);
require_once './tmp/reverse_auction.php';
?>
