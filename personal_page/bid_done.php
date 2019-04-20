<?php
session_start();
header("Content-Type: text/html;charset=utf-8");
require_once './config.php';
require_once './function.php';
var_dump($_SESSION);
var_dump($_POST);
if(isset($_POST['bid_send'])&&!empty($_POST['bid_send'])&&isset($_SESSION)&&!empty($_SESSION)){
  $mem_id=$_SESSION['mem_id'];
  $ra_id=$_POST['ra_id'];
  $bid_price=$_POST['bid_price'];
  $link=mysqli_connect(HOST,DB_USER,DB_PASS,DB_NAME);
  if(!$link){
    return false;
  }
  echo $ra_id;
  mysqli_set_charset($link , 'utf8');
  $sql="SELECT max(lineorder) AS 'maxorder' FROM ra_application ";
  $sql="SELECT max(lineorder) AS 'maxorder' FROM ra_application WHERE ra_id =".$ra_id;
  $query_maxorder=mysqli_query($link,$sql);
  $order_input=mysqli_fetch_assoc($query_maxorder);
  if($order_input['maxorder']>=1){
    $order_input['maxorder']++;
    $lineorder=$order_input['maxorder'];
  }
  else{
    $lineorder=1;
  }
  //ra_applicationで今まで受取者のcancel_flag状態を2に変更　0:通常受け取っている状態　1:自分でキャンセルした状態　2：新受取者の入札ため、キャンセルされた状態
  $sql_max="SELECT MAX(lineorder) AS max_num FROM ra_application WHERE ra_id = ".$ra_id;
  $res_max=mysqli_fetch_assoc(mysqli_query($link,$sql_max));
  // var_dump($res_max);
  // echo $res_max['max_num'];
  if(!empty($res_max)){
    $max_num=$res_max['max_num'];
    $sql_cancel="UPDATE ra_application SET cancel_flag = 2 WHERE ra_id = ".$ra_id." AND lineorder = ".$max_num;
    mysqli_query($link,$sql_cancel);
  }

  $sql="INSERT INTO ra_application(ra_id,mem_id,bid_price,lineorder,cancel_flag)VALUES('".$ra_id."','".$mem_id."','".$bid_price."','".$lineorder."',0)";
  //ra_demandのflag状態を変更　0:変更なし、メッセージ要らない　1：変更ある、メッセージポップする。
  $sql_flag="UPDATE ra_demand SET flag = 1 WHERE ra_id = ".$ra_id;
  mysqli_query($link,$sql_flag);

  //ra_contentのbid_numを取り出す。
  $sql_bidnum="SELECT bid_num FROM ra_content WHERE ra_id=".$ra_id;
  $query_bidnum=mysqli_query($link,$sql_bidnum);
  $res_bidnum=mysqli_fetch_assoc($query_bidnum);
  $bid_numNew=$res_bidnum['bid_num']+1;
  mysqli_query($link,$sql);
  $sql1="UPDATE ra_content SET bid_num = ".$bid_numNew." WHERE ra_id = ".$ra_id;
  mysqli_query($link,$sql1);


  mysqli_close($link);
  header("refresh:5;url=./index.php");
  print('ご入札ありがとうございます。5秒後ホームページに戻ります。');
}
else{
  header("refresh:5;url=./index.php");
  print('エラー。5秒後ホームページに戻ります。');
}
?>
