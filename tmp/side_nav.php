<?php
require_once './config.php';
require_once './function.php';

//デバッグ用
//var_dump();
?>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>COLLECTOWN</title>
<meta content="タイトル" name="title">
<meta content="ディスクリプション" name="description">
<meta content="キーワード" name="keywords">

<!--cssを読み込む-->
<!-- <link rel="stylesheet" href="./css/common.css"> -->
<link rel="stylesheet" href="./css/side_nav2.css">
<!--
<link href="./css/validationEngine.jquery.css" rel="stylesheet" type="text/css">
-->
<!-- JavaScriptを読み込む -->
<!--
<script src="js/jquery-3.3.1.min.js" type="text/javascript"></script>
<script src="js/jquery.autosize.min.js"></script>
<script type="text/javascript">
-->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/validationEngine.jquery.min.css" type="text/css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/jquery-1.8.2.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/languages/jquery.validationEngine-ja.min.js" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/jquery.validationEngine.min.js" type="text/javascript" charset="utf-8"></script>
<!--
<script src="./js/jquery-1.12.0.min.js" charset="utf-8"></script>
-->

<!-- JavaScriptを読み込む -->
<!--
<script src="./js/jquery-3.3.1.min.js" type="text/javascript"></script>
<script src="./js/jquery.autosize.min.js"></script>
-->


<!-- 入力フォームチェック -->
<script type="text/javascript">
jQuery(document).ready(function(){
   jQuery("#regi").validationEngine();
});

/*
$(function(){
      jQuery("#regi").validationEngine();
    });*/
</script>
<script type="text/javascript">
jQuery(document).ready(function(){
   jQuery("#regi2").validationEngine();
});

</script>
	<!-- 入力フォームチェック -->
	<script type="text/javascript">
	jQuery(document).ready(function(){
	   jQuery("#form5").validationEngine();
	});

	</script>


