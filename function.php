<?php
/**
 *  引数で指定されたDBに対して更新系のSQLを実行する
 *　更新できた場合はtrue、更新できない場合はfalseを戻す
 *
 * @param string $sql 更新系のSQL
 * @param string $host ホスト名
 * @param string $user DBユーザー名
 * @param string $pass DBパスワード名
 * @param string $db データベース名
 * @return bool
 */
function execute($sql,$host,$user,$pass,$db){
  $link = mysqli_connect($host,$user,$pass,$db);
  if(!$link){
    return false;
  }
  mysqli_set_charset($link , 'utf8');
  if(!mysqli_query($link, $sql)){
    mysqli_close($link);
    return false;
  }
  mysqli_close($link);
}

function ra_get(){
  $link=mysqli_connect(HOST,DB_USER,DB_PASS,DB_NAME);
  if(!$link){
    return false;
  }
  mysqli_set_charset($link , 'utf8');
  $sql="SELECT * FROM ra_content";
  $query_cont=mysqli_query($link,$sql);
  $row=array();
  while($a=mysqli_fetch_assoc($query_cont)){
    $row[]=$a;
  }
  for($i=0;$i<count($row);$i++){
    $deadline=strtotime($row[$i]['start_time'])+$row[$i]['ra_time']*24*60*60;
    $row[$i]['deadline']=date("Y-m-d H:i:s",$deadline);
    $now_time=time();
    $resttime=$deadline-$now_time;
    $row[$i]['resttime']=$resttime;
    $img_id=$row[$i]['img_id'];
    $sql_img="SELECT img_add FROM images WHERE img_id =".$img_id;
    $query_img=$query_cont=mysqli_query($link,$sql_img);
    $re=mysqli_fetch_assoc($query_img);
    $row[$i]['img_add']=$re['img_add'];
  }
  return $row;
  mysqli_close($link);
}

function h($str){
	return htmlspecialchars($str,ENT_QUOTES);
}

/** 
**	サニタイズ 
**
*/
function nlbr($str){
	return nl2br($str);
}

/** 
**	数値を３桁ごとにカンマ区切りにする 
**
**
*/
function num($val){
	return number_format($val);
}


/**
** 変数が設定されているかどうか調べる関数
**    
*/
function varCheck($var){
	
	//変数が空か０でないかどうかを判定する
	if(empty($var)){
		//echo '変数 $varは空か０です';
		return true;
	}
	
	//変数がNULLでなきかどうかを判定する
	if(isset($var)){
		//echo '変数$varには値がセットされています';
		return true;
	}
}






