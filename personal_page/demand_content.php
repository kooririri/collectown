<?php
// echo $_GET['ra_id'];
session_start();
require_once '../config.php';
require_once '../function.php';
$ra_id=$_GET['ra_id'];
$link=mysqli_connect(HOST,DB_USER,DB_PASS,DB_NAME);
if(!$link){
  return false;
}
mysqli_set_charset($link , 'utf8');


$sql="SELECT MIN(bid_price),ra_application.mem_id FROM ra_application INNER JOIN member ON ra_application.mem_id = member.mem_id GROUP BY ra_application.ra_id HAVING ra_application.ra_id = '".$ra_id."'";
$query = mysqli_query($link,$sql);
$row=array();

while($a=mysqli_fetch_assoc($query)){
  $row[]=$a;
}
// var_dump($row);
$sql_img="SELECT * FROM ra_content INNER JOIN images ON ra_content.img_id = images.img_id WHERE ra_content.ra_id = '".$ra_id."'";
$query_img = mysqli_query($link,$sql_img);
$row_img = mysqli_fetch_assoc($query_img);

$sql_bid = "SELECT * from ra_content LEFT OUTER JOIN ra_application ON ra_content.ra_id = ra_application.ra_id WHERE ra_content.ra_id = '".$ra_id."'" ;
$query_bid = mysqli_query($link,$sql_bid);
$row_bid = array();
while($a = mysqli_fetch_assoc($query_bid)){
  $row_bid[] = $a;
}
// var_dump($row_bid);
$bid_num = '';

//表示したい項目を変数に格納する
foreach($row_bid as $rows){
	$ra_name = $rows['ra_name'];
	$gen = $rows['gen_id'];
	$intr = $rows['introduction'];
	$start_time = $rows['start_time'];
	$price = num($rows['ra_price']);
	$bid_price = num($rows['bid_price']);
	$deadline=strtotime($rows['start_time'])+$rows['ra_time']*24*60*60;
  $rest = date("Y-m-d H:i:s",$deadline);

	$person = $rows['bid_num'];
  $bid_person=$rows['mem_id'];
}
//$sql2 = "SELECT * FROM ";


//データベースを閉じる
mysqli_close($link);

//var_dump($row);
//var_dump($row_bid);
// var_dump($row_bid);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>collectown</title>
<link rel="stylesheet" href="css/demand_con.css" />
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
<link rel="stylesheet" type="text/css" href="./css/side_nav2.css">
<link rel="stylesheet" type="text/css" href="./css/acting_demand2.css">
<link rel="stylesheet" type="text/css" href="./css/stylesheet.css">

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

<script type="text/javascript">
	jQuery(document).ready(function(){
	   jQuery("#imgupload").validationEngine();
	});

</script>

<script type="text/javascript">
	$(document).ready(function () {
	 $("#sendbtn").click(function () {
		 var file = $("#previewImg").val();
		 if (file == "") {
			 $('#img_msg').html("画像を選択してください");
			 return false
		 }
		 return true;
	 });
	});


	function previewImage(file)
	{
		var MAXWIDTH  = 100;
		var MAXHEIGHT = 100;
		var div = document.getElementById('preview');
		if (file.files && file.files[0])
		{
			div.innerHTML ='<img id=imghead onclick=$("#previewImg").click()>';
			var img = document.getElementById('imghead');
			img.onload = function(){
				var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
				img.width  =  rect.width;
				img.height =  rect.height;
//                 img.style.marginLeft = rect.left+'px';
				img.style.marginTop = rect.top+'px';
			}
			var reader = new FileReader();
			reader.onload = function(evt){img.src = evt.target.result;}
			reader.readAsDataURL(file.files[0]);
		}
		else //兼容IE
		{
			var sFilter='filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src="';
			file.select();
			var src = document.selection.createRange().text;
			div.innerHTML = '<img id=imghead>';
			var img = document.getElementById('imghead');
			img.filters.item('DXImageTransform.Microsoft.AlphaImageLoader').src = src;
			var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
			status =('rect:'+rect.top+','+rect.left+','+rect.width+','+rect.height);
			div.innerHTML = "<div id=divhead style='width:"+rect.width+"px;height:"+rect.height+"px;margin-top:"+rect.top+"px;"+sFilter+src+"\"'></div>";
		}
	}
	function clacImgZoomParam( maxWidth, maxHeight, width, height ){
			var param = {top:0, left:0, width:width, height:height};
			if( width>maxWidth || height>maxHeight ){
				rateWidth = width / maxWidth;
				rateHeight = height / maxHeight;

				if( rateWidth > rateHeight ){
						param.width =  maxWidth;
						param.height = Math.round(height / rateWidth);
				}else{
						param.width = Math.round(width / rateHeight);
						param.height = maxHeight;
				}
			}
			param.left = Math.round((maxWidth - param.width) / 2);
			param.top = Math.round((maxHeight - param.height) / 2);
			return param;
	}
</script>
</head>
<body>


    <div id="main">

	<div class="de_name"><?php echo $rows['ra_name']; ?></div>
		<div class="demand_wrap">
			<div id="preview">
				<img id="imghead" border="0" src="<?php echo "../".$row_img['img_add'];  ?>" onClick="$('#previewImg').click();">
			</div>
			<input type="file" name="file" onChange="previewImage(this)" style="display: none;" id="previewImg">
			<label class="msg" id="img_msg"></label>
			<div class="intr"><?php  echo $intr; ?></div>
		</div>

		<div class="demand_con2">
			<!--<div id="cont"> -->
				<p>登録日　　　　　<span><?php echo $start_time; ?></span></p>
				<p>残り日数　　　　<span><?php echo $rest; ?></span></p>
				<p>希望価格　　　　<span><?php echo $price,"円"; ?></span></p>
				<p>現在の価格　　　<span><?php echo $bid_price,"円"; ?>（引き受け希望価格）</span></p>
				<p>引き受け希望人数<span><?php echo $person, "人"; ?>（引き受け希望価格）</span></p>
        <p>現在応募者　　　<span><?php echo $bid_person; ?></span></p>

		</div>

		<!--
		<div class="delete">
		<button id="cancel">取消</button>
		</div>
		-->
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap-fileinput.js"></script>

	</div><!-- mainここまで -->
</form>
</body>
</html>
