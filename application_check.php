<?php
// require_once './config.php';
// require_once './function.php';
//
// $link=mysqli_connect(HOST,DB_USER,DB_PASS,DB_NAME);
// if(!$link){
//   return false;
// }
// mysqli_set_charset($link , 'utf8');
// $sql_get="SELECT COUNT(*) FROM ra_application WHERE ra_id = 1551128984";
// $query_get=mysqli_query($link,$sql_get);
// $res_get=mysqli_fetch_assoc($query_get);
// // echo $res_get;
// // var_dump($res_get);
//
//

?>
<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>collectown</title>
<link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
<link rel="stylesheet" type="text/css" href="./css/side_nav2.css">
<link href="./css/home.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="./js/jquery.js"></script>
<script type="text/javascript" src="./js/jquery.min.js"></script>
<script type="text/javascript" src="./js/current.js"></script>

	<!--主要样式-->
  	<link rel="stylesheet" href="css/demo.css">
  	<link rel="stylesheet" href="css/dialog.css">

</head>
<body>


		<div class="mt20"><button id="defDialog">原始弹窗</button></div>


	<script src="js/jquery-1.11.0.min.js" type="text/javascript"></script>
	<script src="js/jquery.dialog.js"></script>
	<script>
		// 原始弹窗
    $('#defDialog').click(function() {
      var content = '<div class="customClass">' + '原始弹窗-内容，需要自定义该模块的样式！' + '<div>' + '<button class="j_dialogConfirm">确认</button>' + '&nbsp;<button class="j_dialogCancel">取消</button>' + '</div>' + '</div>';
      $.dialog({
        id: 'customId',
        title: '原始弹窗-标题',
        hideHeader: false,
        hideClose: false,
        content: content,
        onConfirm: function() {
          $.sendMsg('点击确定！');
        },
        onCancel: function() {
          $.sendMsg('点击取消！');
        },
        onClose: function() {
          $.sendMsg('点击关闭！');
        }
      });
    });
	</script>
</body>
</html>
