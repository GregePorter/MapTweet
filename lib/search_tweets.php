<?php
function parseToXML($htmlStr){                                         //function which converts html to something
	$xmlStr=str_replace('<','lt;',$htmlStr);                       //that can be returned to javascript call
	$xmlStr=str_replace('>','gt;',$xmlStr);
	$xmlStr=str_replace('"','quot;',$xmlStr);
	$xmlStr=str_replace("'",'#39;',$xmlStr);
	$xmlStr=str_replace('&','amp;',$xmlStr);
	return $xmlStr;
}

include 'tmhOAuthExample.php';                                         //Initializes OAuthExample
$tmhOAuth = new tmhOAuthExample();

if(!isset($_SESSION)){
	session_start();
}


$doc = new SimpleXMLElement("<markers></markers>");

                                                                        //Finds the tweets from the desired user
$code = $tmhOAuth->user_request(array(
'url' => $tmhOAuth->url('1.1/statuses/user_timeline.json'),
	'params' => array(
		'screen_name' => $_SESSION['q'],
		'include_entities' => false
	)
));

if ($code == 200) {                                                     //checks to see if the request was successful
	$data = json_decode($tmhOAuth->response['response'], true);     //formats the response into an array
	foreach($data as $tweet) {                                      //cycles through each tweet in the response
		$embededResponse = $tmhOAuth->user_request(array(       //gets the tweet_id and requests the embeded
			'url' => $tmhOAuth->url('1.1/statuses/oembed'), //version of that tweet
			'params' => array(
			'id' => $tweet['id_str'])
		));
		if ($embededResponse == 200){                                   //checks to see if that embeded tweet request
			$embededTweet = json_decode($tmhOAuth->response['response'], true);  //was successful
			if(isset($_GET['h'])){
				echo $embededTweet['html'] . "<br>";
			}
		} else {
			$embededTweet = array('html' => $tweet["text"]);   //it might just save the tweet as text
		}
		
		$marker = $doc->addChild("marker");                                 //forms the xml file to return
		$marker->addAttribute('id', $tweet['id_str']);
		if($tweet["geo"]){ 
			$marker->addChild("lat", $tweet["geo"]["coordinates"][0]);
			$marker->addChild("lng", $tweet["geo"]["coordinates"][1]);
		} else {
			$marker->addChild("lat", 0);
			$marker->addChild("lng", 0);
		}	
		$marker->addChild("html", parseToXML($embededTweet['html']));
		
	}

	if(!isset($_GET['h'])){	
		echo $doc->asXML();
	} else {
		include 'footer.php';
	} 
} else {
	echo $tmhOAuth->response['error'];
} ?>
