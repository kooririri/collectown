<?php
session_start();
require_once './config.php';
require_once './function.php';
header("content-type:text/html;charset=utf-8");
// var_dump($_SESSION);

if(isset($_POST['send'])&&!empty($_POST['send'])&&isset($_SESSION)&&!empty($_SESSION)&&isset($_FILES)&&!empty($_FILES)){
  $ra_id=rand(10000,99999)+time();
  $mem_id=$_SESSION['mem_id'];
  $name=$_POST['name'];
  $price=$_POST['price'];
  $genre_id=$_POST['genre'];
  $time=$_POST['acting_time'];
  $intr=$_POST['intr'];
  $deadline=date("Y-m-d H:i:s",time()+$time*24*60*60);
  $sql1="INSERT INTO ra_demand(ra_id,mem_id)VALUES('".$ra_id."','".$mem_id."')";
  $link=mysqli_connect(HOST,DB_USER,DB_PASS,DB_NAME);
  if(!$link){
    return false;
  }
  mysqli_set_charset($link , 'utf8');
  //imgのIDをつける
  $query_id=mysqli_query($link,"select max(img_id) as 'maxid' from images ");
  $id_input=mysqli_fetch_assoc($query_id);
  if($id_input['maxid']>=1){
    $id_input['maxid']++;
    $img_id=$id_input['maxid'];
  }
  else{
    $img_id=1;
  }
  $sql="INSERT INTO ra_content(ra_id,gen_id,ra_name,ra_price,introduction,ra_time,deadline,img_id,end_flag)VALUES('".$ra_id."','".$genre_id."','".$name."','".$price."','".$intr."','".$time."','".$deadline."','".$img_id."',0)";
  mysqli_query($link,$sql);
  mysqli_query($link,$sql1);
  $arr=$_FILES["file"];
  if($arr["type"]=="image/jpeg" || $arr["type"]=="image/png" && $arr["size"]<=1024000){
  $arr["tmp_name"];
  $filename="./images/acting_images/".time().$arr["name"];
    if(file_exists($filename)){ echo "もう一回試してください";}
    else{
    $filename=iconv("UTF-8","gb2312",$filename);
    move_uploaded_file($arr["tmp_name"],$filename);
    $sql2="INSERT INTO images(img_id,img_add)VALUES('".$img_id."','".$filename."')";
    mysqli_query($link,$sql2);
    }
  }
  else{
    echo "画像を選択してください";
    header('location:./acting_demand.php');
  }
  header('location:./index.php');
}



  // elseif(isset($_SESSION)&&!empty($_SESSION)){
  //   $_SESSION = array();
  //   if (isset($_COOKIE[session_name()])) {
  //       setcookie(session_name(), '', time()-42000, '/');
  //   }
  //   session_destroy();
  //   header('location:./home.php');
  // }
  // else{
  //   header('location:./home.php');
  // }
?>
