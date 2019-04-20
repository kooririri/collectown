<?php
session_start();
if(isset($_SESSION)&&!empty($_SESSION)){
	$_SESSION = array();
  if (isset($_COOKIE[session_name()])) {
      setcookie(session_name(), '', time()-42000, '/');
  }
  session_destroy();
}
header('location:./index.php');

?>
