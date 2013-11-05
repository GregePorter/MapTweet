<!DOCTYPE html>
<html>
<head>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">
<?php 

if(!isset($_SESSION)){                                                     //starts session
	session_start();
}

include 'lib/tmhOAuthExample.php';                                        //initializes OAuthExample
$tmhOAuth = new tmhOAuthExample();	

if(isset($_GET['q'])){                                                   //Checks to see if we were entering screen name
	$_SESSION['q'] = $_GET['q'];
}

if(!isset($_COOKIE['access_token']) ||  isset($_GET['s'])){             //if we want to start a new session
	include 'lib/oauth_authorize_flow.php';
} elseif (!isset($_SESSION['q'])){                                     //if we haven't chosen a user yet
	header("Location: lib/get_user.php");
} elseif (isset($_GET['h'])){                                          //if we want to map the tweets
	header("Location: lib/map.php?q=" . $_SESSION['q']);
} else {                                                                  //if we want to view the embedded tweets
	header("Location: lib/search_tweets.php?h=t&q=" . $_SESSION['q']);
}?>

</html>
