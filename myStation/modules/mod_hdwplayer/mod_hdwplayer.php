<?php

/*
 * @version		$Id: mod_hdwplayer.php 3.2.2 2016-10-22 $
 * @package		Joomla
 * @subpackage	hdwplayer
 * @copyright   Copyright (C) 2011-2016 HDW Player
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

if(!defined('DS')) { 
	define('DS',DIRECTORY_SEPARATOR); 
}

// Include the syndicate functions only once
require_once( dirname(__FILE__).DS.'helper.php' );
 
$params->def('showtitle', 0);
$params->def('showdscription', 0);
$params->def('autodetect', 1);

$items = modhdwplayerHelper::getItems( $params );

require(JModuleHelper::getLayoutPath('mod_hdwplayer'));

?>