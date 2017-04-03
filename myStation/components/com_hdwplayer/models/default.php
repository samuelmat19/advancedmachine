<?php

/*
 * @version		$Id: default.php 3.2.2 2016-10-22 $
 * @package		Joomla
 * @subpackage	hdwplayer
 * @copyright   Copyright (C) 2011-2016 HDW Player
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class HdwplayerModelDefault extends HdwplayerModel {

	function __construct() {
		parent::__construct();
    }
	
	function getsettings() {
         $db     = JFactory::getDBO();
         $query  = "SELECT * FROM #__hdwplayer_settings WHERE id=1";
         $db->setQuery( $query );
         $output = $db->loadObjectList();
         return($output[0]);
	}
	
	function googleads()
    {
         $db     = JFactory::getDBO();
         $query  = "SELECT * FROM #__hdwplayer_googleads WHERE id=1";
         $db->setQuery( $query );
         $output = $db->loadObjectList();
         return($output[0]);
	}
	
}

?>