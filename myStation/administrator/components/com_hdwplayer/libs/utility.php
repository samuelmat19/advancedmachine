<?php

/*
 * @version		$Id: utility.php 3.2.2 2016-10-22 $
 * @package		Joomla
 * @subpackage	hdwplayer
 * @copyright   Copyright (C) 2011-2016 HDW Player
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

class HdwplayerUtility {

	public static function getToken() {
	
		if (version_compare(JVERSION, '1.6.0', '<')) {
			return JUtility::getToken();
		} else {
			return JSession::getFormToken();
		}
		
	}

}

?>