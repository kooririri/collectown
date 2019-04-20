<?php

if(isset($_POST['loginmail'])&&!empty($_POST['loginmail'])&&isset($_POST['loginpass'])&&!empty($_POST['loginpass'])){
	$mail=$_POST['loginmail'];
  $pass=$_POST['loginpass'];
	$sql="SELECT * FROM member WHERE mem_mail = '".$mail."' AND mem_pass ='".$pass."'" ;
	$link=mysqli_connect(HOST,DB_USER,DB_PASS,DB_NAME);
	if(!$link){
		return false;
	}
	mysqli_set_charset($link , 'utf8');
	$query=mysqli_query($link,$sql);
	$row=array();
	$row = mysqli_fetch_assoc($query);
	$_SESSION=$row;
	// header('location:./index.php');
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>COLLECTOWN</title>
	<!-- <link rel="stylesheet" type="text/css" href="./css/common.css"> -->
	<link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
	<link rel="stylesheet" type="text/css" href="./css/styles.css">
	<link rel="stylesheet" type="text/css" href="./css/header2.css">
  <link rel="stylesheet" href="css/simpleAlert.css">

	<style>
	#result_signupmail,#result_signuppass,#result_signuppass_check,#result_loginmail{
		color:red;
	}
	</style>
	<script type="text/javascript" src="./js/jquery.js"></script>
	<script type="text/javascript" src="./js/jquery.min.js"></script>
	<script src="js/simpleAlert.js"></script>
	<script type="text/javascript" src="./js/login.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script type="text/javascript">
	function YoN(){
		var dblChoseAlert = simpleAlert({
				"content":"ログアウトでよろしいでしょうか",
				"buttons":{
						"はい":function () {
								dblChoseAlert.close();
								window.location.href = "./logout.php";
						},
						"いいえ":function () {
								dblChoseAlert.close();
						}
					}
			})
	}
		function checkSignupForm(){
	    if(checksignupmail()&&checksignuppass()&&checksignuppass2()){
			    return true;
			}
			return false;
		}
		function checksignupmail(){
			window.flag=false;
				if($('#signupmail').val()==""){
					$('#result_signupmail').html("メールを入力してください");
					window.flag=false;
				}
				else{
					$.ajax({
						type:"POST",
						url:"./signupname_check.php",
						async:false,
						dataType:"json",
						data:{
							signupmail:$("#signupmail").val(),
						},
						success:function(data){
							if(data.success){
								$("#result_signupmail").html(data.msg);
								window.flag=true;
							}
							else{
								$("#result_signupmail").html(data.msg);
								window.flag=false;
							}
						},
						error:function(jqSHR){
							$("#result_signupmail").html("エラー:"+jqSHR.status);
						}
					});
				}
				return window.flag;
		}
		function checksignuppass(){
			if ($('#signuppass').val()=="") {
				$('#result_signuppass').html("パスワードを設定してください");
				// document.getElementById('signupbtn').disabled = "true";
				return false;
			}
			else if($('#signuppass').val().length>20){
				$('#result_signuppass').html("20文字以内にしてください");
				// document.getElementById('signupbtn').disabled = "true";
				return false;
			}
			else if($('#signuppass').val().length<8){
				$('#result_signuppass').html("安全のため8文字以上にしてください");
				// document.getElementById('signupbtn').disabled = "true";
				return false;
			}
			else{
				$('#result_signuppass').html("");
				$('#signupbtn').removeAttr("disabled");
				return true;
			}
			return true;
		}
		function checksignuppass2(){
			if($('#signuppass').val()!=$('#passcheck').val()){
				$('#result_signuppass_check').html("パスワード一致していません");
				// $('#signupbtn').attr("disabled",true);
				return false;
			}
			else{
				$('#result_signuppass_check').html("");
				// $('#signupbtn').removeAttr("disabled");
				return true;
			}
			return true;
		}
		var ck=false;
		function logincheck(){

			var loginmail=$('#loginmail').val();
			var loginpass=$("#loginpass	").val();
				if(loginmail==""){
					$('#result_loginmail').html("メールを入力してください");;
				}
				else{
					$.ajax({
						type:"POST",
						url:"./logincheck.php",
						async:false,
						dataType:"json",
						data:{
							loginmail:loginmail,
							loginpass:loginpass,
						},
						success:function(data){
							// var json = eval('(' + data + ')');
							if(data.success){
								$("#result_loginmail").html(data.msg);
								ck=data.check;
								// console.log(data.check);
								if(ck){
									$("#loginform").submit();
								}
							}
							else{
								$("#result_loginmail").html(data.msg);
								console.log(data.check);
							}
							return ck;
						},
						error:function(jqSHR){
							$("#result_loginmail").html("エラー:"+jqSHR.status);
						}
					});
				}
		}
		function checkForm($this){
	    var str=$this.value;
	    while(str.match(/[^A-Z^a-z\d\-]/))
	    {
	        str=str.replace(/[^A-Z^a-z\d\-]/,"");
	    }
	    $this.value=str;
		}

	</script>
