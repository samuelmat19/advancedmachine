<?php

/*
 * @version		$Id: hdwplayercategory.php 3.2.2 2016-10-22 $
 * @package		Joomla
 * @subpackage	hdwplayer
 * @copyright   Copyright (C) 2011-2016 HDW Player
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Include library dependencies
jimport('joomla.filter.input');

class TableHdwplayerCategory extends JTable {

	var $id              = null;
	var $name            = null;
	var $parent          = null;
	var $ordering        = null;
	var $type            = null;
	var $image           = null;
	var $metakeywords    = null;
	var $metadescription = null;
	var $published       = 0;

	function __construct(& $db) {
		parent::__construct('#__hdwplayer_category', 'id', $db);
	}

	function check() {
		return true;
	}
	
}

?>