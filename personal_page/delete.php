<?php
session_start();
require_once '../config.php';
require_once '../function.php';

$mem_id = $_SESSION['mem_id'];
$ra_id = $_POST['ra_id'];


$link=mysqli_connect(HOST,DB_USER,DB_PASS,DB_NAME);
if(!$link){
	return false;
}
mysqli_set_charset($link , 'utf8');

//del_flgを0から1にデータベースを変更するSQL文
// $sql = "UPDATE ra_application SET cancel_flag = 1 WHERE ra_id = '".$ra_id."'
// 		AND mem_id = '".$mem_id."'";
//
// $result = mysqli_query($link, $sql);

$sql1 = "SELECT * FROM ra_application WHERE ra_id = '$ra_id' ORDER BY bid_price ASC";
$query1=mysqli_query($link,$sql1);
$res=array();
while($a=mysqli_fetch_assoc($query1)){
  $res[]=$a;
}
if($res[0]['mem_id']==$mem_id){
	$next=$res[1]['lineorder'];
	$sql2 = "UPDATE ra_application SET cancel_flag = 1 WHERE ra_id = '".$ra_id."'
			AND mem_id = '".$mem_id."'";
	mysqli_query($link, $sql2);
	$sql3= "UPDATE ra_application SET cancel_flag = 0 WHERE lineorder = '$next'";
	mysqli_query($link,$sql3);
}
else{
	$sql4 = "UPDATE ra_application SET cancel_flag = 1 WHERE ra_id = '".$ra_id."'
			AND mem_id = '".$mem_id."'";
	mysqli_query($link, $sql4);
}
?>
<a href="index.php" target="_parent">キャンセルされました。</a>
<?php
// header("refresh:1;url= index.php");
//$sqlが実行されなかった場合
// if(!$result){
// 	//エラー処理
// 	$err = 'SQLが実行できませんでした';
// 	echo $err;
// 	// header("refresh:2;url= index.php");
// 	// print('エラー。2秒後ホームページに戻ります。');
// 	exit;
// }
mysqli_close($link);
//header('location:./index.php');

?>
