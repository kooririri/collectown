<?php
set_time_limit(0);
require_once './config.php';
require_once './function.php';
$friend_id=$_POST['friend_id'];
$user_id=$_POST['user_id'];
$link=mysqli_connect(HOST,DB_USER,DB_PASS,DB_NAME);
if (!$link) {
    printf("Can't connect to MySQL Server. Errorcode: %s ", mysqli_connect_error());
    exit;
}
$sql="SELECT * FROM dm WHERE receiver_id = '$user_id' AND flag = 1 limit 1";
while(true){
  $row=mysqli_fetch_assoc(mysqli_query($link,$sql));
  if(!empty($row)){
    $sql_change="UPDATE dm SET flag = 2 WHERE dm_id = ".$row['dm_id'];
    mysqli_query($link,$sql_change);
    echo json_encode($row);
    mysqli_close($link);
    exit();
  }
  else{
    $res='{"dm_id":0}';
    echo $res;
    sleep(2);
    exit();
  }


}
// set_time_limit(0);
// $maxInvalidCount = 10;
// $friend_id=$_POST['friend_id'];
// $user_id=$_POST['user_id'];
// $link=mysqli_connect(HOST,DB_USER,DB_PASS,DB_NAME);
// if (!$link) {
//     printf("Can't connect to MySQL Server. Errorcode: %s ", mysqli_connect_error());
//     exit;
// }
// if (mysqli_connect_errno()) {
//     echo mysqli_connect_error();
// }
// $requestType = $_POST['request_type'];
// switch ($requestType) {
//     case 'get_message'://ローリングの場合
//         break;
//     case 'comfrim_read'://客户端确认已经读取了信息,服务端需要更新读取状态
//         $idsArr = $_POST['send_data'];
//         $ids = implode(',', $idsArr);
//         $sql = "update dm set flag = 2 where dm_id in ({$ids})";
//         mysqli_query($link, $sql);
//         mysqli_close($link);
//         break;
//     default:
//         break;
// }
// $sql = "select * from dm where friend_id='{$_POST['friend_id']}' and user_id='{$_POST['user_id']}' and flag='1'";
// // $sql = "SELECT * FROM dm WHERE friend_id = ".$friend_id."AND user_id =".$user_id."AND flag=0";
// $i = 0;
// while (true) {
//     //读取数据
//     $result = mysqli_query($link, $sql);
//     if ($result) {
//         $returnArr = [];
//         while ($row = mysqli_fetch_assoc($result)) {
//             // $row['send_time'] = date('Y-m-d H:i:s', $row['create_time']);
//             $returnArr[] = $row;
//         }
//         if (!empty($returnArr)) {
//             //返回结果
//             $data = [
//                 'flag' => 1,
//                 'response_type' => 'is_read',
//                 'info' => $returnArr,
//             ];
//             echo json_encode($data);
//             mysqli_free_result($result);
//             mysqli_close($link);
//             exit();
//         }
//     }
//     $i++;
//     //需要给客户端发送确认信息是否还在连接服务器,客户端无回应则整个过程结束
//     if ($i == $maxInvalidCount) {
//         $data = [
//             'flag' => 1,
//             'response_type' => 'is_connecting',
//             'info' => '',
//         ];
//         echo json_encode($data);
//         mysqli_close($link);
//         exit();
//     }
//     //file_put_contents('./test.log', date('Y-m-d H:i:s') . "已经执行了{$i}次" . "\r\n", FILE_APPEND);
//     sleep(1);
// }
