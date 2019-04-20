<?php
session_start();
require_once './config.php';
require_once './function.php';
header("content-type:text/html;charset=utf-8");
// var_dump($_SESSION);
$user_id=$_SESSION['mem_id'];
echo $user_id;
?>
<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>collectown</title>
<!-- <link rel="stylesheet" type="text/css" href="./css/styles.css">
<link rel="stylesheet" type="text/css" href="./css/style.css" /> -->
<link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
<!-- <link rel="stylesheet" type="text/css" href="./css/common.css"> -->
<link rel="stylesheet" type="text/css" href="./css/side_nav2.css">
<link href="./css/home.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="./js/jquery.js"></script>
<script type="text/javascript" src="./js/jquery.min.js"></script>
<!-- <script type="text/javascript" src="./js/current.js"></script> -->
<script type="text/javascript">
var user_id=<?php echo $user_id ?>;
// var user_id=$('#admin').val();
var friend_id="50";
// var url ="./getmessage.php";

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
      var message_str = '';
      message_str += '<li>' + res.friend_id + '   ' + res.time + '<br/>' + res.content + '</li>';
      $('#msgbox').append(message_str);
      // $.ajax(setting);
      window.setTimeout(function(){$.ajax(setting)},1000);
    }
  };
  $.ajax(setting);
});
// $(function(){
//   get_message_reply(url, friend_id, user_id, 'get_message', '');
// });
// function get_message_reply(url, friend_id, user_id, request_type, send_data) {
//   var setting = {
//     url: url,
//     data: {
//       'request_type': request_type,
//       'friend_id': friend_id,
//       'user_id': user_id,
//       'send_data': send_data,
//     },
//     type: 'post',
//     dataType: 'json',
//     success: function (response) {
//       if (response.flag == 1) {
//         // alert('ok');
//         if (response.response_type == 'is_read') {
//           var messages = response.info;
//           var message_str = '';
//           var id_arr = new Array();
//           for (var i in messages) {
//               id_arr.push(messages[i]['dm_id']);
//               message_str += '<li>' + messages[i]['friend_id'] + '   ' + messages[i]['time'] + '<br/>' + messages[i]['content'] + '</li>';
//           }
//           alert(id_arr);
//           $('#msgbox').append(message_str);
//           get_message_reply(url, friend_id, user_id, 'comfrim_read', id_arr);
//
//         } else if (response.response_type == 'is_connecting') {
//           get_message_reply(url, friend_id, user_id, 'get_message', '');
//         }
//       }
//     }
//   };
//   $.ajax(setting);
// }
</script>
</script>
</head>
<body>
	<header>
		<?php //require_once './tmp/header.php'; ?>
		<a href="./personal_page/index.php">go</a>
	</header>
	<div class="wrapper">

		<?php //require_once './tmp/side_nav.php'; ?>

    <div id="msgbox" style="width:500px; height:400px; background-color:blue; "></div>
    <div>
    <textarea id="msg"></textarea>
    <button id="send">発信</button>
    </div>

	</div><!-- wrapperここまで -->

	<div><input type="hidden" id="admin" name="admin" value="<?php echo $user_id;?>"></div>
  <script type="text/javascript">
  $(function(){
    var user_id=<?php echo $user_id ?>;
    // var user_id=$('#admin').val();
    var friend_id="50";
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
          var send_message_str = '<li style="text-align: right;padding-right: 10px;">';
          send_message_str += 'あなたは' + send_data.friend_id + 'に：<br/>' + send_data.msg;
          send_message_str += '</li>';
          $('#msgbox').append(send_message_str);
        }else {
            console.log('发送失败!！');
        }
      },'json');
    }
    });
  });

  </script>
</body>


</div>
</html>
