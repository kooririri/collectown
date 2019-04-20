<?php
session_start();
require_once './config.php';
require_once './function.php';
header("content-type:text/html;charset=utf-8");

//$file_name = "";
  if (move_uploaded_file($_FILES["file"]["tmp_name"], "images/collection/" . $_FILES["file"]["name"])) {
    echo $_FILES["file"]["name"] . "をアップロードしました。";
	$_SESSION['img_name'] =  $_FILES["file"]["name"];
  } else {
    echo "ファイルをアップロードできません。";
  }

?>