<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>collectown</title>
<link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
<link rel="stylesheet" type="text/css" href="./css/side_nav2.css">
<link href="./css/home.css" rel="stylesheet" type="text/css"/>

<script type="text/javascript" src="./js/jquery.js"></script>
<script type="text/javascript" src="./js/jquery.min.js"></script>
<script type="text/javascript" src="./js/current.js"></script>
<script type="text/javascript">
var mem_id=<?php echo $_SESSION['mem_id'] ?>;
$(function(){
  var setting = {
    url:'./application_status.php',
    data:{
			'mem_id':mem_id,
    },
    type:'post',
    dataType:'json',
    success:function(res){
      var message_str = '';
      message_str += '<div>' + 'あなたは投稿されたID' + res.ra_id + 'の要件が受取されました。' + '</div>';
      $('#state').append(message_str);
      // $.ajax(setting);
      window.setTimeout(function(){$.ajax(setting)},1000);
    }
  };
  $.ajax(setting);
});
// $(document).ready(function () {
// 		(function longPolling() {
// 				// alert(Date.parse(new Date())/1000);
// 				var id=$('#admin').val();
// 				$.ajax({
// 						url: "longPolling.php",
// 						data: {"timed": Date.parse(new Date())/1000,
// 										"id":id,
// 					},
// 						dataType: "text",
// 						timeout: 500000,//5秒超时，可自定义设置
// 						error: function (XMLHttpRequest, textStatus, errorThrown) {
// 								$("#state").append("[state: " + textStatus + ", error: " + errorThrown + " ]<br/>");
// 								if (textStatus == "timeout") { // 请求超时
// 										longPolling(); // 递归调用
// 								} else { // 其他错误，如网络错误等
// 										longPolling();
// 								}
// 						},
// 						success: function (data, textStatus) {
// 								$("#state").append("[state: " + textStatus + ", data: { " + data + "} ]<br/>");
//
// 								if (textStatus == "success") { // 请求成功
// 										longPolling();
// 								}
// 						}
// 				});
//
// 		})();
// });
// $(document).ready(function () {
// 		(function longPolling() {
// 				// alert(Date.parse(new Date())/1000);
// 				var id=$('#admin').val();
// 				$.ajax({
// 						type:"POST",
// 						dataType: "json",
// 						url: "./a.php",
// 						data: {time:"80",id:id,},
// 						timeout: 5000,//5秒超时，可自定义设置
// 						error: function (XMLHttpRequest, textStatus, errorThrown) {
// 								if (textStatus == "timeout") { // 请求超时
// 									longPolling(); // 递归调用
// 								} else { // 其他错误，如网络错误等
// 										longPolling();
// 								}
// 						},
// 						success: function (data) {
// 							if (textStatus == "timeout") {
// 								$('#state').html(date.name);
// 								longPolling();
// 							}
// 						}
// 				});
//
// 		})();
// });
</script>


</head>
<body>
	<header>
		<?php require_once './tmp/header.php'; ?>
	</header>
	<div class="wrapper">

		<?php require_once './tmp/side_nav.php'; ?>





		<div id="maincont">
			<div id="index">
				<a id="state" href="./personal_page/index.php"></a>
				<dl class="cation-list">
						<dt>ジャンル</dt>
						<dd>
							<a href="#" rel="" name="gen_id" class="all on">全部</a>
							<?php
							for($i=0;$i<count($genre_arr);$i++){?>
								<a href="#" rel="<?php echo $genre_arr[$i]['gen_id']; ?>" name="gen_id" class="default"><?php echo $genre_arr[$i]['gen_name']; ?></a>
							<?php
							} ?>
							<!-- <a href="#" rel="gen_id=2" name="gen_id" class="default">フィギュア</a>
							<a href="#" rel="gen_id=3" name="gen_id" class="default">生活用品</a>
							<a href="#" rel="gen_id=7" name="gen_id" class="default">スポーツ</a> -->
						</dd>
				</dl>
				<dl class="cation-list">
						<dt>値　段</dt>
						<dd>
								<a href="#" rel="" name="price" class="all on">全部</a>
								<a href="#" rel="1" name="price" class="default">~1000</a>
								<a href="#" rel="2" name="price" class="default">1001~5000</a>
								<a href="#" rel="3" name="price" class="default">5001~10000</a>
								<a href="#" rel="4" name="price" class="default">10001~50000</a>
								<a href="#" rel="5" name="price" class="default">50001~</a>
						</dd>
				</dl>
				<dl class="cation-list">
						<dt>期　限</dt>
						<dd>
								<a href="#" rel="" name="order" class="all on">全部</a>
								<a href="#" rel="ASC" name="order" class="default">時間早い順</a>
								<a href="#" rel="DESC" name="order" class="default">時間遅い順</a>
						</dd>
				</dl>

<script type="text/javascript">
		$(function(){
				new SelectTag({
						child : ".default", //所有默认
						over : 'on', //当前选中
						all : ".all" // 默认全部
				});
		})
</script>
			</div>
			<div class="subcont">

				<?php
				for($i=0;$i<count($data);$i++){
				?>
				<div class="contents">
					<div class="img_wrap">
					<p><a href="./reverse_auction.php?ra_id=<?php echo $data[$i]['ra_id']; ?>"><img class="ra_pic" src="<?php echo $data[$i]['img_add']; ?>"></a></p>
					</div>
          <div class="profile_div">
          <div class="profile" style="float: left;border-radius:50%; height: 50px; overflow:hidden;">
            <div class="profile_pic"><img src="<?php echo $data[$i]['pro_pic_add'];?>"  style="width:50px; height:50px"; ></div>
          </div>
          <div class="nick"><?php echo $data[$i]['nick']; ?></div>
          </div>
          <a href="./reverse_auction.php?ra_id=<?php echo $data[$i]['ra_id']; ?>" class="cont_msg">お求め物:<?php echo $data[$i]['ra_name']; ?></a>
					<a href="./reverse_auction.php?ra_id=<?php echo $data[$i]['ra_id']; ?>" class="intr"><?php echo $data[$i]['introduction']; ?></a>
					<a href="./reverse_auction.php?ra_id=<?php echo $data[$i]['ra_id']; ?>" class="cont_msg">入札人数:<?php echo $data[$i]['bid_num']; ?></a>
					<a href="./reverse_auction.php?ra_id=<?php echo $data[$i]['ra_id']; ?>" class="cont_msg">設定値段:<?php echo $data[$i]['ra_price']; ?></a>
					<a href="./reverse_auction.php?ra_id=<?php echo $data[$i]['ra_id']; ?>" class="cont_msg">入札最低値段:
						<?php
							$msg= "まだ入札されていない";
							foreach($row1 as $key => $val){
							if(in_array($data[$i]['ra_id'],$val)){
								$msg= $val['MIN(bid_price)'];
							}
						}
						echo $msg;?></a>
            <span class="time"><?php echo $data[$i]['deadline']; ?>まで</span>
				</div>
				<?php
				}?>
			</div>


	</div>
  <!-- <iframe src="./personal_page/dm.php">asdasd </iframe> -->
	</div><!-- wrapperここまで -->

</body>


</div>
</html>
