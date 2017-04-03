<?php die("Access Denied"); ?>#x#a:3:{s:4:"body";s:5586:"<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Video Whisper Live Broadcast</title>
</head>
<body bgcolor="#333333" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<script type="text/javascript" src="http://localhost:8888/myStation/components/com_videowhisperlivestreaming/flash_detect_min.js"> </script>
	<script type="text/javascript">
	
	var updateWarning = false;

	if(FlashDetect.installed)
	{
	
	if(!FlashDetect.versionAtLeast(10, 2))
	{
		alert("Flash was detected but is too old to run this application. Upgrade your Flash plugin to proceed!"); 
		updateWarning = true;
	}
	
	}
	else
	{
		alert("Flash was not detected in your browser: Flash plugin is required to use this application!"); 
		updateWarning = true;
	}
	
	if (updateWarning)	document.write("<B class=warning>Update to latest flash player: <a href=\"http://get.adobe.com/flashplayer/\" target=\"_blank\">http://get.adobe.com/flashplayer/</a> !</B>");
	</script>
		

<object id="videowhisper_chat" width="100%" height="100%" type="application/x-shockwave-flash" data="http://localhost:8888/myStation/components/com_videowhisperlivestreaming/live_broadcast.swf?room=&prefix=http%3A%2F%2Flocalhost%3A8888%2FmyStation%2Findex.php%3Foption%3Dcom_videowhisperlivestreaming%26view%3Dflash%26format%3Draw%26videowhisper%3D1%26task%3D&extension=_none_&ws_res=http%3A%2F%2Flocalhost%3A8888%2FmyStation%2Fcomponents%2Fcom_videowhisperlivestreaming%2F">
<param name="movie" value="http://localhost:8888/myStation/components/com_videowhisperlivestreaming/live_broadcast.swf?room=&prefix=http%3A%2F%2Flocalhost%3A8888%2FmyStation%2Findex.php%3Foption%3Dcom_videowhisperlivestreaming%26view%3Dflash%26format%3Draw%26videowhisper%3D1%26task%3D&extension=_none_&ws_res=http%3A%2F%2Flocalhost%3A8888%2FmyStation%2Fcomponents%2Fcom_videowhisperlivestreaming%2F" /><param name="bgcolor" value="#333333" /><param name="salign" value="lt" /><param name="scale" value="noscale" /><param name="allowFullScreen" value="true" /><param name="allowscriptaccess" value="always" /> <param name="base" value="http://localhost:8888/myStation/components/com_videowhisperlivestreaming/" /> <param name="wmode" value="transparent" /> 
</object>

<noscript>
<p align=center>Powered by <a href="http://www.videowhisper.com/"><strong>VideoWhisper</strong></a> <a href="http://www.videowhisper.com/?p=Joomla+Live+Streaming">Live Video Streaming Software</a>.
</p>
<p align="center"><strong>This content requires the Adobe Flash Player:
  	<a href="http://get.adobe.com/flashplayer/">Get Flash</a></strong>!</p>
</noscript>

<div id="vwinfo">
iOS Transcoding (iPhone/iPad)<BR>
<a href='#' class="button" id="transcoderon">ON</a>
<a href='#' class="button" id="transcoderoff">OFF</a>
<div id="result">A stream must be broadcast for transcoder to start.</div>
<p align="right">(<a href="javascript:void(0)" onClick="vwinfo.style.display='none';">hide</a>)</p>
</div>

<style type="text/css">
<!--

#vwinfo
{
	float: right;
	width: 25%;
	position: absolute;
	bottom: 10px;
	right: 10px;
	text-align:left;
	padding: 10px;
	margin: 10px;
	background-color: #666;
	border: 1px dotted #AAA;
	z-index: 1;

	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#999', endColorstr='#666'); /* for IE */
	background: -webkit-gradient(linear, left top, left bottom, from(#999), to(#666)); /* for webkit browsers */
	background: -moz-linear-gradient(top,  #999,  #666); /* for firefox 3.6+ */

	box-shadow: 2px 2px 2px #333;


	-moz-border-radius: 9px;
	border-radius: 9px;
}

#vwinfo > a {
	color: #F77;
	text-decoration: none;
}

#vwinfo > .button {
	-moz-box-shadow:inset 0px 1px 0px 0px #f5978e;
	-webkit-box-shadow:inset 0px 1px 0px 0px #f5978e;
	box-shadow:inset 0px 1px 0px 0px #f5978e;
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #db4f48), color-stop(1, #944038) );
	background:-moz-linear-gradient( center top, #db4f48 5%, #944038 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#db4f48', endColorstr='#944038');
	background-color:#db4f48;
	border:1px solid #d02718;
	display:inline-block;
	color:#ffffff;
	font-family:Verdana;
	font-size:12px;
	font-weight:normal;
	font-style:normal;
	text-decoration:none;
	text-align:center;
	text-shadow:1px 1px 0px #810e05;
	padding: 5px;
	margin: 2px;
}
#vwinfo > .button:hover {
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #944038), color-stop(1, #db4f48) );
	background:-moz-linear-gradient( center top, #944038 5%, #db4f48 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#944038', endColorstr='#db4f48');
	background-color:#944038;
}

-->
</style>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript">
	$.ajaxSetup ({
		cache: false
	});
	var ajax_load = "Loading...";

	$("#transcoderon").click(function(){
		$("#result").html(ajax_load).load("http://localhost:8888/myStation/index.php?option=com_videowhisperlivestreaming&view=transcode&format=raw&videowhisper=1&task=hls&stream=");
	});

	$("#transcoderoff").click(function(){
	$("#result").html(ajax_load).load("http://localhost:8888/myStation/index.php?option=com_videowhisperlivestreaming&view=transcode&format=raw&videowhisper=1&task=close&stream=");
	});
</script></body>
</html>
";s:13:"mime_encoding";s:9:"text/html";s:7:"headers";a:5:{i:0;a:2:{s:4:"name";s:12:"Content-Type";s:5:"value";s:24:"text/html; charset=utf-8";}i:1;a:2:{s:4:"name";s:7:"Expires";s:5:"value";s:29:"Wed, 17 Aug 2005 00:00:00 GMT";}i:2;a:2:{s:4:"name";s:13:"Last-Modified";s:5:"value";s:29:"Mon, 12 Dec 2016 22:36:33 GMT";}i:3;a:2:{s:4:"name";s:13:"Cache-Control";s:5:"value";s:62:"no-store, no-cache, must-revalidate, post-check=0, pre-check=0";}i:4;a:2:{s:4:"name";s:6:"Pragma";s:5:"value";s:8:"no-cache";}}}