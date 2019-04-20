<?php
// echo $_GET['ra_id'];
session_start();
require_once '../config.php';
require_once '../function.php';
//var_dump($_SESSION);

$mem_id = $_SESSION['mem_id'];
$ra_id = $_GET['keyword'];
//var_dump($ra_id);
$link = mysqli_connect(HOST,DB_USER,DB_PASS,DB_NAME);
if(!$link){
  return false;
}
mysqli_set_charset($link , 'utf8');

//代行引き受け応募人数と引き受け最安値を得る
$sql1 = "SELECT COUNT(*), MIN(bid_price)
		FROM ra_application
		INNER JOIN ra_content
		ON ra_application.ra_id = ra_content.ra_id
		WHERE ra_application.ra_id = '".$ra_id."'
		AND ra_application.cancel_flag = 0";

$result = mysqli_query($link, $sql1);
while($res = mysqli_fetch_assoc($result)){
	$rows[] = $res;
}


//////////////////////////////////////////////////////////////////////////
$sql2 = "SELECT * FROM ra_content
		INNER JOIN ra_demand
		ON ra_content.ra_id = ra_demand.ra_id
		INNER JOIN genre
		ON genre.gen_id = ra_content.gen_id
		INNER JOIN images
		ON images.img_id = ra_content.img_id
		WHERE ra_demand.ra_id = '".$ra_id."'";


$rows2 = array();
$result2 = mysqli_query($link, $sql2);

while($res2 = mysqli_fetch_assoc($result2)){
	$rows2[] = $res2;
}


/////////////////////////////////////////////////////////////////
/*
*会員情報機能が完成し、member_infoにニックネームなどが登録できるようになったら使用する
*
*mem_idをもとにユーザの名前の情報を得るSQL
*
*/

/*
	$sql3 = "SELECT nick FROM member
			INNER JOIN member_info
			ON member.mem_id = member_info.mem_id
			WHERE member_info.mem_id = '".$mem_id."'";
	$rows3 = array();
	$result3 = mysqli_query($link, $sql3);
	while($res3 = mysqli_fetch_assoc($result3)){
		$rows3[] = $res3;
	}
*/

/////////////////////////////////////////////////////////////////
$sql4 = "SELECT * FROM ra_application
		WHERE ra_id = '".$ra_id."'
		AND mem_id = '".$mem_id."'
		ORDER BY bid_price DESC limit 1";

	$rows4 = array();
	$result4 = mysqli_query($link, $sql4);
  $row4= mysqli_fetch_assoc($result4);

//var_dump($rows4);




//データベースを閉じる
mysqli_close($link);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>collectown</title>
<link rel="stylesheet" href="css/application_con.css" />
<link rel="stylesheet" href="css/amazeui.min.css" />
<link rel="stylesheet" href="css/admin.css" />
<!--   Core JS Files   -->
<style>
#green{
	color:green;
  font-size: 15px;
  font-weight: bold;
}
#red{
	color:red;
  font-size: 15px;
  font-weight: bold;
}
#grey{
  font-size: 15px;
  font-weight: bold;
}
#bid2{
  width:300px;
}
input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
      -webkit-appearance: none;
  }
  input[type="number"]{
      -moz-appearance: textfield;
  border: solid 0.5px #000;
  }
</style>
<script src="js/jquery-3.1.0.min.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/material.min.js" type="text/javascript"></script>

<!--  Charts Plugin -->
<script src="js/chartist.min.js"></script>

<script src="js/material-dashboard.js"></script>
<script type="text/javascript" src="myplugs/js/plugs.js"></script>
<!-- <link rel="stylesheet" type="text/css" href="./css/side_nav2.css">
<link rel="stylesheet" type="text/css" href="./css/acting_demand2.css">
<link rel="stylesheet" type="text/css" href="./css/stylesheet.css"> -->

<!-- バリデーションチェック -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/validationEngine.jquery.min.css" type="text/css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/jquery-1.8.2.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/languages/jquery.validationEngine-ja.min.js" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/jquery.validationEngine.min.js" type="text/javascript" charset="utf-8"></script>

