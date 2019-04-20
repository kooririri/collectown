<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>COLLECTOWN</title>
<link rel="stylesheet" type="text/css" href="font_Icon/iconfont.css">
<link rel="stylesheet" type="text/css" href="css/chat.css">
<link rel="stylesheet" href="css/reset.min.css">
<link rel="stylesheet" href="css/dmstyle.css">
<link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
<link rel="stylesheet" type="text/css" href="./css/home.css"/>
<!-- <link rel="stylesheet" type="text/css" href="./css/side_nav2.css"/> -->
<!-- <link rel="stylesheet" type="text/css" href="./css/home2.css"/> -->
<!-- <link rel="stylesheet" type="text/css" href="./css/top.css"/> -->
<link rel="stylesheet" type="text/css" href="./css/search_output.css">

<style type="text/css">
.fl{ float:left}
.fr{ float:right; margin-top:10px; cursor: pointer;}
.dingwe{ position:relative;}
.tipfloat{display:none;z-index:999;border:1px #8e9cde solid; position:fixed; bottom:0px; right:17px;width:388px;height:268px; background:#fff}
.tipfloat_bt{ height:49px; line-height:49px;background:#8e9cde; padding:0px 20px; font-size:18px; color:#fff; }
.xx_nrong{font-size:18px; color:#333; text-align:center; padding:30px 0; line-height:26px; }
.xx_nrong span{
  color:red;
}
.xx_nrong a{
  color:red;
}
</style>

<script type="text/javascript" src="./js/jquery.js"></script>
<script type="text/javascript" src="./js/jquery.min.js"></script>
<script type="text/javascript" src="./js/current.js"></script>
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript">
function tankuan(){
        $(".tipfloat").animate({height:"show"},800);
        $(".close").click(function(){
            $(".tipfloat").animate({height:"hide"},800);
        });
}


var user_id=<?php echo $_SESSION['mem_id'] ?>;
$(function(){
  var setting = {
    url:'./application_status.php',
    data:{
			'mem_id':user_id,
    },
    type:'post',
    dataType:'json',
    success:function(res){
      if(res.ra_id!=0){
        var message_str = '';
        message_str += '<div>' + '代行依頼　「<span>' + res.ra_name + '</span>」　に対し、代行引き受け応募がありました<br><a href=\'personal_page/index.php\'>マイページ</a>にて詳細情報を確認できます' + '</div>';
        $('.xx_nrong').html(message_str);
        tankuan();
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


friend_id = "";
function get_receiver(reply){
  friend_id=reply;
  var plusperson = '';
  plusperson += '<div class="person">' + '<img src="./img/no_img.png" alt="" />' + '<span class="name">'+ friend_id +'</span>' + '</div>';
  $('.people').html(plusperson);
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
      // plusperson += '<div class="person">' + '<img src="./img/no_img.png" alt="" />' + '<span class="name">'+ res.sender_id +'</span>' + '</div>';
      // $('.people').append(plusperson);
      // alert(res.content);
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
    // error:function(){
    //   $.ajax(setting);
    // }
  };
  $.ajax(setting);
});




//
// $(function(){
//   $(".person").each(function(){
//     var a=$(this).html();
//     alert(a);
//     // alert($(this).html());
//   });
// });

</script>


</head>
<body>
	<header>
		<?php require_once './tmp/header.php'; ?>
	</header>
	<div class="wrapper">

		<?php require_once './tmp/side_nav.php'; ?>





		<div id="maincont">
			<div id="index">
				<a id="state" href="./personal_page/index.php"></a>
				<dl class="cation-list">
						<dt>ジャンル</dt>
						<dd>
							<a href="#" rel="" name="gen_id" class="all on">全て</a>
							<?php
							for($i=0;$i<count($genre_arr);$i++){?>
								<a href="#" rel="<?php echo $genre_arr[$i]['gen_id']; ?>" name="gen_id" class="default"><?php echo $genre_arr[$i]['gen_name']; ?></a>
							<?php
							} ?>
						</dd>
				</dl>
				<dl class="cation-list">
						<dt>値　段</dt>
						<dd>
              <a href="#" rel="" name="price" class="all on">全て</a>
              <a href="#" rel="1" name="price" class="default">0 ~ 1,000円</a>
              <a href="#" rel="2" name="price" class="default">1,001 ~ 5,000円</a>
              <a href="#" rel="3" name="price" class="default">5,001~10,000円</a>
              <a href="#" rel="4" name="price" class="default">10,001~50,000円</a>
              <a href="#" rel="5" name="price" class="default">50,001円 ~ 上限なし</a>
						</dd>
				</dl>
				<dl class="cation-list">
						<dt>期　限</dt>
						<dd>
              <a href="#" rel="" name="order" class="all on">全て</a>
              <a href="#" rel="ASC" name="order" class="default">新着順</a>
  						<a href="#" rel="DESC" name="order" class="default">登録順</a>
						</dd>
				</dl>

<script type="text/javascript">
		$(function(){
				new SelectTag({
						child : ".default", //所有默认
						over : 'on', //当前选中
						all : ".all" // 默认全部
				});
		})
</script>
			</div>
      <div class="sub_cont">
  		<?php
  			for($i=0;$i<count($data);$i++){
  		?>
  				<div class="contents2">
  					<div class="img_wrap2">
  						　<a href="./reverse_auction.php?ra_id=<?php echo $data[$i]['ra_id']; ?>">
  							<img class="ra_pic2" src="<?php echo $data[$i]['img_add']; ?>" alt="image">
  						</a>
  					</div><!-- img_wrap2ここまで -->


  					<!-- <a class="chatBtn" href="javascript:void(0)" rel="<?php// echo $data[$i]['mem_id']; ?>" name="receiver" class="default"  style="display:block;"> -->
  					<div class="chatBtn" onclick="get_receiver(<?php echo $data[$i]['mem_id']; ?>);">
  						<div class="profile">
  							<div class="profile_pic"><img src="<?php echo $data[$i]['pro_pic_add'];?>" style="width:50px; height:50px"; ></div>
  						</div>


  						<div class="nick"><?php echo $data[$i]['nick']; ?></div>
  						<input class="user" name="user" type="hidden" value="<?php echo $data[$i]['mem_id']; ?>">
  					</div>
  				  <!-- </a> -->

  					<div class="m_con2">
  						<div class="m_wrap2">
  							<div class="ttl5">代行依頼品</div>
  							<div class="emp"><?php echo $data[$i]['ra_name']; ?></div>
  						</div>

  						<!--
  						<div class="m_wrap2">
  							<div class="ttl5">概要</div>
  							<div class="emp"><?php //echo $data[$i]['introduction']; ?></div>
  						</div><!-- m_wrapｌここまで -->


  						<div class="m_wrap2">
  							<div class="ttl5">お取引可能期限</div>
  							<div class="times" style="color: #840505;"><?php echo $data[$i]['deadline']; ?></div>
  						</div><!-- m_wrapｌここまで -->

  						<div class="m_wrap2">
  							<div class="ttl5">引き受け応募人数</div>
  							<div class="emp"><?php echo $data[$i]['bid_num']; ?>人</div>
  						</div><!-- m_wrap ｌここまで -->

  						<div class="m_wrap2">
  							<div class="ttl5">代行依頼価格</div>
  							<div class="emp"><?php echo num($data[$i]['ra_price']); ?>円</div>
  						</div><!-- m_wrapｌ ここまで -->

  						<div class="m_wrap2">
  							<div class="ttl5">引き受け応募最安値</div>
  							<div class="emp">
  							<?php
  								$msg= "応募なし";
  								foreach($row1 as $key => $val){
  									if(in_array($data[$i]['ra_id'],$val)){
  										$msg = num($val['MIN(bid_price)'])."円";
  									}
  								} echo $msg;?>
  							</div><!-- emp ここまで -->
  						</div><!-- m_wrap2 ここまで -->
  					</div><!-- m_con2 ここまで -->
  				</div><!-- contents2 -->
  				<?php } ?>
  		</div><!-- sub_cont -->


	</div>
  <!-- <iframe src="./personal_page/dm.php">asdasd </iframe> -->
	</div><!-- wrapperここまで -->
  <div class="chatBox" ref="chatBox">

    <div class="container">
      <div class="chat-close" style="margin: 10px 10px 0 0;font-size: 10px">X</div>
        <div class="left" style="overflow-y:scroll;">
            <div class="top">
                <input type="text" placeholder="Search" />
                <!-- <a href="javascript:;" class="search"></a> -->
            </div>
            <ul class="people">
              <!-- <li class="person" data-chat="person1">
                  <img src="img/thomas.jpg" alt="" />
                  <span class="name">Thomas Bangalter</span>
                  <span class="time">2:09 PM</span>
                  <span class="preview">I was wondering...</span>
              </li>
              <li class="person" data-chat="person2">
                  <img src="img/dog.png" alt="" />
                  <span class="name">Dog Woofson</span>
                  <span class="time">1:44 PM</span>
                  <span class="preview">I've forgotten how it felt before</span>
              </li>
              <li class="person" data-chat="person3">
                  <img src="img/louis-ck.jpeg" alt="" />
                  <span class="name">Louis CK</span>
                  <span class="time">2:09 PM</span>
                  <span class="preview">But we’re probably gonna need a new carpet.</span>
              </li>
              <li class="person" data-chat="person4">
                  <img src="img/bo-jackson.jpg" alt="" />
                  <span class="name">Bo Jackson</span>
                  <span class="time">2:09 PM</span>
                  <span class="preview">It’s not that bad...</span>
              </li>
              <li class="person" data-chat="person5">
                  <img src="img/michael-jordan.jpg" alt="" />
                  <span class="name">Michael Jordan</span>
                  <span class="time">2:09 PM</span>
                  <span class="preview">Wasup for the third time like is
you blind bitch</span>
              </li> -->
            </ul>
        </div>
        <div class="right">
            <div class="top"><span>To: <span class="name">Dog Woofson</span></span></div>
            <div class="chat" data-chat="person1">
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
            </div>
            <div class="write">
                <a href="javascript:;" class="write-link attach"></a>
                <input type="text" id="msg">
                <a href="javascript:;" class="write-link smiley"></a>
                <a href="javascript:;" class="write-link send" id="send"></a>
            </div>
        </div>
    </div>
  </div>
  <div style="background:#CCC">

      <div class="tipfloat" data-num="3">
          <p class="tipfloat_bt">
              <span class="fl">メッセージ</span>
              <span class="fr close"><img src="img/guanbi.png"></span>
          </p>
          <div class="ranklist">
               <div class="xx_nrong">

              </div>
          </div>
      </div>
  </div>

  <script type="text/javascript">
  $(function(){
    var user_id=<?php echo $_SESSION['mem_id']; ?>;
    // var user_id=$('#admin').val();
    // var friend_id=55;
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
  <script  src="js/index1.js"></script>
  <script>

      $(".chatBtn").click(function () {
          $(".chatBox").toggle(10);
      })
      $(".chat-close").click(function () {
          $(".chatBox").toggle(10);
      })

  </script>
  <?php require_once './tmp/footer.php'; ?>
</body>


</div>
</html>
