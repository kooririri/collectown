<?php
session_start();
// var_dump($_SESSION);
require_once './config.php';
require_once './function.php';
header("content-type:text/html;charset=utf-8");
if(isset($_GET['search'])&&!empty($_GET['search'])){
  $keyword=$_GET['search'];
  // echo $keyword;


  $link=mysqli_connect(HOST,DB_USER,DB_PASS,DB_NAME);
  if(!$link){
    return false;
  }
  mysqli_set_charset($link , 'utf8');

  //条件初期化
  $con_sql="";
  $con_sql1="";
  $con_sql2="";
  //絞り選択すると
  if(isset($_GET)&&!empty($_GET)){
    if(isset($_GET['gen_id'])&&$_GET['gen_id']!=""){
      $gen_id=$_GET['gen_id'];
      $con_sql=" AND genre.gen_id = {$gen_id} ";
    }
    else{
      $con_sql="";
    }
    if(isset($_GET['price'])&&$_GET['price']!=""){
      $price=$_GET['price'];
      switch ($price){
        case 1:
          $con_sql1=" AND ra_content.ra_price <=1000";
          break;
        case 2:
          $con_sql1=" AND ra_content.ra_price >=1001 AND ra_content.ra_price <=5000";
          break;
        case 3:
          $con_sql1=" AND ra_content.ra_price >=5001 AND ra_content.ra_price <=10000";
          break;
        case 4:
          $con_sql1=" AND ra_content.ra_price >=10001 AND ra_content.ra_price <=50000";
          break;
        case 5:
          $con_sql1=" AND ra_content.ra_price >=50001";
          break;
      }
    }
    else{
      $con_sql1="";
    }
    if(isset($_GET['order'])&&$_GET['order']!=""){
      $order=$_GET['order'];
      if($order=="ASC"){
        $con_sql2="     ORDER BY deadline ASC";
      }
      elseif($order=="DESC"){
        $con_sql2="     ORDER BY deadline DESC";
      }
    }
    else{
      $con_sql2="";
    }
  }

  $con=$con_sql.$con_sql1;
  if(isset($_SESSION)&&!empty($_SESSION)){//ログインの場合
    $logined_id=$_SESSION['mem_id'];
      $sql="SELECT * FROM (ra_content INNER JOIN genre ON ra_content.gen_id = genre.gen_id )INNER JOIN ra_demand ON ra_content.ra_id = ra_demand.ra_id WHERE  ra_demand.mem_id !='{$logined_id}' $con AND (ra_content.introduction LIKE '%".$keyword."%' OR ra_content.ra_name LIKE '%".$keyword."%') $con_sql2";
    // echo $sql;
  }
  else{
    if(isset($_GET)&&!empty($_GET)){//ログインしなくて絞り込み時場合
      if(isset($_GET['price'])||isset($_GET['gen_id'])){//値段或はジャンルで絞り込み時
        $con="WHERE".substr($con,4);
      }
      else{
        $con=substr($con,4);
      }
    }
    else{//絞り込みしない時
      $con=$con;
    }
    // echo $con;
    $sql="SELECT * FROM (ra_content INNER JOIN genre ON ra_content.gen_id = genre.gen_id )INNER JOIN ra_demand ON ra_content.ra_id = ra_demand.ra_id {$con} AND (ra_content.introduction LIKE '%".$keyword."%' OR ra_content.ra_name LIKE '%".$keyword."%') $con_sql2";
    // echo $sql;
  }
  $query_cont=mysqli_query($link,$sql);
  $row=array();
  while($a=mysqli_fetch_assoc($query_cont)){
    $row[]=$a;
  }
  // var_dump($row);
  for($i=0;$i<count($row);$i++){//投稿の詳細を取り出す
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

    $mem_id=$row[$i]['mem_id'];
    $sql_mem="SELECT nick,img_id as pro_pic_id FROM member_info WHERE mem_id =".$mem_id;
    $query_mem=mysqli_query($link,$sql_mem);
    $re_mem=mysqli_fetch_assoc($query_mem);
    $pro_pic_id=$re_mem['pro_pic_id'];
    $nick=$re_mem['nick'];
    if($nick==''){
      $row[$i]['nick']=$row[$i]['mem_id']."さん";
    }
    else{
      $row[$i]['nick']=$nick;
    }
    // $row[$i]['nick']=$re_mem['nick'];


    if($pro_pic_id==''){
      $row[$i]['pro_pic_add']="./images/profile_images/no_img.png";
    }
    else{
      $sql_mem_pic="SELECT img_add FROM images WHERE img_id = ".$pro_pic_id;
      $query_mem_pic=mysqli_query($link,$sql_mem_pic);
      $re_mem_pic=mysqli_fetch_assoc($query_mem_pic);
      $row[$i]['pro_pic_add']=$re_mem_pic['img_add'];
    }
  }
  $data=$row;
  //ジャンルを取り出す
  $sql_genre="SELECT * FROM genre";
  $query_cont=mysqli_query($link,$sql_genre);
  $genre_arr=array();
  while($b=mysqli_fetch_assoc($query_cont)){
    $genre_arr[]=$b;
  }
  // var_dump($genre_arr);
    // var_dump($data);

  //入札最低値段を取り出す。
  $sql_bid="SELECT ra_id,MIN(bid_price) FROM ra_application GROUP BY ra_id ";
  $query_bid=mysqli_query($link,$sql_bid);
  $row1=array();
  while($a=mysqli_fetch_assoc($query_bid)){
    $row1[]=$a;
  }
  // var_dump($row1);
  require_once './tmp/search_output.php';
}
else{
  echo "<script type='text/javascript'>alert('キーワードを入力してください');</script>";
  header("refresh:1;url=./index.php");
}


?>
