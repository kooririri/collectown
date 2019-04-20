<?php
session_start();
// var_dump($_SESSION);
require_once '../config.php';
require_once '../function.php';
header("content-type:text/html;charset=utf-8");
$user_id=$_SESSION['mem_id'];

$link=mysqli_connect(HOST,DB_USER,DB_PASS,DB_NAME);
if (!$link) {
    printf("Can't connect to MySQL Server. Errorcode: %s ", mysqli_connect_error());
    exit;
}
$sql="SELECT * FROM dm WHERE receiver_id = ".$user_id." GROUP BY sender_id ORDER BY sender_id desc";
$query=mysqli_query($link,$sql);
$row=array();
while($a=mysqli_fetch_assoc($query)){
  $row[]=$a;
}
for($i=0;$i<count($row);$i++){
  $row[$i]['data-chat']="person".($i+1);
}

// $sql1="SELECT * FROM dm WHERE receiver_id = ".$user_id." OR sender_id=".$user_id." ORDER BY time asc";
// $query1=mysqli_query($link,$sql1);
// $row1=array();
// while($a=mysqli_fetch_assoc($query1)){
//   $row1[]=$a;
// }
// for($i=0;$i<count($row1);$i++){
//   $row1[$i]['data-chat']="person".($i+1);
// }
// var_dump($row1);

?>
<!DOCTYPE html>
<html lang="en" >

<head>
<meta charset="UTF-8">
<title>Direct Messaging</title>

<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/reset.min.css">
<link rel="stylesheet" href="css/style.css">
<style>
.person{
  height:60px;
}

</style>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript">
var user_id=<?php echo $user_id ?>;
// var user_id=$('#admin').val();

// var url ="./getmessage.php";
friend_id = "<?php if(count($row)>=2){echo $row[1]['sender_id'];}else{echo "";}  ?>";
function get_receiver(reply){
  friend_id=reply;
  // alert(friend_id);
  // var plusperson = '';
  // plusperson += '<div class="person">' + '<img src="./img/no_img.png" alt="" />' + '<span class="name">'+ friend_id +'</span>' + '</div>';
  // $('.people').html(plusperson);
}

$(function(){
  var setting = {
    url:'./getmessage.php',
    data:{
      'friend_id': friend_id,
      'user_id': user_id,
    },
    type:'post',
    dataType:'json',
    success:function(res){
      // var plusperson = '';
      // plusperson += '<div class="person">' + '<img src="../img/no_img.png" alt="" />' + '<span class="name">'+ res.sender_id +'</span>' + '</div>';
      // $('.people').append(plusperson);

      if(res.dm_id!=0){
        var message_str = '';
        message_str += '<div class="bubble you">' + res.content + '</div>';
        $('.chat').append(message_str);
        // $.ajax(setting);
        window.setTimeout(function(){$.ajax(setting)},1000);
      }
      else{
        window.setTimeout(function(){$.ajax(setting)},1000);
      }
    }
  };
  $.ajax(setting);
});
</script>
</head>

