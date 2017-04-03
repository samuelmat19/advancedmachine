<?php
/**
 * @package      Gamification Platform
 * @subpackage   Modules
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

// no direct access
defined("_JEXEC") or die;

jimport('Prism.init');
jimport('Gamification.init');

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

// Get component parameters
$componentParams = JComponentHelper::getParams('com_gamification');

// Load helpers
JHtml::addIncludePath(GAMIFICATION_PATH_COMPONENT_SITE.'/helpers/html');

$imagePath       = $componentParams->get('images_directory', 'images/gamification');

$options = array(
    'sort_direction' => 'DESC',
    'limit'          => $params->get('results_number', 10)
);

$activities     = new Gamification\Activity\Activities(JFactory::getDbo());
$activities->load($options);

$avatarSize      = $params->get('integration_avatars_size', 'small');
$defaultAvatar   = $componentParams->get('integration_avatars_default');

$nameLinkable    = $params->get('name_linkable', 1);
$socialPlatform  = $componentParams->get('integration_social_platform');

$socialProfiles = null;
$numberItems    = count($activities);

if ($socialPlatform !== null and $numberItems > 0) {
    $usersIds = Prism\Utilities\ItemHelper::fetchIds($activities->toArray(), 'user_id');

    $config = new \Joomla\Registry\Registry(array(
        'platform' => $socialPlatform,
        'user_ids' => $usersIds
    ));

    $socialBuilder  = new Prism\Integration\Profiles\Factory($config);
    $socialProfiles = $socialBuilder->create();

    $returnDefaultAvatar = Prism\Constants::RETURN_DEFAULT;
    if ($socialPlatform === 'easyprofile') {
        $returnDefaultAvatar = Prism\Constants::DO_NOT_RETURN_DEFAULT;
    }
}

require JModuleHelper::getLayoutPath('mod_gamificationactivities', $params->get('layout', 'default'));