<!--[if 1t IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->

</head>
<body>
	<div class="side_nav">
		<div class="">
		<form name="search" action="search_output.php" method="get">
			<dl class="search">
				<dt><input type="text" name="search" placeholder="代行検索"></dt>
				<dd style="cursor:pointer;"><button style="cursor:pointer;"><span></span></button></dd>
			</dl>
		</form><!-- 検索窓 -->

		</div>

		<div class="acting_btn">
				<a href="./acting_demand.php">代行募集する</a><!-- 代行募集するページへのリンク -->
		</div><!-- acting_btnここまで -->


		<div class="form1">
			<p class="ttl">新規会員登録はこちら</p>
			<form id="regi" action="#" method="post">
				<p class="f_con">名前</p>
				<input type="text" name="name" class="validate[required]" placeholder=" 山田太郎">
				<p class="f_con">メールアドレス</p>
				<input type="text" name="email" class="validate[required,custom[email]]" placeholder=" info@collectown.co.jp">
				<div class="btn">

				<button type="submit" onclick="check()">仮登録する</button>

				<!--
				<input type="submit" value="送信" onclick="check()">
				-->
				</div>
			</form>
		</div><!-- form1 -->

		<div class="form2">
			<p class="ttl">ログインはこちら</p>
			<form id="regi2" action="./tmp/regist.php" method="post">
				<p class="f_con">ユーザID（メールアドレス）</p>
				<input type="text" name="user" class="validate[required]" placeholder=" 山田太郎">
				<p class="f_con">パスワード</p>
				<input type="password" name="password11" id="password1" class="validate[required]" placeholder="001204356">
				<p class="f_con">パスワード確認</p>
				<input type="password" name="password2" id="password2" class="validate[required,equals[password1]]" placeholder="001204356">
				<div class="btn">
				<button type="submit">ログインする</button>
				</div>
			</form>
		</div><!-- form2 -->

		<div class="category_search">
			<p class="ttl2">カテゴリから探す</p>
			<ul>
				<li><a href="#"><img src="./img/car.svg" alt="" width="28px"><span>カテゴリー名が入ります</span></a></li>
				<li><a href="#"><img src="./img/bike.svg" alt="" width="28px"><span>カテゴリー名が入ります</span></a></li>
				<li><a href="#"><img src="./img/wear.svg" alt="" width="28px"><span>カテゴリー名が入ります</span></a></li>
				<li><a href="#"><img src="./img/picture.svg" alt="" width="28px"><span>カテゴリー名が入ります</span></a></li>
				<li><a href="#"><img src="./img/game.svg" alt="" width="28px"><span>カテゴリー名が入ります</span></a></li>
			</ul>
		</div><!-- category_search -->



		<div class="ranking_search">
			<p class="ttl2">ランキングから探す</p>
			<ul>
				<div class="rank_con">
				<li>
					<div class="article_img">
						<div class="num">1</div>
						<img src="#" alt="">
					</div><!--article_imgここまで  -->
				</li>
				<li>
					<div class="article_con">
					ここには記事の概要文がはいります
					ここには記事の概要文がはいります
					ここには記事の概要文がはいります
					ここには記事の概要文がはいります
					</div>
				</li>
				</div><!-- rank_conここまで -->
				<div class="rank_con">
				<li>
					<div class="article_img">
						<div class="num">2</div>
						<img src="#" alt="">
					</div><!--article_imgここまで  -->
				</li>
				<li>
					<div class="article_con">
					ここには記事の概要文がはいります
					ここには記事の概要文がはいります
					ここには記事の概要文がはいります
					ここには記事の概要文がはいります
					</div>
				</li>
				</div><!-- rank_conここまで -->
				<div class="rank_con">
				<li>
					<div class="article_img">
						<div class="num">3</div>
						<img src="#" alt="">
					</div><!--article_imgここまで  -->
				</li>
				<li>
					<div class="article_con">
					ここには記事の概要文がはいります
					ここには記事の概要文がはいります
					ここには記事の概要文がはいります
					ここには記事の概要文がはいります
					</div>
				</li>
				</div><!-- rank_conここまで -->
				<div class="rank_con">
				<li>
					<div class="article_img">
						<div class="num">4</div>
						<img src="#" alt="">
					</div><!--article_imgここまで  -->
				</li>
				<li>
					<div class="article_con">
					ここには記事の概要文がはいります
					ここには記事の概要文がはいります
					ここには記事の概要文がはいります
					ここには記事の概要文がはいります
					</div>
				</li>
				</div><!-- rank_conここまで -->
				<div class="rank_con">
				<li>
					<div class="article_img">
						<div class="num">5</div>
						<img src="#" alt="">
					</div><!--article_imgここまで  -->
				</li>
				<li>
					<div class="article_con">
					ここには記事の概要文がはいります
					ここには記事の概要文がはいります
					ここには記事の概要文がはいります
					ここには記事の概要文がはいります
					</div>
				</li>
				</div><!-- rank_conここまで -->

			</ul>
		</div><!-- rankingsearch -->

		<div class="hush">
		<p class="ttl2">トレンドハッシュタグ</p>
			<div class="h_con">
				<div class="tag"><a href="#"><span>#トレンド</span></a></div>
				<div class="tag"><a href="#"><span>#ハッシュ</span></a></div>
				<div class="tag"><a href="#"><span>#色々</span></a></div>
				<div class="tag"><a href="#"><span>#タグ</span></a></div>
				<div class="tag"><a href="#"><span>#お宝</span></a></div>
				<div class="tag"><a href="#"><span>#コレクション大公開</span></a></div>
				<div class="tag"><a href="#"><span>#売ります</span></a></div>
				<div class="tag"><a href="#"><span>#買います</span></a></div>
				<div class="tag"><a href="#"><span>#探しています</span></a></div>
				<div class="tag"><a href="#"><span>#お気に入り集公開</span></a></div>
				<div class="tag"><a href="#"><span>#艦これフィギュア</span></a></div>
				<div class="tag"><a href="#"><span>#ガンダム</span></a></div>
				<div class="tag"><a href="#"><span>#漫画</span></a></div>
			</div><!-- h_conここまで -->
		</div><!-- hushここまで -->
	</div><!-- side_navここまで -->
	<!--
<script src="./js/main.js" charset="utf-8"></script>
-->
</body>
</html>
