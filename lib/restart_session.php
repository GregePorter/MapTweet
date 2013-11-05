<?php
	//This is a quick page used to clear all the session data and start over again
	session_start();
	unset($_COOKIE['access_token_secret']);
	unset($_COOKIE['access_token']);
	unset($_SESSION['q']);
	setcookie('access_token_secret',"", time()-2600);
	setcookie('access_token', "", time()-2600);
	session_destroy();
	header("Location: ../index.php?s=t");
?>
