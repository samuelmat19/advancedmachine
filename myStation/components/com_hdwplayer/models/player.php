<?php

/*
 * @version		$Id: player.php 3.2.2 2016-10-22 $
 * @package		Joomla
 * @subpackage	hdwplayer
 * @copyright   Copyright (C) 2011-2016 HDW Player
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class HdwplayerModelPlayer extends HdwplayerModel {

	function __construct() {
		parent::__construct();
    }
	
	function getplayer()
    {
        $player = JPATH_COMPONENT.DS.'player.swf';
		
		ob_clean();
		header("content-type:application/x-shockwave-flash");
		readfile($player);
		exit();
	}
}

?>