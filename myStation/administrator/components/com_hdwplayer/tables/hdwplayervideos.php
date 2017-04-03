<?php

/*
 * @version		$Id: hdwplayervideos.php 3.2.2 2016-10-22 $
 * @package		Joomla
 * @subpackage	hdwplayer
 * @copyright   Copyright (C) 2011-2016 HDW Player
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Include library dependencies
jimport('joomla.filter.input');

class TableHdwplayerVideos extends JTable {

	var $id              = null;
	var $title           = null;
	var $description     = null;
	var $type            = null;
	var $streamer        = null;
	var $dvr             = null;
	var $video           = null;
	var $hdvideo         = null;
	var $preview         = null;
	var $thumb           = null;
	var $token           = null;
	var $category        = null;
	var $featured        = 0;
	var $user            = 'Admin';
	var $tags            = null;
	var $metadescription = null;
	var $views           = null;
	var $ordering        = null;
	var $published       = 0;
	
	function __construct(& $db) {
		parent::__construct('#__hdwplayer_videos', 'id', $db);
	}

	function check() {
		return true;
	}
	
}

?>