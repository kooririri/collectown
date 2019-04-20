<?php
session_start();
// var_dump($_SESSION);
require_once './config.php';
require_once './function.php';
header("content-type:text/html;charset=utf-8");
	if(isset($_FILES)&&!empty($_FILES)){
	$arr=$_FILES["file"];
		if($arr["type"]=="image/jpeg" || $arr["type"]=="image/png" && $arr["size"]<=1024000)
		{
		  $arr["tmp_name"];
		  $filename="./images/acting_images/".time().$arr["name"];
		  if(file_exists($filename)){ echo "もう一回試してください";}
		  else{
		  $filename=iconv("UTF-8","gb2312",$filename);
		  move_uploaded_file($arr["tmp_name"],$filename);
			echo "ok";
		  }
		}
	else{
	    echo "画像を選択してください";
	    }
			// echo $filename;
}
// var_dump($_SESSION);

	require_once './tmp/acting_demand.php';
 ?>
