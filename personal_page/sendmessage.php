<?php
require_once '../config.php';
require_once '../function.php';
$user_id=$_POST['user_id'];
$cont=$_POST['msg'];
$friend_id=$_POST['friend_id'];

$link=mysqli_connect(HOST,DB_USER,DB_PASS,DB_NAME);
if(!$link){
  return false;
}
mysqli_set_charset($link , 'utf8');
$sql="INSERT INTO dm(user_id,friend_id,sender_id,receiver_id,content,flag)VALUES('".$user_id."','".$friend_id."','".$user_id."','".$friend_id."','".$cont."',1)";
$query=mysqli_query($link,$sql);
// $sql_get="SELECT * FROM "
$insertId = mysqli_insert_id($link);
if ($insertId) {
    $returnArr = ['flag' => 1,'info' => $insertId,''];
} else {
    $returnArr = ['flag' => 0,'info' => '',];
}
echo json_encode($returnArr);
mysqli_close($link);
exit();
?>
