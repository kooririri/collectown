<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>COLLECTOWN</title>
	<!-- <link rel="stylesheet" type="text/css" href="./css/common.css"> -->
	<!-- <link rel="stylesheet" type="text/css" href="./css/side_nav2.css"> -->
	<link rel="stylesheet" type="text/css" href="./css/reverse_auction.css">
	<link rel="stylesheet" type="text/css" href="./css/stylesheet.css">

	<link rel="stylesheet" type="text/css"  href="css/reset.min.css">
	<link rel="stylesheet" type="text/css" href="css/dmstyle.css">
	<link rel="stylesheet" type="text/css" href="./css/home.css"/>
	<!-- <style>
	@charset "utf-8";

	/* 子要素 */
	.main_con {
		width: 100%;
		margin: 10px 0px 10px 50px;
	}
	.main_con h2{
		font-size: 30px;
	}

	.main_con ul {
		list-style: none;
	}

	/*  */
	.main_top {
		display: flex;
		margin-bottom: 30px;
	}


	/* 画像 */
	.auction_img {
		margin: 50px 0px 0px 40px;
		min-width: 30%;
		height: 20%;
		background-color: #F2F2F2;
		max-width: 450px;

	}
	.caption {
		margin: 0px 0px 0px 50px;
	}
	.caption .ttl {
		margin-top: 50px;
		font-size: 20px;
	}
	.auction_img img{
		width: auto;
		height: auto;
		max-width: 100%;
		max-height: 100%;
	}

	/* 募集内容 */
	.auction_con {
		width: 100%;
	}
	.auction_con li {
		width: 100%;
		border-bottom: solid 1px #F2F2F2;
		font-size: 18px;
		padding: 10px 0px 10px 0px;
		vertical-align: center;
	}

	.auction_con span {
		position: absolute;
		left:500px;
	}

	/* 入札参加 */
	.join {
		margin: 50px 0px 30px 40px;
	}

	input#auction {
		padding: 10px;
		margin-bottom: 50px;
	}

	.join input.btn {
		background-color: #3B4043;
		color: #fff;
		border-style: none;
		width: 80%;
		padding: 20px 10px 20px 10px;
		font-size: 20px;

	}

	input[type="submit"]:hover{
		color: #AEE0E6;
	}


	.join p{
		font-size: 18px;
		margin: 10px 0px 5px 0px;

	}
	.auction_con2 span {
		margin-left: 280px;
		/* margin-left: 100px; */
	}
	#auction{
		width:200px;
	}
	input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
    }
    input[type="number"]{
        -moz-appearance: textfield;
    } -->
	</style>
	<!-- バリデーションチェック -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/validationEngine.jquery.min.css" type="text/css"/>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/jquery-1.8.2.min.js" type="text/javascript"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/languages/jquery.validationEngine-ja.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/jquery.validationEngine.min.js" type="text/javascript" charset="utf-8"></script>

	<!-- 入力フォームチェック -->
<script type="text/javascript">
jQuery(document).ready(function(){
   jQuery("#form2").validationEngine();
});

</script>
</head>
<body>
<header>
<?php require_once './tmp/header.php';  ?>
</header>


<div class="wrapper">
	<?php  require_once './tmp/side_nav.php'; ?><!-- サイドナビの呼び出し -->

	<div class="main_con">
		<h2>代行引き受け</h2>
		<div class="main_top">
			<div class="auction_img">
				<img src="<?php echo $res['img_add']; ?>">
			</div><!-- auction_imgここまで -->

			<div class="caption">
			<p class="ttl">概要</p>
			<p>
			<?php echo nlbr($res['introduction']); ?>
			</p>
			</div><!-- captionここまで -->


		</div><!-- main_topここまで -->

		<div class="auction_con">
			<div class="a_con">
				<div class="a_ttl">依頼者</div>
				<div class=""><?php echo $res1['mem_mail']; ?></div>
			</div><!-- a_con -->

			<div class="a_con">
				<div class="a_ttl">商品名</div>
				<div class=""><?php echo $res['ra_name']; ?></div>
			</div>

			<div class="a_con">
				<div class="a_ttl">希望価格</div>
				<div class=""><?php echo num($res['ra_price']).'円'; ?></div>
			</div>

			<div class="a_con">
				<div class="a_ttl">入札された最低価格</div>
				<div class="">
					<?php
					if($res2===null){
						echo "まだ入札されていない";
					}
					else{
						echo num($res2['MIN(bid_price)']).'円';
					}
					?>

				</div>
			</div>

			<div class="a_con">
				<div class="a_ttl">有効期限</div>
				<div class="deadline"><?php echo $res['deadline']; ?></div>
			</div><!-- a_con -->
		</div><!-- auction_con -->





		<div class="auction_con2">
			<div class="a_ttl2">代行引き受け希望者情報</div>

			<div class="a_con2">
				<div class="a_ttl">代行引き受け最安価格</div>
				<div class="">
					<?php if($res2['MIN(bid_price)']==null){
						echo "まだ入札されていない";
					}
					else{
						echo number_format($res2['MIN(bid_price)'])."円";
					}?>
				</div>
			</div><!-- a_con2　ここまで -->

			<div class="a_con2">
				<div class="a_ttl">代行引き受け希望人数</div>
				<div class="">
					<?php
					// if($res3===null){
					// 	echo 0;
					// }
					// else{
					// 	echo $res3['COUNT(*)'];
					// }
					echo $res['bid_num'];
					?>人
				</div>
			</div><!-- a_con2 -->

		</div><!-- auction_con2 ここまで -->

		<div class="join">
			<form id="form2" action="./bid_done.php" method="post">
				<div class="a_ttl3">希望価格</div>
				<input type="number" id="auction"
				<?php
				if($res2===null){
				?>
						max="<?php echo $res['ra_price'] ?>"
						min="0"
						<?php
				}
				else{
					?>
					max="<?php echo $res2['MIN(bid_price)'] ?>"
					min="0"
					<?php
				}
				?>name="bid_price" class="validate[required,custom[number],custom[integer]]" placeholder="希望価格を入力してください"><br>
				<input type="hidden" name="ra_id" value="<?php echo $res['ra_id']; ?>" >
				<input type="submit" class="btn" name="bid_send" value="入札参加する"><!-- 入札設定;ページへ -->
			</form>
		</div><!-- join -->




	</div><!-- main_conrここまで -->
</div><!-- wrapperここまで -->
<?php require_once './tmp/footer.php'; ?>
</body>

</html>
