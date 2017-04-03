<?php

/*
 * @version		$Id: mod_hdwplayersearch.php 3.2.2 2016-10-22 $
 * @package		Joomla
 * @subpackage	hdwplayer
 * @copyright   Copyright (C) 2011-2016 HDW Player
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>

<div align="center">
  <form action="<?php echo JRoute::_('index.php?option=com_hdwplayer&view=search'); ?>" name="hsearch" id="hsearch" method="post" enctype="multipart/form-data"  >
    <input type="text" name="hdwplayersearch" id="hdwplayersearch" style="width:75%" value="" />
    <input type="submit" name="search_btn" id="search_btn" value="Go" />
  </form>
</div>