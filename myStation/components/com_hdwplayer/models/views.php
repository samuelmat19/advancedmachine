<?php

/*
 * @version		$Id: views.php 3.2.2 2016-10-22 $
 * @package		Joomla
 * @subpackage	hdwplayer
 * @copyright   Copyright (C) 2011-2016 HDW Player
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class HdwplayerModelViews extends HdwplayerModel {

	function __construct() {
		parent::__construct();
    }
	
	function addview()
    {
		 ob_clean();
	     $id               = JRequest::getCmd('id');
         $mainframe        = JFactory::getApplication();	
     
    	 $db               = JFactory::getDBO();
		 $query            = "SELECT views FROM #__hdwplayer_videos WHERE id=".$id;
    	 $db->setQuery ( $query );
    	 $output           = $db->loadObjectList();
		 
		 $count            = $output[0]->views + 1;
	 
		 $query            = "UPDATE #__hdwplayer_videos SET views=".$count." WHERE id=".$id;
    	 $db->setQuery ( $query );
		 $db->query();
		 exit();
	}
	
}

?>