<?php

/*
 * @version		$Id: video.php 3.2.2 2016-10-22 $
 * @package		Joomla
 * @copyright   Copyright (C) 2012-2016 HDW Player
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

class JElementVideo extends JElement {

	var	$_name = 'Video';

	function fetchElement($name, $value, &$node, $control_name)	{
		$db =& JFactory::getDBO();

		$query = 'SELECT a.id, a.title'
		. ' FROM #__hdwplayer_videos AS a'
		. ' WHERE a.published = 1'
		. ' ORDER BY a.title';
		$db->setQuery( $query );
		$options = $db->loadObjectList();

		array_unshift($options, JHTML::_('select.option', '0', '- '.JText::_('Display All Videos').' -', 'id', 'title'));
		
		return JHTML::_('select.genericlist',  $options, ''.$control_name.'['.$name.']', 'class="inputbox"', 'id', 'title', $value, $control_name.$name );
	}
}
 
?>