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
$sql_get="SELECT * FROM ra_demand INNER JOIN ra_content ON ra_demand.ra_id = ra_content.ra_id WHERE ra_demand.mem_id = ".$mem_id." AND ra_demand.flag = 1 limit 1";
while(true){
  $query_get=mysqli_query($link,$sql_get);
  $res_get=mysqli_fetch_assoc($query_get);
  if(!empty($res_get)){
    echo json_encode($res_get);
    $sql_change="UPDATE ra_demand SET flag = 0 WHERE ra_id = ".$res_get['ra_id'];
    mysqli_query($link,$sql_change);
    mysqli_close($link);
    exit();
  }
  else{
    $res='{"ra_id":0}';
    echo $res;
    sleep(2);
    exit();
  }

}

?>
