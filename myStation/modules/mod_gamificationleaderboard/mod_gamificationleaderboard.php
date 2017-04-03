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

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
$componentParams = JComponentHelper::getParams('com_gamification');
$imagePath       = $componentParams->get('images_directory', 'images/gamification');
$leaderboard     = array();
$layout          =  $params->get('layout', 'default');

switch ($layout) {
    case 'levels':
        $displayLevelTitle  = $params->get('levels_display_title', 1);
        $displayLevelRank   = $params->get('levels_display_rank', 0);
        
        $options = array(
            'group_id' => $params->get('levels_group_id'),
            'sort_direction' => 'DESC',
            'limit'          => $params->get('results_number', 10)
        );

        /** @var $leaderboard Gamification\Leaderboard\Levels */
        $leaderboard    = new Gamification\Leaderboard\Levels(JFactory::getDbo());
        $leaderboard->load($options);
        break;
        
    default: // Points
        $pointsType     = $params->get('points_display_type', 'abbr');
        
        $options = array(
            'points_id'      => $params->get('points_id'),
            'sort_direction' => 'DESC',
            'limit'          => $params->get('results_number', 10)
        );

        /** @var $leaderboard Gamification\Leaderboard\Points */
        $leaderboard    = new Gamification\Leaderboard\Points(JFactory::getDbo());
        $leaderboard->load($options);
        break;
}

$displayNumber  = $params->get('display_number', 1);
$nameLinkable   = $params->get('name_linkable', 1);
$avatarSize     = $params->get('integration_avatars_size', 'small');
$socialPlatform = $componentParams->get('integration_social_platform');

$socialProfiles = null;
$numberItems    = count($leaderboard);

if ($socialPlatform !== null and $numberItems > 0) {
    $usersIds = Prism\Utilities\ItemHelper::fetchIds($leaderboard->toArray(), 'user_id');

    $config = new \Joomla\Registry\Registry(array(
        'platform' => $socialPlatform,
        'user_ids' => $usersIds
    ));

    $socialProfilesBuilder = new Prism\Integration\Profiles\Factory($config);
    $socialProfiles        = $socialProfilesBuilder->create();
}

require JModuleHelper::getLayoutPath('mod_gamificationleaderboard', $params->get('layout', 'default'));
