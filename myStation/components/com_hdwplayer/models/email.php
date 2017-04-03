<?php

/*
 * @version		$Id: email.php 3.2.2 2016-10-22 $
 * @package		Joomla
 * @subpackage	hdwplayer
 * @copyright   Copyright (C) 2011-2016 HDW Player
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class HdwplayerModelEmail extends HdwplayerModel {

	function __construct() {
		parent::__construct();
    }
	
	function sendMail()
    {	
		$mailer    = JFactory::getMailer();
		
		$sender    = array(JRequest::getString('from')); 
		$mailer->setSender($sender);
		
        $recipient = JRequest::getString('to'); 
        $mailer->addRecipient($recipient);
		
		$body     = JRequest::getString('message')."\n\nPlease check the Following Video. Hope! you will enjoy it. Video :  ";
		$body     .= JRequest::getString('url');
		$mailer->setSubject('You Have received a Video!');
		$mailer->setBody($body);
		
		if ( !$mailer->Send() ) {
   			echo 'output='.$body;
		} else {
    		echo 'output=success';
		}
				
	}	
	
}

?>