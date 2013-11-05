<?php session_start() ?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
	<title> Where were you? </title>
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
	<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
	<script type="text/javascript">
	//<![CDATA[
	function parseToHTML(xmlStr) {
		var htmlStr = xmlStr;
		htmlStr	= htmlStr.replace(/lt\;/g,'<');
		htmlStr = htmlStr.replace(/gt\;/g,'>');
		htmlStr = htmlStr.replace(/quot\;/g,'"');
		htmlStr = htmlStr.replace(/#39\;/g,"'");
		htmlStr = htmlStr.replace(/amp\;/g,'&');
		return htmlStr;
	}

	function load() {
		var parser, xml, markers, name, html, point, marker;
		var $_GET = {};

		document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {
		    function decode(s) {
			return decodeURIComponent(s.split("+").join(" "));
		    }

		    $_GET[decode(arguments[1])] = decode(arguments[2]);
		});
		var map = new google.maps.Map(document.getElementById("map"), {
			center: new google.maps.LatLng(40, -90),
			zoom: 5,
			mapTypeId: 'roadmap'
		});

		var infoWindow = new google.maps.InfoWindow;
		
		downloadURL("search_tweets.php?q=" + $_GET['q'], function(data){ 
			parser = new DOMParser();
			xml = parser.parseFromString(data.response, "application/xml");
			markers = xml.getElementsByTagName("marker");
			for (var i = 0; i < markers.length; i++) {
				name = markers[i].getAttribute("id");
				html = parseToHTML(markers[i].getElementsByTagName("html")[0].innerHTML);
				point = new google.maps.LatLng(
					parseFloat(markers[i].getElementsByTagName("lat")[0].innerHTML),
					parseFloat(markers[i].getElementsByTagName("lng")[0].innerHTML));
				marker = new google.maps.Marker({
					map: map,
					position: point	
				});
				bindInfoWindow(marker, map, infoWindow, html);
			}
		});
	}	



	function bindInfoWindow(marker, map, infoWindow, html) {
		google.maps.event.addListener(marker, 'click', function() {
			infoWindow.setContent(html);
			infoWindow.open(map,marker);	
		});
	}

	function downloadURL(url, callback) {
		var request = window.ActiveXObject ?
			new ActiveXObject('Microsoft.XMLHTTP') :
			new XMLHttpRequest;

		request.onreadystatechange = function() {
			if (request.readyState == 4) {
				request.onreadystatechange = doNothing;
				callback(request, request.status);
			}
		};

		request.open('GET', url, true);
		request.send();
	}

	function doNothing() {}

	//]]>
 </script> 
</head>

<body onload="load()">
	<div id="map" style="width: 500px; height: 300px"></div><br>
<form action="restart_session.php" method="GET">
    <div>
      <label for="q">Click below to restart session</label><br>
      <input type="submit" value="Restart session" />
    </div>
</form>
</body>
</html>
