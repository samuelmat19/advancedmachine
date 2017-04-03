<?php

/*
 * @version		$Id: model.php 3.2.2 2016-10-22 $
 * @package		Joomla
 * @subpackage	hdwplayer
 * @copyright   Copyright (C) 2011-2016 HDW Player
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

if (version_compare(JVERSION, '3.0', 'ge')) {

    class HdwplayerModel extends JModelLegacy {
	
        public static function addIncludePath($path = '', $prefix = '') {
            return parent::addIncludePath($path, $prefix);
        }

    }

} else if (version_compare(JVERSION, '2.5', 'ge')) {

    class HdwplayerModel extends JModel {
	
        public static function addIncludePath($path = '', $prefix = '') {
            return parent::addIncludePath($path, $prefix);
        }

    }

} else {

    class HdwplayerModel extends JModel {
	
        public function addIncludePath($path = '', $prefix = '') {
            return parent::addIncludePath($path);
        }

    }

}

?>