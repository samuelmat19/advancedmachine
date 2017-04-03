<?php

/*
 * @version		$Id: mod_hdwplayergallery.php 3.2.2 2016-10-22 $
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
 
$catid      = modhdwplayergalleryHelper::getCategory();
$items      = modhdwplayergalleryHelper::getItems( $params, $catid );
$pagination = modhdwplayergalleryHelper::getPagination( $params, $catid );

if($items['type'] == 'Category' && !JRequest::getCmd('catid')) {
	require (JModuleHelper::getLayoutPath('mod_hdwplayergallery', 'default_categories'));	
} else {
	require (JModuleHelper::getLayoutPath('mod_hdwplayergallery', 'default_videos'));	
}

?>