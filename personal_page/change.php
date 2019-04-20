<?php
session_start();
require_once "../config.php";
if(isset($_POST['hidden'])){
//////////////////////////////////パスワード変更/////////////////////////////////
    if(!empty($_POST['pass1'])){
        if(!empty($_POST['pass2'])){
              $mem_id = $_SESSION["mem_id"];
                if($_POST['pass2'] === $_POST['pass3']){
                    $mainpass = $_POST['pass1'];
                    $secondpass = $_POST['pass2'];
                    $therdpass = $_POST['pass3'];
                    $mem_id = $_SESSION["mem_id"];
                    $mem_pass = $_SESSION["mem_pass"];
                    $promis = array();
                    //データベース接続
                      $link = mysqli_connect('localhost','root','','collectown');
                      $pass1 = $_POST["pass1"];
                      $pass2 = $_POST["pass2"];

                      //DB書き込み
                      $update = "UPDATE member SET mem_pass = '".$pass2."' WHERE mem_id = '$mem_id'";
                      $end = mysqli_query($link,$update);
                    }else{
                      $error = "新しいパスワードと確認用パスワードが一致しません。";
                    }
                }
              }
///////////////////////////////////////ニックネーム変更////////////////////////////////////////////
  if(!empty($_POST['name'])){
    $name = $_POST['name'];
    $mem_id = $_SESSION['mem_id'];
    $namecomit = array();
      $link = mysqli_connect('localhost','root','','collectown');
      $namefind = "SELECT name FROM member_info WHERE mem_id = $mem_id";
      $nameif = mysqli_query($link,$namefind);
      if($nameif){
        $namecomit = mysqli_fetch_assoc($nameif);
      }
      if(!isset($namecomit)){
        $namesql = "INSERT INTO member_info(mem_id,nick)VALUES($mem_id,'$name')";
          $nameend = mysqli_query($link,$namesql);
      }else{
        $namesql = "UPDATE member_info  SET nick = '$name' WHERE mem_id= $mem_id";
        $nameend = mysqli_query($link,$namesql);
      }
  }
  ///////////////////////////////////////性別/////////////////////////////////////////////////////
  if(!empty($_POST['gender'])){
    $gender = $_POST['gender'];
    $mem_id = $_SESSION['mem_id'];
      $link = mysqli_connect('localhost','root','','collectown');
      $genderfind = "SELECT sex FROM member_info WHERE mem_id = $mem_id";
      $genderif = mysqli_query($link,$genderfind);
      $gendercomit = mysqli_fetch_assoc($genderif);
      if(!isset($gendercomit)){
        $gendersql = "INSERT INTO member_info(mem_id,sex)VALUES($mem_id,'$gender')";
          $genderend = mysqli_query($link,$gendersql);
      }else{
        $gendersql = "UPDATE member_info  SET sex = '$gender' WHERE mem_id= $mem_id";
        $genderend = mysqli_query($link,$gendersql);
      }
  }
  ////////////////////////////////////誕生日/////////////////////////////////////////////////////
  if(!empty($_POST['birth'])){
    $date = $_POST['birth'];
    echo $date;
    $mem_id = $_SESSION['mem_id'];
      $link = mysqli_connect('localhost','root','','collectown');
      $datefind = "SELECT birth FROM member_info WHERE mem_id = $mem_id";
      $dateif = mysqli_query($link,$datefind);
      $datecomit = mysqli_fetch_assoc($dateif);
      if(!isset($datecomit)){
        $datersql = "INSERT INTO member_info(mem_id,birth)VALUES($mem_id,'$date')";
          $dateend = mysqli_query($link,$datesql);
      }else{
        $datesql = "UPDATE member_info  SET birth = '$date' WHERE mem_id= $mem_id";
        $dateend = mysqli_query($link,$datesql);
      }
  }
  ////////////////////////////////住所///////////////////////////////////////////////////////////
  if(!empty($_POST['zip01'])){
    if(!empty($_POST['pref01'])){
      if(!empty($_POST['addr01'])){
    $fastadd = $_POST['zip01'];
    $secondadd = $_POST['pref01'];
    $therdadd = $_POST['addr01'];
    $alladd = $secondadd.$therdadd;
    $addcomit = array();
    $mem_id = $_SESSION['mem_id'];
      $link = mysqli_connect('localhost','root','','collectown');
      $addfind = "SELECT addr FROM member_info WHERE mem_id = $mem_id";
      $addif = mysqli_query($link,$addfind);
      $addcomit = mysqli_fetch_assoc($addif);
      if(!isset($addcomit)){
        $addrsql = "INSERT INTO member_info(mem_id,addr)VALUES($mem_id,'$alladd')";
          $addrend = mysqli_query($link,$addrsql);
      }else{
        $addrsql = "UPDATE member_info  SET addr = '$alladd' WHERE mem_id= $mem_id";
        $addrend = mysqli_query($link,$addrsql);
      }
    }
  }
}
    ///////////////////////////アイコンアップロード/////////////////////////////////////////
    if(isset($_FILES)){
      $img = array();
      $mem_id = $_SESSION['mem_id'];
      $link = mysqli_connect('localhost','root','','collectown');
      $imgfind = "SELECT img_id FROM member_info WHERE mem_id = $mem_id";
      $imgif = mysqli_query($link,$imgfind);
      $imgcomit = mysqli_fetch_assoc($imgif);
      $imgaddr = '../images/profile_images/';
      var_dump($imgcomit);
      if(!empty($imgcomit)){
        $maxsql = "SELECT COUNT(img_id) as cnt FROM images";
        $maxif = mysqli_query($link,$maxsql);
        $maxcomit = mysqli_fetch_assoc($maxif);
        $maxs = $maxcomit['cnt'] + 1;
        $data = $_FILES['data']["tmp_name"];
         move_uploaded_file($data,$imgaddr.$maxs.".jpg");
         $imgnamefast = ".jpg";
        $imgname= $imgaddr.$maxs.$imgnamefast;
         $imgadd = "INSERT INTO images(img_id,img_add)VALUES($maxs,'".$imgname."')";
        $img_idend = mysqli_query($link,$imgadd);
        $imgsql = "UPDATE member_info  SET img_id = $maxs WHERE mem_id= $mem_id";
          $imgend = mysqli_query($link,$imgsql);
      }else{
        $imgsql = "UPDATE member_info  SET img_id = $maxs WHERE mem_id= $mem_id";
        $imgend = mysqli_query($link,$imgsql);
      }
    }
  mysqli_close($link);
}
?>
<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/change.css" rel="stylesheet" type="text/css">
<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
<title>入力フォーム</title>
</head>
<body>
  <div id="warpper">
  <div id="nyuryoku">
  <form name="form1" method="POST" action="change.php"  enctype="multipart/form-data">
    <div id="icon">
    <h2>アイコンの変更</h2>
    <input type="file"name="data">
  </div>
  <div id="nic">
    <h2>ニックネーム変更</h2>
    <input type="text" name="name">
  </div>
  <div id="gender">
    <h2>性別登録</h2>
      <input type="radio" name="gender" value="男">男性
      <input type="radio" name="gender" value="女">女性
    </div>
    <div id="birth">
    <h2>誕生日登録</h2>
      <input type="date" name="birth">
    </div>
    <div id="from">
    <h2>住所</h2>
    郵便番号入力(7桁)<br>
    <input type="text" name="zip01" size="10" maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','pref01','addr01');"><br>
    都道府県<br>
    <input type="text" name="pref01" size="20"><br>
    都道府県以降の住所<br>
    <input type="text" name="addr01" size="60"><br>
  </div>
  <div id="pass">
    <h2>パスワード変更</h2>
      現在のパスワード：<input type="password" name="pass1"><br>
      新しいパスワード：<input type="password" name="pass2"><?php// echo $passerror; ?><br>
      パスワード確認：<input type="password" name="pass3"><br>
    </div>
      <div class="button">
        <input type = "hidden" name="hidden">
        <input class="btn-square" type="submit" value="変更" name="send">
      </div>
    </form>
  </div>
</div>
</body>
</html>
