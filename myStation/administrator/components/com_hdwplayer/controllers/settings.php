<?php

/*
 * @version		$Id: settings.php 3.2.2 2016-10-22 $
 * @package		Joomla
 * @subpackage	hdwplayer
 * @copyright   Copyright (C) 2011-2016 HDW Player
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.controller' );

class HdwplayerControllerSettings extends HdwplayerController {

	function __construct() {
		parent::__construct();
    }

	function settings() {
	    $document = JFactory::getDocument();
		$vType	  = $document->getType();
	    $view     = $this->getView('settings', $vType);
		
        $model    = $this->getModel('settings');
			
        $view->setModel($model, true);
		$view->setLayout('default');
		$view->display();
	}
	
	function save()	{
		JRequest::checkToken() or die( 'Invalid Token' );
		
	  	$model = $this->getModel('settings');
	  	$model->save();
	}
	
}

?>