<body>

  <div class="wrapper">
    <div class="container">
        <div class="left" style="overflow-y:scroll;">
            <div class="top">
                <input type="text" placeholder="Search" />
                <!-- <a href="javascript:;" class="search"></a> -->
            </div>
            <ul class="people">
              <?php
              foreach ($row as $key => $value) {?>
                  <li class="person" data-chat="<?php echo $value['data-chat']; ?>" onclick="get_receiver(<?php echo $value['sender_id']; ?>)">
                    <img src="../images/profile_images/no_img.png" alt="" />
                    <span class="name"><?php echo $value['sender_id']; ?></span>
                  </li>
              <?php
              }
              ?>


            </ul>
        </div>
        <div class="right">
            <div class="top"><span>To: <span class="name"><?php if(count($row)>=2)echo $row[1]['sender_id']; ?></span></span></div>
            <?php
            foreach ($row as $key => $value) {?>
                <div class="chat" data-chat="<?php echo $value['data-chat']; ?>" id="<?php echo $key; ?>">
                  <div class="conversation-start">
                      <span><?php echo date("Y-m-d h:i:sa",time()); ?></span>
                  </div>
                  <?php
                  $sqlx="SELECT * FROM dm WHERE sender_id = ".$value['sender_id']." AND receiver_id = ".$user_id." OR sender_id = ".$user_id." AND receiver_id = ".$value['sender_id']." AND flag=2";
                  $queryx=mysqli_query($link,$sqlx);
                  $rowx=array();
                  while($a=mysqli_fetch_assoc($queryx)){
                    $rowx[]=$a;
                  }
                  foreach ($rowx as $key => $value){
                    if($value['sender_id']==$user_id){?>
                      <div class="bubble me">
                          <?php echo $value['content']; ?>
                      </div>
                  <?php  }
                    elseif($value['receiver_id']==$user_id){?>
                      <div class="bubble you">
                          <?php echo $value['content']; ?>
                      </div>
                      <?php
                    }

                  }
                  ?>
                </div>
            <?php
            }
            ?>
            <!-- <div class="chat" data-chat="person1">
                <div class="conversation-start">
                    <span>Today, 6:48 AM</span>
                </div>
                <div class="bubble you">
                    Hello,
                </div>
                <div class="bubble you">
                    it's me.
                </div>
                <div class="bubble you">
                    I was wondering...
                </div>
                <div class="bubble me">
                    I was wondering...
                </div>
            </div>
            <div class="chat" data-chat="person2">
                <div class="conversation-start">
                    <span><?php echo date("Y-m-d H:i:s"); ?></span>
                </div>

            </div>
            <div class="chat" data-chat="person3">
                <div class="conversation-start">
                    <span>Today, 3:38 AM</span>
                </div>
                <div class="bubble you">
                    Hey human!
                </div>
                <div class="bubble you">
                    Umm... Someone took a shit in the hallway.
                </div>
                <div class="bubble me">
                    ... what.
                </div>
                <div class="bubble me">
                    Are you serious?
                </div>
                <div class="bubble you">
                    I mean...
                </div>
                <div class="bubble you">
                    It’s not that bad...
                </div>
                <div class="bubble you">
                    But we’re probably gonna need a new carpet.
                </div>
            </div>
            <div class="chat" data-chat="person4">
                <div class="conversation-start">
                    <span>Yesterday, 4:20 PM</span>
                </div>
                <div class="bubble me">
                    Hey human!
                </div>
                <div class="bubble me">
                    Umm... Someone took a shit in the hallway.
                </div>
                <div class="bubble you">
                    ... what.
                </div>
                <div class="bubble you">
                    Are you serious?
                </div>
                <div class="bubble me">
                    I mean...
                </div>
                <div class="bubble me">
                    It’s not that bad...
                </div>
            </div>
            <div class="chat" data-chat="person5">
                <div class="conversation-start">
                    <span>Today, 6:28 AM</span>
                </div>
                <div class="bubble you">
                    Wasup
                </div>
                <div class="bubble you">
                    Wasup
                </div>
                <div class="bubble you">
                    Wasup for the third time like is <br />you blind bitch
                </div>

            </div>
            <div class="chat" data-chat="person6">
                <div class="conversation-start">
                    <span>Monday, 1:27 PM</span>
                </div>
                <div class="bubble you">
                    So, how's your new phone?
                </div>
                <div class="bubble you">
                    You finally have a smartphone :D
                </div>
                <div class="bubble me">
                    Drake?
                </div>
                <div class="bubble me">
                    Why aren't you answering?
                </div>
                <div class="bubble you">
                    howdoyoudoaspace
                </div>
            </div> -->
            <div class="write">
                <a href="javascript:;" class="write-link attach"></a>
                <input type="text" id="msg">
                <a href="javascript:;" class="write-link smiley"></a>
                <a href="javascript:;" class="write-link send" id="send"></a>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
$(function(){
  var user_id=<?php echo $user_id ?>;
  // var user_id=$('#admin').val();

  $('#send').click(function(){
    var msg=$('#msg').val();
    if(msg!=''){
      $(this).attr('disabled', 'disabled');

    var send_url="./sendmessage.php";
    var send_data={
      'user_id':user_id,
      'friend_id':friend_id,
      'msg':msg,
    }
    $.post(send_url,send_data,function(res){
      if(res.flag==1){
        $('#msg').val('');
        $('#send').removeAttr('disabled');
        var send_message_str = '<div class="bubble me">';
        send_message_str += send_data.msg;
        send_message_str += '</div>';
        $('.chat').append(send_message_str);
      }else {
          console.log('もう一回試してください!！');
      }
    },'json');
  }
  });
});

</script>
<script  src="js/index.js"></script>




</body>

</html>
