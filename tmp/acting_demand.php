<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>COLLECTOWN</title>
	<link rel="stylesheet" type="text/css" href="./css/side_nav2.css">
	<link rel="stylesheet" type="text/css" href="./css/acting_demand2.css">
	<link rel="stylesheet" type="text/css" href="./css/stylesheet.css">

	<link rel="stylesheet" type="text/css"  href="css/reset.min.css">
	<link rel="stylesheet" type="text/css" href="css/dmstyle.css">
	<link rel="stylesheet" type="text/css" href="./css/home.css"/>
<!--
<link rel="stylesheet" type="text/css" href="./css/side_nav2.css"/>
-->
<link rel="stylesheet" type="text/css" href="./css/home2.css"/>
<link rel="stylesheet" type="text/css" href="./css/top.css"/>



	<!-- バリデーションチェック -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/validationEngine.jquery.min.css" type="text/css"/>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/jquery-1.8.2.min.js" type="text/javascript"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/languages/jquery.validationEngine-ja.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/jquery.validationEngine.min.js" type="text/javascript" charset="utf-8"></script>
	<style>
	#price{
		width: 80%;
		padding: 5px;
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
		var MAXWIDTH  = 200;
		var MAXHEIGHT = 200;
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
<header>
<?php require_once './tmp/header.php'; ?>
</header>
<div class="wrapper">
	<?php  require_once './tmp/side_nav.php'; ?>

	<div id="main">
		<p class="d_ttl">代行依頼</p>
		<div id = "inputForm">
			<!-- <div id="img_display" style="width:300px; height:200px;"> -->
		<form action="acting_done.php" method="post" enctype="multipart/form-data" id="imgupload">
			<!-- <input type="file" name="file" class="upload-file" id="acting_img"/>
			<label class="msg" id="img_msg"></label>
			<img id="preview" src="" alt="" > -->

			<div class="de_ttl">代行依頼品の画像</div>
			<div id="preview">
				<img id="imghead" border="0" src="./img/photo_icon2.svg" width="222" height="150" onClick="$('#previewImg').click();">
			 </div>
			<input type="file" name="file" onChange="previewImage(this)" style="display: none;" id="previewImg">
			<label class="msg" id="img_msg"></label>

				  <div class="css">
				    <label for="name" class="c_ttl2">代行依頼品</label><br>
				    <input id="name" type="text" name="name" required />
						<span class="msg"></span>
				  </div>
		</div><!-- inputForm -->
				<div class="demo demo10" id="price_div">
				  <div class="css">
				    <label for="price" class="c_ttl2">依頼希望価格</label><br>
				    <input id="price" type="number" name="price" min="0" max="99999999" required  class="validate[required,custom[number],custom[integer]]" placeholder="希望価格を入力してください"/>
						<span class="msg"></span>
				  </div>
				</div>
				<div id="genre_div">
					<select name="genre" required >
						<option value="default">ジャンルを選んでください</option>
						<?php
							$sql="SELECT * FROM genre ";
							$link=mysqli_connect(HOST,DB_USER,DB_PASS,DB_NAME);
							if(!$link){
							  return false;
							  //die('error:'.mysql_error());
							}
							mysqli_set_charset($link , 'utf8');
							$result=mysqli_query($link,$sql);
							if($result){
								if(mysqli_num_rows($result) > 0){
        					while($row = mysqli_fetch_assoc($result)){
            				echo "<option value='".$row['gen_id']."'>".$row['gen_name']."</option>";
        					}
								}
							}
							mysqli_close($link);
						?>
					</select>
					<span class="msg"></span>
				</div>
				<div id="time">
					<select name="acting_time" required >
						<option value="default">取引有効期限を指定してください</option>
						<option value="1">1日</option>
						<option value="2">2日</option>
						<option value="3">3日</option>
						<option value="4">4日</option>
						<option value="5">5日</option>
						<option value="6">6日</option>
						<option value="7">7日</option>
					</select>
					<span class="msg"></span>
				</div>
				<div class="demo demo1" id="intr_div">
				  <div class="css">
				    <label for="intr" class="c_ttl2">お取引概要<br>
				    <textarea name="intr" rows="20" cols="39" placeholder="ここに記入してください" required ></textarea><!-- rows:テキストエリアの高さ cols:テキストエリアの入力幅 -->
					</label>
				  </div>
				</div>
				<input type="submit" class="button" name="send" value="確認">
			</form>
		</div>
</div><!-- wrapperここまで-->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-fileinput.js"></script>
</form>
<?php require_once './tmp/footer.php'; ?>
</body>

</html>
