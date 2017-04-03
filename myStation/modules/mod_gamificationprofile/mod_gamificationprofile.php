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

// Get component parameters
$componentParams = JComponentHelper::getParams('com_gamification');

$filesystemHelper   = new Prism\Filesystem\Helper($componentParams);
$mediaFolder  = $filesystemHelper->getMediaFolder();

// Get user ID.
JLoader::register('Prism\\Integration\\Helper', PRISM_PATH_LIBRARY . '/integration/helper.php');
$userId  = Prism\Integration\Helper::getUserId();
$user    = JFactory::getUser($userId);

if ($params->get('display_points')) {
    $keys = array(
        'user_id'   => $userId,
        'points_id' => $params->get('points_points_id')
    );

    $userPoints = new Gamification\User\Points\Points(JFactory::getDbo());
    $userPoints->load($keys);
}

if ($params->get('display_level')) {
    $keys = array(
        'user_id'  => $userId,
        'group_id' => $params->get('level_group_id')
    );

    $level = new Gamification\User\Level\Level(JFactory::getDbo());
    $level->load($keys);
}

if ($params->get('display_rank')) {
    $keys = array(
        'user_id'  => $userId,
        'group_id' => $params->get('rank_group_id')
    );

    $rank = new Gamification\User\Rank\Rank(JFactory::getDbo());
    $rank->load($keys);
}

if ($params->get('display_badges')) {
    $keys = array(
        'user_id'  => $userId,
        'group_id' => $params->get('badges_group_id')
    );

    $badges = new Gamification\User\Badge\Badges(JFactory::getDbo());
    $badges->load($keys);
}

if ($params->get('display_progress_bar')) {
    $keys = array(
        'user_id'   => $userId,
        'points_id' => $params->get('progress_points_id')
    );

    $userPoints = new Gamification\User\Points\Points(JFactory::getDbo());
    $userPoints->load($keys);
    
    if ($userPoints->getId()) {
        $mechanic = $params->get('progress_bar_mechanic', 'levels');

        switch ($mechanic) {
            case 'badges':
                $progress = new Gamification\User\Progress\ProgressBadges(JFactory::getDbo(), $userPoints);
                break;

            case 'ranks':
                $progress = new Gamification\User\Progress\ProgressRanks(JFactory::getDbo(), $userPoints);
                break;

            default: // Levels
                $progress = new Gamification\User\Progress\ProgressLevels(JFactory::getDbo(), $userPoints);
                break;
        }

        $progress->prepareData();

        $tooltipTitleNext = '';
        if ($progress->hasNext()) {
            $nextUnit         = $progress->getNextUnit();
            $neededPoints     = (int)$nextUnit->getPointsNumber() - (int)$userPoints->getPointsNumber();
            $tooltipTitleNext = JText::sprintf('MOD_GAMIFICATIONPROFILE_POINTS_' . strtoupper($mechanic) . '_INFORMATION_REACH', $neededPoints, $nextUnit->getTitle());
        }

        $progressData = array(
            'tooltip'             => $params->get('display_progressbar_tip', 0),
            'name'                => $user->get('name'),
            'tooltipTitleCurrent' => JText::sprintf('MOD_GAMIFICATIONPROFILE_POINTS_INFORMATION', $user->get('name'), $userPoints->getPointsNumber()),
            'tooltipTitleNext'    => $tooltipTitleNext
        );

        $progressbar = new Gamification\Mechanic\Progressbar($progress);
        $progressbar->addLayoutPath(GAMIFICATION_PATH_COMPONENT_SITE . '/layouts');
    }
}

$placeholders = array(
    'name' => $user->get('name')
);

require JModuleHelper::getLayoutPath('mod_gamificationprofile', $params->get('layout', 'default'));