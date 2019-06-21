<?php
	session_start();
	$get = $_GET['var'];
	$_SESSION[$get] = $_GET[$get];
	echo $get." ".$_SESSION[$get];
	//session_destroy();
?>

