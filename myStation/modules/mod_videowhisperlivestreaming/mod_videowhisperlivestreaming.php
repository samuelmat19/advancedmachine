<?php
/*
VideoWhisper Live Streaming Integration (for Joomla):

Copyright (C) 2009  VideoWhisper.com

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

//don't allow other scripts to grab and execute our file
defined('_JEXEC') or die('Direct Access to this location is not allowed.');

// j3.0
if(!defined('DS')){
	define('DS', '/');
}

 if (!file_exists('components/com_videowhisperlivestreaming'))
 {
	 echo "This module requires VideoWhisper <a href='http://www.videowhisper.com/?p=Joomla+Live+Streaming'>Live Streaming component</a>.";
 }
 

  $cparams = &JComponentHelper::getParams( 'com_videowhisperlivestreaming' );
  $VideoWhisper = $cparams->get( 'VideoWhisper' );
  
	$host=$_SERVER['HTTP_HOST'];
	$path=$_SERVER['REQUEST_URI'];
	
	if ($path[strlen($path)-1]!='/')
	{
	$lpath=strrchr($path, "/");
	if ($lpath) $path=substr($path,0,-strlen($lpath)+1);
	}

	$linkcode = JURI::base() . "index.php?option=com_videowhisperlivestreaming&view=channel&n=";
	
        $db = &JFactory::getDBO();

		$exptime=time()-30;
		$sql="DELETE FROM `#__vw_sessions` WHERE edate < $exptime";
		$db->setQuery( $sql );
		$db->query();		
		
        // get a list of all users
        $query = "SELECT * FROM #__vw_sessions where status='1' and type='1'  ORDER BY edate DESC LIMIT 0, 10";
        $db->setQuery($query);
        $items = ($items = $db->loadObjectList())?$items:array();
		echo "<ul>";
		if ($items)	foreach ($items as $item) echo "<li><a href='$linkcode".urlencode($item->room)."'><B>".$item->room."</B>".($item->message?": ".$item->message:"") ."</a></li>";
		else echo "<li>No video broadcasters online.</li>";
		echo "</ul>";
		echo "<IMG SRC='" .JURI::base(). "components/com_videowhisperlivestreaming/templates/live/i_uvideo.png' align='absmiddle' border='0'> <a href='" . JURI::base() . "index.php?option=com_videowhisperlivestreaming&view=channelslist'>Live Channels List</a>";
		echo "<BR><IMG SRC='" .JURI::base(). "components/com_videowhisperlivestreaming/templates/live/i_webcam.png' align='absmiddle' border='0'> <a href='" . JURI::base() . "index.php?option=com_videowhisperlivestreaming&view=vw&format=raw'>Live Broadcast Yourself</a>";
		
		$state = 'block' ;
		if (!$VideoWhisper) $state = 'none';	
		echo '<div id="VideoWhisper" style="display: ' . $state . ';">Powered by VideoWhisper <a href="http://www.videowhisper.com/?p=Joomla+Live+Streaming">Live Video Streaming Software</a>.</div>';
?>