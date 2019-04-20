<?php
session_start();
require_once '../config.php';
require_once '../function.php';
//var_dump($_SESSION);

$mem_id = $_SESSION['mem_id'];

//変数の初期化


$link = mysqli_connect(HOST,DB_USER,DB_PASS,DB_NAME);
if(!$link){
  return false;
}
mysqli_set_charset($link , 'utf8');

/*******************************************************************/
//代行引き受け応募があるかどうか検索する
$sql = "SELECT COUNT(*) FROM ra_application
		WHERE mem_id = '".$mem_id."'
		AND cancel_flag = 0";
$c = mysqli_query($link, $sql);
foreach($c as $n){
	$re = $n['COUNT(*)'];
}
if(!($re == 0 || $re == '0')){
  $sql1 = "SELECT DISTINCT * FROM ra_application
      INNER JOIN ra_content
      ON ra_application.mem_id = '".$mem_id."'
      INNER JOIN genre
      ON genre.gen_id = ra_content.gen_id
      AND ra_application.ra_id = ra_content.ra_id
      INNER JOIN images
      ON images.img_id = ra_content.img_id
      AND ra_application.cancel_flag = 0";

  $result = mysqli_query($link, $sql1);

  while($res = mysqli_fetch_assoc($result)){
    $rows[] = $res;
  }
  // var_dump($rows);
}else {

  	// $rows[$i]['ra_name'] = '';
  	// $rows[$i]['start_time'] = '';
  	// $rows[$i]['gen_name'] = '';
  	// $rows[$i]['ra_price'] = '';
  	// $rows[$i]['bid_price'] = '';
  	// $rows[$i]['img_add'] = '../img/no_img2.png';
  	$msg= '代行引き受け応募実績がありません';

}



// if($re == 0 || $re == '0'){
// 	$rows[$i]['ra_name'] = '';
// 	$rows[$i]['start_time'] = '';
// 	$rows[$i]['gen_name'] = '';
// 	$rows[$i]['ra_price'] = '';
// 	$rows[$i]['bid_price'] = '';
// 	$rows[$i]['img_add'] = '../img/no_img2.png';
// 	echo '代行引き受け応募実績がありません';
// }else {
//
// 	$sql1 = "SELECT DISTINCT * FROM ra_application
// 			INNER JOIN ra_content
// 			ON ra_application.mem_id = '".$mem_id."'
// 			INNER JOIN genre
// 			ON genre.gen_id = ra_content.gen_id
// 			AND ra_application.ra_id = ra_content.ra_id
// 			INNER JOIN images
// 			ON images.img_id = ra_content.img_id
// 			AND ra_application.cancel_flag = 0";
//
// 	$result = mysqli_query($link, $sql1);
//
// 	while($res = mysqli_fetch_assoc($result)){
// 		$rows[] = $res;
// 	}
// }
//echo $re;


//データベースを閉じる
mysqli_close($link);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>collectown</title>
<link rel="stylesheet" href="css/application.css" />
<link rel="stylesheet" href="css/amazeui.min.css" />
<link rel="stylesheet" href="css/admin.css" />

<!--   Core JS Files   -->
<script src="js/jquery-3.1.0.min.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/material.min.js" type="text/javascript"></script>

<!--  Charts Plugin -->
<script src="js/chartist.min.js"></script>


<script src="js/material-dashboard.js"></script>
<script type="text/javascript" src="myplugs/js/plugs.js"></script>

</head>
<body>
	<div class="ap_wrap">
	<div class="admin-content-body">
		<div class="am-cf am-padding am-padding-bottom-0">
			<div class="am-fl am-cf">
				<strong class="am-text-primary am-text-lg">代行引き受け一覧</strong>
			</div>
		</div><!-- am-cf am-padding am-padding-bottom-0"ここまで -->
		<hr>
			<?php
      if(!($re==0 ||$re=='0')){
        for($i=0;$i<count($rows); $i++){
  				if($rows[$i]['ra_id']){
  					$id = $rows[$i]['ra_id'];
  				}
        }
      ?>

		<div class="ap_con">
			<ul class="am-avg-sm-2 am-avg-md-4 am-avg-lg-6 am-margin gallery-list">

				<?php //var_dump($rows[$i]['ra_id']);// var_dump($rows[$i]['ra_id']); ?>
				<li>
					<a href="application_con.php?keyword=<?=urldecode($id)?>">
					<div class="ap_pic">
						<img class="am-img-thumbnail am-img-bdrs" src="<?php echo "../".$rows[$i]['img_add']; ?>">
					</div><!-- ap_picここまで -->

					<div class="ap_name">
						<p class="ap_ttl"><?php echo $rows[$i]['ra_name']; ?></p>
					</div><!-- ap_nameここまで -->

					<div class="ap_time">
						<p class="ap_btm">代行引き受け登録日<br>
						<span><?php  echo $rows[$i]['start_time']; ?></span></p>
					</div><!-- ap_timeここまで -->

					<div class="ap_gen">
						<p class="ap_btm">ジャンル<br>
						<span><?php  echo $rows[$i]['gen_name']; ?></span></p>
					</div><!-- ap_genここまで -->

					<div class="ap_price">
						<p class="ap_btm">代行引き受け希望価格<br>
						<span><?php echo num($rows[$i]['ra_price']); ?>円</span></p>
					</div><!-- ap_priceここまで -->

					<div class="bid_price">
						<p class="ap_btm">代行引き受け予定価格<br>
						<span><?php echo num($rows[$i]['bid_price']); ?>円</span>
						</p>
					</div><!-- bid_priceここまで -->

					</a><!-- リンク -->
				</li>
				<?php }
        else{  ?>
          <p class="msg"><?php echo $msg; ?></p>
          <?php
        }
          ?>
			</ul>
		</div><!-- ap_conここまで -->
	</div><!-- admin-content-bodyここまで -->
	</div><!-- ap_wrapここまで -->
</body>
</html>
