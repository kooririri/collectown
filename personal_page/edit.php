<?php
session_start();
require_once '../config.php';
require_once '../function.php';

$mem_id = $_SESSION['mem_id'];
$ra_id = $_POST['ra_id'];
$price = $_POST['edit_price'];


$link=mysqli_connect(HOST,DB_USER,DB_PASS,DB_NAME);
if(!$link){
	return false;
}
mysqli_set_charset($link , 'utf8');
/*
$sql1 = "SELECT MAX(lineorder)+1 FROM ra_application
		WHERE ra_id = '".$ra_id."'";

$result1 = mysqli_query($link,$sql1);
while($line = mysqli_fetch_assoc($result1)){
	$cnt[] = $line;
}
//var_dump($cnt);
foreach($cnt as $c){
	$lineorder = $c['MAX(lineorder)+1'];
}
*/
$sqla="SELECT * FROM ra_application WHERE ra_id = '$ra_id' AND cancel_flag = 0 ORDER BY bid_price ASC limit 1";
$querya=mysqli_query($link,$sqla);

$resa=mysqli_fetch_assoc($querya);
$id=$resa['ra_id'];
$mem=$resa['mem_id'];
$line=$resa['lineorder'];
$sqlb="UPDATE ra_application SET cancel_flag = 2
		WHERE ra_id = '$id' AND mem_id = '$mem' AND lineorder = '$line'";
mysqli_query($link,$sqlb);





$sql2 = "UPDATE ra_application SET bid_price = '".$price."',cancel_flag = 0
		WHERE ra_id = '".$ra_id."'
		AND mem_id = '".$mem_id."' ";


$result2 = mysqli_query($link,$sql2);
if(!$result2){
?>
<a href="index.php" target="_parent">SQLが実行できませんでした</a>
<?php
}
else{
	?>
<a href="index.php" target="_parent">引き受け成功</a>
	<?php
}
// header("refresh:1;url= index.php");

//$sqlが実行されなかった場合
// if(!$result2){
// 	//エラー処理
// 	$err = 'SQLが実行できませんでした';
// 	echo $err;
// 	// header("refresh:2;url= index.php");
// 	// print('エラー。2秒後ホームページに戻ります。');
// 	exit;
// }
mysqli_close($link);

?>
