<?php
//session_start();
require_once './config.php';
require_once './function.php';

//コレクション
$link = mysqli_connect(HOST,DB_USER,DB_PASS,DB_NAME);
if(!$link){
  return false;
}
mysqli_set_charset($link, 'utf8');

$col_sql = "SELECT * FROM col_content WHERE rele_flag = 0";
$col_result = mysqli_query($link, $col_sql);
while($collect = mysqli_fetch_assoc($col_result)){
	$col_row[] = $collect;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>COLLECTOWN</title>
<meta content="タイトル" name="title">
<meta content="ディスクリプション" name="description">
<meta content="キーワード" name="keywords">
<!--cssを読み込む-->
<!-- <link rel="stylesheet" href="./css/common.css"> -->
<link rel="stylesheet" type="text/css" href="./css/side_nav2.css">
<link rel="stylesheet" type="text/css" href="./css/top.css">
<!--
<link rel="stylesheet" type="text/css" href="./css/home2.css">
-->


<!--
<script src="./js/jquery-1.12.0.min.js" charset="utf-8"></script>
-->
<!--[if 1t IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->
<!--
<script src="sample.js"></script>
-->
</head>
<body>
	<div class="top_con">
		<div class="mv">
			<img src="./img/mv2.jpg" alt="mv">
			<div class="mv_font">
			<p class="ttl">自分だけのコレクション図鑑を<br>完成させてシェアしましょう</p>
			<p class="sub">交流場でコレクターと交流したり、</p>
			<p>代行サービスを利用してアイテム交換ができます</p>
			<p>コレクターたちの街を作り上げましょう</p>
			</div>
		</div><!-- mvここまで -->

		<div id="maincont">
			<div id="index">
				<a id="state" href="./personal_page/index.php"></a>
				<dl class="cation-list">
					<dt>ジャンル</dt>
					<dd>
						<a href="#" rel="" name="gen_id" class="all on">全部</a>
						<?php	for($i=0;$i<count($genre_arr);$i++){?>
						<a href="#" rel="<?php echo $genre_arr[$i]['gen_id']; ?>" name="gen_id" class="default"><?php echo $genre_arr[$i]['gen_name']; ?></a>
						<?php } ?>
					</dd>
				</dl>

				<dl class="cation-list">
					<dt>値段</dt>
					<dd>
						<a href="#" rel="" name="price" class="all on">全部</a>
						<a href="#" rel="1" name="price" class="default">~1000</a>
						<a href="#" rel="2" name="price" class="default">1001~5000</a>
						<a href="#" rel="3" name="price" class="default">5001~10000</a>
						<a href="#" rel="4" name="price" class="default">10001~50000</a>
						<a href="#" rel="5" name="price" class="default">50001~</a>
					</dd>
				</dl>

				<dl class="cation-list">
					<dt>期限</dt>
					<dd>
						<a href="#" rel="" name="order" class="all on">全部</a>
						<a href="#" rel="ASC" name="order" class="default">時間早い順</a>
						<a href="#" rel="DESC" name="order" class="default">時間遅い順</a>
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
			</div><!-- index ここまで -->
		</div><!-- maincont ここまで -->


		<h3>新着コレクション</h3>
		<div class="main_contents">
			<?php foreach($col_row as $col){ ?>
			<div class="main_con">
				<div class="m_img">
					<a href="./reverse_auction.php?ra_id=<?php //echo $data[$i]['ra_id']; ?>">
						<img class="ra_pic" src="images/collection/<?php echo $col['img_name']//echo $row[$j]['img_name']; ?>" alt="collection_image">
					</a>
				</div><!-- m_imgここまで -->

				<div class="m_con">
				<p class="col_ttl">コレクション</p>
				<p class="cap"><?php echo $col['caption']; ?></p>
				<p>レア度：<img src="img/rearity<?php echo $col['rarity']?>.png" alt="レア度"></p>
				<div class="hush_tag"><a href="#"><span>＃タグ</span></div>
				<div class="hush_tag"><a href="#"><span>＃タグ</span></div>
				</div>
			</div><!-- main_conここまで -->
			<?php } ?><!-- foreachここまで -->
		</div><!-- main_contents -->

		<h3>新着代行依頼</h3>
		<div class="subcont">
			<?php for($i=0; $i<count($data); $i++){ ?>
			<div class="contents">
				<div class="img_wrap">
					<a href="./reverse_auction.php?ra_id=<?php echo $data[$i]['ra_id']; ?>">
						<img class="ra_pic" src="<?php  echo $data[$i]['img_add']; ?>" alt="image">
					</a>
				</div><!-- img_wrap ここまで -->

				<div class="cont_demand">
					<!-- <a class="chatBtn" href="javascript:void(0)" rel="<?php// echo $data[$i]['mem_id']; ?>" name="receiver" class="default"  style="display:block;"> -->
					<div class="chatBtn" onclick="get_receiver(<?php echo $data[$i]['mem_id']; ?>);">
						<div class="profile">
							<!-- <div class="profile_pic">--><img src="<?php echo $data[$i]['pro_pic_add'];?>"><!-- </div>  -->
						</div>

						<div class="nick"><?php echo $data[$i]['nick']; ?></div>
						<input class="user" name="user" type="hidden" value="<?php echo $data[$i]['mem_id']; ?>">
					</div><!-- chatBtn　ここまで -->
					<!-- </a> -->

					<div class="m_con">
					<div class="m_wrap">
						<div class="ttl3">代行依頼品</div>
						<div class="emp"><?php echo $data[$i]['ra_name']; ?></div>
					</div>


						<p>
							<?php echo $data[$i]['introduction']; ?>
						</p>
						<p>お取引可能期限<br>
							<span class="time"><?php echo $data[$i]['deadline']; ?>まで</span>
						</p>
						<p>引き受け応募人数<span class="emp"><?php echo $data[$i]['bid_num']; ?>人</span></p>
						<p>代行依頼価格<span class="emp"><?php echo num($data[$i]['ra_price']); ?>円</span></p>
						<p>引き受け応募最安値<span class="emp">
							<?php
								$msg= "応募なし";
								foreach($row1 as $key => $val){
									if(in_array($data[$i]['ra_id'],$val)){
										$msg = num($val['MIN(bid_price)'])."円";
									}
								} echo $msg;?></span></p>
					</div><!-- m_con ここまで  -->
				</div><!-- contents ここまで -->
			</div><!-- cont_demand　ここまで -->

			<?php }; ?><!-- for ここまで -->
		</div><!-- subcont ここまで -->

		<!--
		<div class="more_btn">
			<a href="#">MORE</a>
		</div><!-- more_btn ここまで -->


		<div class="about">
			<div class="about_con">
				<p class="ttl4">COLLECTOWN</p>
				<p class="min_ttl">自分だけのコレクション</p>
				<div class="about_btn">
					<p>ABOUT COLLECTOWN</p>
				</div>
			</div><!-- about_con ここまで -->
		</div><!-- aboutここまで -->

		<div class="service">
			<div class="collection">
				<p><a href="up_col.php">自身のコレクションを作る<img src="./img/arrow2.svg"></a></p>
			</div>

			<div class="bbs">
				<p><a href="#">コレクターと繋がる<img src="./img/arrow2.svg"></a></p>
			</div>

			<div class="acting">
				<p><a href="acting_demand.php">代行で助け合う<img src="./img/arrow2.svg"></a></p>
			</div>
		</div><!-- serviceここまで -->

	<!--- </div><!-- mainsここまで -->

  <!-- <iframe src="./personal_page/dm.php">asdasd </iframe> -->
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
                  <span class="preview">Wasup for the third time like is you blind bitch</span>
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
      //
      // screenFuc();
      // function screenFuc() {
      //     var topHeight = $(".chatBox-head").innerHeight();//聊天头部高度
      //     //屏幕小于768px时候,布局change
      //     var winWidth = $(window).innerWidth();
      //     if (winWidth <= 768) {
      //         var totalHeight = $(window).height(); //页面整体高度
      //         $(".chatBox-info").css("height", totalHeight - topHeight);
      //         var infoHeight = $(".chatBox-info").innerHeight();//聊天头部以下高度
      //         //中间内容高度
      //         $(".chatBox-content").css("height", infoHeight - 46);
      //         $(".chatBox-content-demo").css("height", infoHeight - 46);
      //
      //         $(".chatBox-list").css("height", totalHeight - topHeight);
      //         $(".chatBox-kuang").css("height", totalHeight - topHeight);
      //         $(".div-textarea").css("width", winWidth - 106);
      //     } else {
      //         $(".chatBox-info").css("height", 495);
      //         $(".chatBox-content").css("height", 448);
      //         $(".chatBox-content-demo").css("height", 448);
      //         $(".chatBox-list").css("height", 495);
      //         $(".chatBox-kuang").css("height", 495);
      //         $(".div-textarea").css("width", 260);
      //     }
      // }
      // (window.onresize = function () {
      //     screenFuc();
      // })();
      // //未读信息数量为空时
      // var totalNum = $(".chat-message-num").html();
      // if (totalNum == "") {
      //     $(".chat-message-num").css("padding", 0);
      // }
      // $(".message-num").each(function () {
      //     var wdNum = $(this).html();
      //     if (wdNum == "") {
      //         $(this).css("padding", 0);
      //     }
      // });


      //打开/关闭聊天框
      $(".chatBtn").click(function () {
          $(".chatBox").toggle(10);
      })
      $(".chat-close").click(function () {
          $(".chatBox").toggle(10);
      })
      //进聊天页面
      // $(".chat-list-people").each(function () {
      //     $(this).click(function () {
      //         var n = $(this).index();
      //         $(".chatBox-head-one").toggle();
      //         $(".chatBox-head-two").toggle();
      //         $(".chatBox-list").fadeToggle();
      //         $(".chatBox-kuang").fadeToggle();
      //
      //         //传名字
      //         $(".ChatInfoName").text($(this).children(".chat-name").children("p").eq(0).html());
      //
      //         //传头像
      //         $(".ChatInfoHead>img").attr("src", $(this).children().eq(0).children("img").attr("src"));
      //
      //         //聊天框默认最底部
      //         $(document).ready(function () {
      //             $("#chatBox-content-demo").scrollTop($("#chatBox-content-demo")[0].scrollHeight);
      //         });
      //     })
      // });
      //
      // //返回列表
      // $(".chat-return").click(function () {
      //     $(".chatBox-head-one").toggle(1);
      //     $(".chatBox-head-two").toggle(1);
      //     $(".chatBox-list").fadeToggle(1);
      //     $(".chatBox-kuang").fadeToggle(1);
      // });
      //
      // //      发送信息
      // $("#chat-fasong").click(function () {
      //     var textContent = $(".div-textarea").html().replace(/[\n\r]/g, '<br>')
      //     if (textContent != "") {
      //         $(".chatBox-content-demo").append("<div class=\"clearfloat\">" +
      //             "<div class=\"author-name\"><small class=\"chat-date\">2017-12-02 14:26:58</small> </div> " +
      //             "<div class=\"right\"> <div class=\"chat-message\"> " + textContent + " </div> " +
      //             "<div class=\"chat-avatars\"><img src=\"img/icon01.png\" alt=\"头像\" /></div> </div> </div>");
      //         //发送后清空输入框
      //         $(".div-textarea").html("");
      //         //聊天框默认最底部
      //         $(document).ready(function () {
      //             $("#chatBox-content-demo").scrollTop($("#chatBox-content-demo")[0].scrollHeight);
      //         });
      //     }
      // });
      //
      // //      发送表情
      // $("#chat-biaoqing").click(function () {
      //     $(".biaoqing-photo").toggle();
      // });
      // $(document).click(function () {
      //     $(".biaoqing-photo").css("display", "none");
      // });
      // $("#chat-biaoqing").click(function (event) {
      //     event.stopPropagation();//阻止事件
      // });
      //
      // $(".emoji-picker-image").each(function () {
      //     $(this).click(function () {
      //         var bq = $(this).parent().html();
      //         console.log(bq)
      //         $(".chatBox-content-demo").append("<div class=\"clearfloat\">" +
      //             "<div class=\"author-name\"><small class=\"chat-date\">2017-12-02 14:26:58</small> </div> " +
      //             "<div class=\"right\"> <div class=\"chat-message\"> " + bq + " </div> " +
      //             "<div class=\"chat-avatars\"><img src=\"img/icon01.png\" alt=\"头像\" /></div> </div> </div>");
      //         //发送后关闭表情框
      //         $(".biaoqing-photo").toggle();
      //         //聊天框默认最底部
      //         $(document).ready(function () {
      //             $("#chatBox-content-demo").scrollTop($("#chatBox-content-demo")[0].scrollHeight);
      //         });
      //     })
      // });
      //
      // //      发送图片
      // function selectImg(pic) {
      //     if (!pic.files || !pic.files[0]) {
      //         return;
      //     }
      //     var reader = new FileReader();
      //     reader.onload = function (evt) {
      //         var images = evt.target.result;
      //         $(".chatBox-content-demo").append("<div class=\"clearfloat\">" +
      //             "<div class=\"author-name\"><small class=\"chat-date\">2017-12-02 14:26:58</small> </div> " +
      //             "<div class=\"right\"> <div class=\"chat-message\"><img src=" + images + "></div> " +
      //             "<div class=\"chat-avatars\"><img src=\"img/icon01.png\" alt=\"头像\" /></div> </div> </div>");
      //         //聊天框默认最底部
      //         $(document).ready(function () {
      //             $("#chatBox-content-demo").scrollTop($("#chatBox-content-demo")[0].scrollHeight);
      //         });
      //     };
      //     reader.readAsDataURL(pic.files[0]);
      //
      // }
      //

  </script>

<!--
<script src="./js/main.js" charset="utf-8"></script>
-->
<div><input type="hidden" id="admin" name="admin" value="<?php echo $_SESSION["mem_id"];?>"></div>

</div><!-- top_conここまで -->
<?php require_once './tmp/footer.php'; ?>
</body>
</html>
