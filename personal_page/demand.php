<?php
session_start();
require_once '../config.php';
require_once '../function.php';
// var_dump($_SESSION);
if(isset($_SESSION['mem_id'])&&!empty($_SESSION['mem_id'])){
  $logined_id=$_SESSION['mem_id'];
  $link=mysqli_connect(HOST,DB_USER,DB_PASS,DB_NAME);
  if(!$link){
    return false;
  }
  mysqli_set_charset($link , 'utf8');

  // $sql="SELECT * FROM (ra_content LEFT OUTER JOIN ra_demand ON ra_content.ra_id = ra_demand.ra_id) LEFT OUTER JOIN ra_application ON ra_content.ra_id = ra_application.ra_id WHERE ra_demand.mem_id ='".$logined_id."'";
  $sql="SELECT * FROM ra_content INNER JOIN ra_demand ON ra_content.ra_id = ra_demand.ra_id WHERE ra_content.end_flag=0 AND ra_demand.mem_id ='".$logined_id."'";
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
  // var_dump($row);
  $sql_num="SELECT COUNT(*) FROM ra_demand WHERE mem_id =".$logined_id;
  $num=mysqli_fetch_assoc(mysqli_query($link,$sql_num));
  $n=$num['COUNT(*)'];
  // echo $n;

  // $sql_bidprice="SELECT *,MIN(bid_price) FROM ra_demand LEFT OUTER JOIN ra_application ON ra_demand.ra_id = ra_application.ra_id GROUP BY ra_application.ra_id HAVING ra_application.cancel_flag =0 AND ra_demand.mem_id =".$logined_id;
  // // $sql_bidprice="SELECT * FROM ra_demand LEFT OUTER JOIN ra_application ON ra_demand.ra_id=ra_application.ra_id WHERE ra_application.cancel_flag=0 ";
  // $query_bidprice=mysqli_query($link,$sql_bidprice);
  // $row_bidprice=array();
  // while($b=mysqli_fetch_assoc($query_bidprice)){
  //   $row_bidprice[]=$b;
  // }
  // for($i=count($row_bidprice);$i<$n;$i++){
  //   $row_bidprice[$i]['MIN(bid_price)']='未定';
  // }
  //
  // // var_dump($row);
  // var_dump($row_bidprice);
mysqli_close($link);
// var_dump($row);
}


?>

<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="UTF-8">
		<title>collectown</title>
		 <link rel="stylesheet" href="css/amazeui.min.css" />
		  <link rel="stylesheet" href="css/admin.css" />
			<!--   Core JS Files   -->
			<script src="js/jquery-3.1.0.min.js" type="text/javascript"></script>
			<script src="js/bootstrap.min.js" type="text/javascript"></script>
			<script src="js/material.min.js" type="text/javascript"></script>

			<!--  Charts Plugin -->
			<script src="js/chartist.min.js"></script>
			<script src="js/material-dashboard.js"></script>
			<script type="text/javascript" src="myplugs/js/plugs.js"></script>
	</head>
	<body>

		<div class="admin-content-body">
      <div class="am-cf am-padding am-padding-bottom-0">
        <div class="am-fl am-cf">
          <strong class="am-text-primary am-text-lg">お求め物</strong>
        </div>
      </div>

      <hr>

      <ul class="am-avg-sm-2 am-avg-md-4 am-avg-lg-6 am-margin gallery-list">
				<?php
	      for($i=0;$i<count($row);$i++){
				?>
					<li>
						<a href="javascript:void(0)" onclick="updatePwd('お求め物',5,'./demand_content.php?ra_id=<?php echo $row[$i]['ra_id']; ?>')">
							<div class="ra_pic" style="width:180px; height:140px;">
								<img class="am-img-thumbnail am-img-bdrs" src="<?php echo "../".$row[$i]['img_add']; ?>" style="width:180px; height:140px;">
							</div>
              <div class="ra_name">
              <p class="demand_ttl"><?php echo $row[$i]['ra_name']; ?></p>
              </div><!-- ra_nameここまで -->

              <div class="ra_time">
              <p class="de_btm">登録日<br>
                <span><?php  echo $row[$i]['start_time']; ?></span></p>
              </div><!-- ra_time -->

              <div class="ra_price">
                <p class="de_btm">希望価格<br>
                <span><?php echo num($row[$i]['ra_price']),"円"; ?></span></p>
              </div><!-- ra_priceここまで -->

              <!-- <div class="bid_price">
                <p class="de_btm">引き受け予定価格<br>
                <span><?php
                    // echo $row_bidprice[$i]['MIN(bid_price)'];
                   ?>
                </span></p>
              </div> -->

              <div class="num">
              <p class="de_btm">引き受け応募人数<br>
              <span><?php echo $row[$i]['bid_num'],"人"; ?></span>
              </p>
              </div>
            </a>
            </li>
            <?php } ?>
              </ul>
      <script type="text/javascript">
          //添加编辑弹出层
          function updatePwd(title,id,url) {
            $.jq_Panel({
              title: title,
              iframeWidth: 700,
              iframeHeight: 500,
              url: url
            });
          }
        </script>

    </div>
	</body>


</html>
