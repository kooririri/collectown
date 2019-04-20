<?php
session_start();
header("content-type:text/html;charset=utf-8");
require_once 'config.php';
require_once 'function.php';

if(varCheck($_POST) === true){
	//formの情報をデータベースに登録する
	$mem_id = $_SESSION['mem_id'];
	$img_name = $_SESSION['img_name'];
	$time = date("Y-m-d H:i:s");
	$caption = h($_POST['caption']);
	$caption = nlbr($caption);
	$gen_id = h($_POST['genre']);
	$rearity = h($_POST['rearity']);
	$release_flag = h($_POST['rele_flag']);

	//echo '公開設定'.$release_flag;
	//echo '<br><br>';

	if($release_flag == '公開'){
		$release_flag = 1;

	}elseif($release_flag == '非公開'){
		$release_flag = 0;
	}

	//確認用
	// echo $mem_id.'<br>';
	// echo $time.'<br>';
	// echo $caption.'<br>';
	// echo $caption.'<br>';
	// echo $gen_id.'<br>';
	// echo $rearity.'<br>';
	// echo '公開設定<br>'.$release_flag.'<br>';

}

//レア度を文字列から数値に変換
  if($_POST['rearity'] != ''){
	  $rearity = $_POST['rearity'];
	  //var_dump($rearity);
	  switch($rearity){
		case '1':
			$rearity = 1;
			break;

		case '2':
			$rearity = 2;
			break;

		case '3':
			$rearity = 3;
			break;

		case '4':
			$rearity = 3;
			break;

		case '5':
			$rearity = 5;
			break;

			default:
			echo 'レア度の選択がありません';;
	  }
	//  echo $rearity;

  }else {
	  echo 'レア度の選択がありません';
  }


$link = mysqli_connect(HOST,DB_USER,DB_PASS,DB_NAME);
	if(!$link){
	  return false;
	}
	mysqli_set_charset($link , 'utf8');

	//formの情報をデータベースに登録する
	$mem_id = $_SESSION['mem_id'];
	$time = date("Y-m-d H:i:s");
	$caption = h($_POST['caption']);
	$gen_id = h($_POST['genre']);
	$rearity = h($_POST['rearity']);
	$release_flag = h($_POST['rele_flag']);

/*
	$sql1 = "SELECT * FROM hash_tag";
	$result1 = mysqli_query($link, $sql1);
	$row1 = array();
	while($res1 = mysqli_fetch_assoc($result1)){
		$row1[] = $res1;
	}
	foreach($row1 as $hash){

		//if(mb_strpos($hash['hash_tag'],$caption) === false){
		if(mb_strpos($hash['hash_tag'],$caption) === true){

		}

	}

	*/

	//var_dump($result1);
	//var_dump($row1);
	/*
	$sql2 = "INSERT INTO images(img_id, img_a, time)
			SELECT COALESCE(MAX(img_id)+1,1), '".$img_name."', '".$time."'
			FROM images";
	$result2 = mysqli_query($link, $sql2);
	if(!$result2){
		$err_msg = 'result3 SQL文が実行できませんでした';
		exit;
	}
	*/

	$sql3 = "INSERT INTO col_content(post_id, post_time, caption, img_name, gen_id, rarity, rele_flag)
			 SELECT COALESCE(MAX(post_id)+1,1),'".$time."','".$caption."', '".$img_name."', '".$gen_id."', '".$rearity."','".$release_flag."'
			 FROM col_content";

	$result3 = mysqli_query($link, $sql3);
	if(!$result3){
		//エラー処理
		$err_msg = 'result3 SQL文が実行できませんでした';
		echo $err_msg;
		exit;
	}

//データベースを閉じる
mysqli_close($link);

header("refresh:5;url=index.php");
print('登録完了 5秒後ホームページに戻ります');


?>