<!-- 入力フォームチェック -->
<script type="text/javascript" src="./js/jquery.js"></script>
<script type="text/javascript" src="./js/jquery.min.js"></script>
<script type="text/javascript" src="./js/bootstrap-fileinput.js"></script>
<script src="js/prefixfree.min.js"></script>
<script type="text/javascript" src='js/jquery.js'></script>
<script type="text/javascript" src="js/index.js"></script>


</head>
<body>
<div class="admin-content-body">
	<div class="am-cf am-padding am-padding-bottom-0">
    <div id="main2">
	<?php foreach($rows as $app){ ?><!--  -->
	<?php foreach($rows2 as $app2){ ?>
	<?php 	$dead_line=strtotime($app2['start_time'])+$app2['ra_time']*24*60*60;
			$rest = date("Y-m-d H:i:s",$dead_line); ?>

		<div class="ap_name">
			<p>代行依頼品</p>
			<?php echo $app2['ra_name']; ?>
		</div><!-- ap_nameここまで -->

		<div class="app_wrap">
			<div id="preview">
				<img id="imghead" border="0" src="<?php echo "../".$app2['img_add']; ?>" onClick="$('#previewImg').click();">
			</div>
			<input type="file" name="file" onChange="previewImage(this)" style="display: none;" id="previewImg">
			<label class="msg" id="img_msg"></label>
			<div class="intr">
				<p class="sub_ttl">代行依頼概要</p>
				<?php  echo $app2['introduction']; ?>
			</div>
		</div>

		<div class="app_con2">
			<!--<div id="cont"> -->
					<p>ジャンル　　　　　　<span><?php echo $app2['gen_name']; ?></span></p>
					<p>代行募集価格　　　　<span><?php echo $app2['ra_price']; ?></span></p>
					<p>募集開始日　　　　　<span><?php echo $app2['start_time']; ?></span></p>
					<p>募集終了日　　　　　<span><?php echo $rest;//echo $app2['deadline']; ?></span></p>
					<p>現在の価格　　　　　<span><?php $p = $app['MIN(bid_price)']; echo number_format($app['MIN(bid_price)']); ?>円</span></p>
					<p>引き受け希望人数　　<span><?php echo $app['COUNT(*)']; ?>人</span></p>
		</div><!-- app_con2ここまで -->


		<div class="app_con3">
			<p><?php //echo $rows3['nick']; ?></p><!-- ユーザ名を表示 -->
			<p>自分代行引き受け状態<?php switch($row4['cancel_flag']){
        case 0:
          $flg="引き受け中";
          echo '<span id="green">'.$flg.'</span>';
          break;
        case 1:
          $flg="本人キャンセル";
          echo '<span id="grey">'.$flg.'</span>';
          break;
        case 2:
          $flg="他人入札よりキャンセル";
          echo '<span id="red">'.$flg.'</span>';
          break;
        case 3:
          $flg="他人入札よりキャンセル";
          echo '<span id="red">'.$flg.'</span>';
          break;
      } ?></p>
			<p>自分引き受け価格　　<span><?php echo $row4['bid_price']; ?>円</span></p>
		</div>
		<?php  } };	?><!-- foreach ここまで -->

		<div class="edit">
			<form action="edit.php" method="post">
				<input type="hidden"  name="ra_id" value="<?php echo $ra_id; ?>"><!-- $ra_idの値をクエリ情報としてedit.phpへ渡す -->
				<span>再引き受け希望価格</span><br/>
				<input id="bid2" type="number" name="edit_price" max="<?php echo $p; ?>" min="0" required class="validate[required,custom[number],custom[integer]]" placeholder="再引き受け希望価格を入力してください"><br />
				<input type="submit" value="送信">
			</form>
		</div><!--editここまで -->

		<div class="delete">
			<form action="delete.php" method="post">
				<input type="hidden" name="ra_id" value="<?php echo $ra_id; ?>" ><!-- $ra_idの値をクエリ情報としてdelete.phpへ渡す -->
				<input type="submit" value="取消">
			</form>
		</div><!--deleteここまで -->
		<!--
		<div class="delete">
		<button id="cancel">取消</button>
		</div>
		-->
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap-fileinput.js"></script>
	</div><!-- admin-content-bodyここまで -->

	</div><!-- main2ここまで -->
</form>
</body>
</html>
