<?php
session_start();
require_once 'config.php';
require_once 'function.php';
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
<link rel="stylesheet" href="css/side_nav2.css">
<link rel="stylesheet" href="css/collection.css">
<link rel="stylesheet" type="text/css" href="./css/top.css">
<link rel="stylesheet" type="text/css"  href="css/reset.min.css">
<link rel="stylesheet" type="text/css" href="css/dmstyle.css">
<link rel="stylesheet" type="text/css" href="./css/home.css"/>
<!-- バリデーションチェック -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/validationEngine.jquery.min.css" type="text/css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/jquery-1.8.2.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/languages/jquery.validationEngine-ja.min.js" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/jquery.validationEngine.min.js" type="text/javascript" charset="utf-8"></script>
<!-- 画像をアップロードするのに必要なjquery -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
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
<script type="text/javascript">
jQuery(document).ready(function(){
   jQuery("#col").validationEngine();
});
</script>
</head>
<body>
<header>
    <?php require_once './tmp/header.php'; ?>
</header>
<div class="wrapper">
    <?php require_once './tmp/side_nav.php'; ?>
    <div class="collection">

        <h2>コレクション投稿</h2>
        <div class="col_con">
            <div id="dragandrophandler">
                <p>ここにドロップしてください</p>
            </div>
            <br><br>
            <div id="status1"></div>
            <script>
                function sendFileToServer(formData,status)
                {
                    var uploadURL ="upload.php"; //Upload URL
                    var extraData ={}; //Extra Data.
                    var jqXHR=$.ajax({
                            xhr: function() {
                            var xhrobj = $.ajaxSettings.xhr();
                            if (xhrobj.upload) {
                                    xhrobj.upload.addEventListener('progress', function(event) {
                                        var percent = 0;
                                        var position = event.loaded || event.position;
                                        var total = event.total;
                                        if (event.lengthComputable) {
                                            percent = Math.ceil(position / total * 100);
                                        }
                                        //Set progress
                                        status.setProgress(percent);
                                    }, false);
                                }
                            return xhrobj;
                        },
                    url: uploadURL,
                    type: "POST",
                    contentType:false,
                    processData: false,
                        cache: false,
                        data: formData,
                        success: function(data){
                            status.setProgress(100);

                            $("#status1").append("File upload Done<br>");
                        }
                    });

                    status.setAbort(jqXHR);
                }

                var rowCount=0;
                function createStatusbar(obj)
                {
                     rowCount++;
                     var row="odd";
                     if(rowCount %2 ==0) row ="even";
                     this.statusbar = $("<div class='statusbar "+row+"'></div>");
                     this.filename = $("<div class='filename'></div>").appendTo(this.statusbar);
                     this.size = $("<div class='filesize'></div>").appendTo(this.statusbar);
                     this.progressBar = $("<div class='progressBar'><div></div></div>").appendTo(this.statusbar);
                     this.abort = $("<div class='abort'>Abort</div>").appendTo(this.statusbar);
                     obj.after(this.statusbar);

                    this.setFileNameSize = function(name,size)
                    {
                        var sizeStr="";
                        var sizeKB = size/1024;
                        if(parseInt(sizeKB) > 1024)
                        {
                            var sizeMB = sizeKB/1024;
                            sizeStr = sizeMB.toFixed(2)+" MB";
                        }
                        else
                        {
                            sizeStr = sizeKB.toFixed(2)+" KB";
                        }

                        this.filename.html(name);
                        this.size.html(sizeStr);
                    }
                    this.setProgress = function(progress)
                    {
                        var progressBarWidth =progress*this.progressBar.width()/ 100;
                        this.progressBar.find('div').animate({ width: progressBarWidth }, 10).html(progress + "% ");
                        if(parseInt(progress) >= 100)
                        {
                            this.abort.hide();
                        }
                    }
                    this.setAbort = function(jqxhr)
                    {
                        var sb = this.statusbar;
                        this.abort.click(function()
                        {
                            jqxhr.abort();
                            sb.hide();
                        });
                    }
                }
                function handleFileUpload(files,obj)
                {
                   for (var i = 0; i < files.length; i++)
                   {
                        var fd = new FormData();
                        fd.append('file', files[i]);

                        var status = new createStatusbar(obj); //Using this we can set progress.
                        status.setFileNameSize(files[i].name,files[i].size);
                        sendFileToServer(fd,status);

                   }
                }
                $(document).ready(function()
                {
                var obj = $("#dragandrophandler");
                obj.on('dragenter', function (e)
                {
                    e.stopPropagation();
                    e.preventDefault();
                    $(this).css('border', '2px solid #0B85A1');
                });
                obj.on('dragover', function (e)
                {
                     e.stopPropagation();
                     e.preventDefault();
                });
                obj.on('drop', function (e)
                {

                     $(this).css('border', '2px dotted #0B85A1');
                     e.preventDefault();
                     var files = e.originalEvent.dataTransfer.files;

                     //We need to send dropped files to Server
                     handleFileUpload(files,obj);
                });
                $(document).on('dragenter', function (e)
                {
                    e.stopPropagation();
                    e.preventDefault();
                });
                $(document).on('dragover', function (e)
                {
                  e.stopPropagation();
                  e.preventDefault();
                  obj.css('border', '2px dotted #0B85A1');
                });
                $(document).on('drop', function (e)
                {
                    e.stopPropagation();
                    e.preventDefault();
                });

                });
            </script>

                <form action="up_data.php" method="POST" id="col">
                    <p>キャプション</p>
                    <textarea name="caption" rows="5" col="40" placeholder="キャプション" class="validate[required]"></textarea>

                    <p>ジャンル</p>
                    <div id="genre_div">
                        <select name="genre" class="validate[required]">
                            <!-- <option value="default">ジャンルを選択してください</option> -->
                            <option value="">ジャンルを選択してください</option>
                            <?php
                                $sql = "SELECT * FROM genre ";
                                $link = mysqli_connect(HOST,DB_USER,DB_PASS,DB_NAME);
                                if(!$link){
                                  return false;
                                  //die('error:'.mysql_error());
                                }
                                mysqli_set_charset($link , 'utf8');
                                $result = mysqli_query($link,$sql);
                                if($result){
                                    if(mysqli_num_rows($result) > 0){
                                while($row = mysqli_fetch_assoc($result)){
                                echo "<option value='".$row['gen_id']."'>".$row['gen_name']."</option>";
                                }
                                    }
                                }
                                mysqli_close($link);
                            ?>
                        </select>
                        <span class="msg"></span>
                    </div>

                    <p>レア度</p>
                    <select name="rearity"  class="validate[required]">
                        <option value="" selected="selected" > レア度を選択してください</option>
                        <option value="1">レア度1</option>
                        <option value="2">レア度2</option>
                        <option value="3">レア度3</option>
                        <option value="4">レア度4</option>
                        <option value="5">レア度5</option>
                    </select>

                    <p>公開設定</p>
                    <span>
                    <label><input type="radio" name="rele_flag" value="公開" checked required>公開</label>
                    <label><input type="radio" name="rele_flag" value="非公開">非公開</label>
                    </span>

                    <div class="col_btn">
                        <input type="submit" value="コレクション登録">
                    </div><!-- col_btn　ここまで -->
                </form>

        </div><!-- col_con　ここまで -->

    </div><!-- collection ここまで -->
</div><!-- wrapper ここまで -->
<?php require_once './tmp/footer.php'; ?>
<!--
<script src="./js/main.js" charset="utf-8"></script>
-->
</body>
</html>