</head>
<body>

	<div class="wrap_nav">
		<div class="service_ttl">
		<h1><a href="./index.php">COLLECTOWN<br>
		<span>自分だけのコレクション</span></a></h1>
		</div>
		<div class="main_nav">
			<ul>
				<li><a href="./up_col.php">コレクション</a></li>
				<li><a href="#">図鑑</a></li>
				<li><a href="./acting_demand.php">代行依頼募集</a></li>
				<li><a href="./index.php">代行募集一覧</a></li>
				<li><a href="#">スレッド</a></li>
				<?php
				if(isset($_SESSION)&&!empty($_SESSION['mem_id'])){?>
					<li><a href="./personal_page/index.php"><?php echo $_SESSION['mem_id']."さん" ?></a></li>
					<li><a href="#" id="dblChoseAlert" onclick="YoN();return false;">ログアウト</a></li>
				<?php
				}
				else{
				?>
					<div id="login-show" class="login"><img src="./img/person.svg" alt="member" width="25px"></div>
				<?php
				}
				?>
				<li><a href="#"><img src="./img/bell.svg" alt="member" width="25px" id="bell"></a></li>
			</ul>
		</div><!-- main_navここまで -->
	</div><!--wrap_navここまで  -->
	<div class="signup-modal-wrapper" id="login-modal">
		<div class="login-wrap" >
			<div class="login-html">
				<div class="close-modal">
	        <i class="fa fa-2x fa-times"></i>
	      </div>
				<input id="tab-1" type="radio" name="tab" class="sign-in" checked /><label for="tab-1" class="tab">ログイン</label>
				<input id="tab-2" type="radio" name="tab" class="sign-up" /><label for="tab-2" class="tab">新規登録</label>
				<div class="login-form">
					<form method="post" action="./index.php" name="loginform" id="loginform">
					<div class="sign-in-htm">
						<div class="group">
							<label for="user" class="label">メール</label>
							<input id="loginmail" type="email" class="input" name="loginmail" >
							<div id="result_loginmail"></div>
						</div>
						<div class="group">
							<label for="pass" class="label">パスワード</label>
							<input id="loginpass" onInput="checkForm(this)" type="password" class="input" data-type="password" name="loginpass">
							<div id="result_loginpass"></div>
						</div>
						<div class="group">
							<input id="check" type="checkbox" class="check"/>
							<label for="check"><span class="icon"></span> パスワードを覚えますか</label>
						</div>
						<div class="group">
							<input onclick="logincheck();return false;" type="submit" class="button" name="login" value="ログイン" />
						</div>
						<div class="hr"></div>
						<div class="foot-lnk">
							<a href="#forgot">パスワードお忘れですか?</a>
						</div>
					</div>
					</form>
					<form method="post"  name="signupform" action="./signupok.php" onsubmit="return checkSignupForm();">
					<div class="sign-up-htm">
						<div class="group">
							<label for="mail" class="label">メール</label>
							<input id="signupmail"  onblur="checksignupmail();" type="email" class="input" name="signupmail">
							<div id="result_signupmail"></div>
						</div>
						<div class="group">
							<label for="pass" class="label">パスワード</label>
							<input id="signuppass" onblur="checksignuppass();" onInput="checkForm(this)" class="input" data-type="password" name="signuppass" type="password"  >
							<div id="result_signuppass"></div>
						</div>
						<div class="group">
							<label for="pass" class="label">もう一度パスワード</label>
							<input id="passcheck" onblur="checksignuppass2();" onInput="checkForm(this)" type="password" class="input" data-type="password" name="signuppass_check"/>
							<div id="result_signuppass_check"></div>
						</div>
						<div class="group" style="margin-top:50px;">
							<label id="signupmsg" for="signup" class="label"></label>
							<input id="signupbtn" type="submit" class="button" name="signup" value="登録" />
						</div>
						<div class="hr"></div>
						<div class="foot-lnk">
							<label for="tab-1" class="button">アカウントお持ちでしょうか?</a>
						</div>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
