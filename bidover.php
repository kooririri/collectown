<?php
set_time_limit(0);
require_once './config.php';
require_once './function.php';
$mem_id=$_POST['mem_id'];
$link=mysqli_connect(HOST,DB_USER,DB_PASS,DB_NAME);
if(!$link){
  return false;
}
mysqli_set_charset($link , 'utf8');
$sql_get="SELECT * FROM ra_application  WHERE mem_id = ".$mem_id." AND cancel_flag = 2 limit 1";
while(true){
  $query_get=mysqli_query($link,$sql_get);
  $res_get=mysqli_fetch_assoc($query_get);
  if(!empty($res_get)){
    $sql_change="UPDATE ra_application SET cancel_flag = 3 WHERE ra_id = ".$res_get['ra_id']." AND mem_id = ".$res_get['mem_id']." AND lineorder = ".$res_get['lineorder'];
    mysqli_query($link,$sql_change);
    echo json_encode($res_get);
    mysqli_close($link);
    exit();
  }
  else{
    $res='{"ra_id":0}';
    echo $res;
    sleep(5);
    exit();
  }

}

?>
