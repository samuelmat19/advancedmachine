<?php

/*
 * @version		$Id: dashboard.php 3.2.2 2016-10-22 $
 * @package		Joomla
 * @subpackage	hdwplayer
 * @copyright   Copyright (C) 2011-2016 HDW Player
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.controller' );

class HdwplayerControllerDashboard extends HdwplayerController {

    function __construct() {		
        $this->item_type = 'Default';
        parent::__construct();
    }
	
	function dashboard() {
	    $document = JFactory::getDocument();
		$vType	  = $document->getType();
	    $view     = $this->getView('dashboard', $vType);
		
        $model    = $this->getModel('dashboard');
		
        $view->setModel($model, true);
		$view->setLayout('default');
		$view->display();
	}
	
}

?>