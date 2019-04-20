<?php
//「入札参加」を押した場合のページ
require_once './function.php';
require_once './config.php';

$err_msg = '';
if(!empty($_POST) && isset($_POST['submit'])){
	/*
	$ra_id = $_SESSION['ra_id'];
	$mem_id = $_SESSION['mem_id'];
	$bid_price = $_SESSION['bid_price'];
	$lineorder = $_SESSION['lineorder'];
	*/
	$line_order = h($_POST['line_order']);


}
//データベース接続
$link = mysqli_connect(HOST,DB_USER,DB_PASS,DB_NAME);

//接続失敗
if(!$link){
	//エラー処理
	$err_msg = 'データベース接続に失敗しました';
	echo $err_msg;
	return false;
}

//文字コード設定
mysqli_set_charset($link,'utf8');
$sql1 = "select * from ra_content where ra_id = '".$ra_id."' ";
$result1 = mysqli_query($link, $sql1);
if(!$result1){
	//エラー処理
	$err_msg = '失敗しました';
	echo $err_msg;
	exit;
}
while($rows2 = mysqli_fetch_assoc($result1)){
	$rows3[] = $rows2;
}

foreach($row3 as $deta){
	$ra_id = $row3['ra_id'];
	$mem_id = $row3['mem_id'];
	$bid_price = $row3['bid_price'];
}
//代行引き受け
$sql2 = "INSERT INTO `ra_application`(`ra_id`, `mem_id`, `bid_price`, `lineorder`, `cancel_flag`)
 VALUES ('".$ra_id."', '".$men_id."', '".$bid_price."', '".$line_order."', 0)";



$result = mysqli_query($link, $sql2);
if(!$result){
	//エラー処理
	$err_msg = 'データ登録に失敗しました';
	echo $err_msg;
	exit;
}

mysqli_close($link);
$err_msg = '参加完了';

header(location:./home.php);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>COLLECTOWN</title>
	<link rel="stylesheet" type="text/css" href="./css/common.css">
	<link rel="stylesheet" type="text/css" href="./css/header2.css">
	<link rel="stylesheet" type="text/css" href="./css/side_nav2.css">
	<link rel="stylesheet" type="text/css" href="./css/entry.css">
</script>
</head>
<body>
	<!-- <header>
		<div class="container">
			<div class="header-left">
				<img class="logo" src="./img/logo.png">
			</div>
			<div class="header-right">
				<div class="login" id="login-show">ログイン</div>
			</div>
		</div>
	</header> -->
<header>
<?php require_once './tmp/header.php';?>
</header>
<div class="wrapper">
	<?php  require_once './tmp/side_nav2.php'; ?><!-- サイドナビの呼び出し -->
	<div class="main_entry">
	<p><?php echo $err_msg;?></p>
	</div><!-- main_entryここまで -->
</div><!-- wrapperここまで -->
</body>
<?php require_once './tmp/footer.php'; ?>
</html>
B199
