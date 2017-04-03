<?php
/**
 * @package      Gamification Platform
 * @subpackage   Modules
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('Prism.init');
jimport('Gamification.init');

$doc = JFactory::getDocument();
$doc->addStyleSheet(JURI::root().'modules/mod_gamificationbar/css/style.css');
$doc->addScript(JURI::root().'modules/mod_gamificationbar/js/jquery.gamificationnotifications.js');

$js = '
    jQuery(document).ready(function() {
        jQuery("#js-gfy-ntfy").GamificationNotifications({
            resultsLimit: '.$params->get('results_limit', 5).'
        });
    });
';
$doc->addScriptDeclaration($js);

require JModuleHelper::getLayoutPath('mod_gamificationbar', $params->get('layout', 'default'));