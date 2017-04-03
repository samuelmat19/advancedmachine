<?php
/**
 * @package         Gamification\User
 * @subpackage      Progress
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Gamification\User\Progress;

use Gamification\User\Level\Level as UserLevel;
use Gamification\Level\Level as BasicLevel;
use Prism\Utilities\MathHelper;
use Prism\Constants;

defined('JPATH_PLATFORM') or die;

/**
 * This is an object that represents user progress based on points and levels.
 *
 * @package         Gamification\User
 * @subpackage      Progress
 */
class ProgressLevels extends Progress
{
    /**
     * Prepare current and next levels.
     *
     * @throws \RuntimeException
     */
    public function prepareData()
    {
        $userPoints = (int)$this->points->getPointsNumber();

        // Get current level.
        $keys = array(
            'user_id'  => $this->points->getUserId(),
            'group_id' => $this->points->getPoints()->getGroupId(),
        );

        $userLevel = new UserLevel($this->db);
        $userLevel->load($keys);
        
        $this->currentUnit = $userLevel->getLevel();

        // Get incoming level.
        $query = $this->db->getQuery(true);
        $query
            ->select('a.id, a.title, a.value, a.published, a.points_id, a.points_number, a.rank_id, a.group_id')
            ->from($this->db->quoteName('#__gfy_levels', 'a'))
            ->where('a.points_id = ' . (int)$this->points->getPointsId())
            ->where('a.published = ' . (int)Constants::PUBLISHED)
            ->where('a.points_number > ' . $userPoints)
            ->order('a.points_number ASC');

        $this->db->setQuery($query, 0, 1);
        $result = (array)$this->db->loadAssoc();

        if (count($result) > 0) {
            $this->nextUnit    = new BasicLevel($this->db);
            $this->nextUnit->bind($result);

            $this->percentageCurrent    = (int)MathHelper::calculatePercentage($userPoints, $this->nextUnit->getPointsNumber());
            $this->percentageNext       = 100 - $this->percentageCurrent;
        } else {
            $this->percentageCurrent    = 100;
            $this->percentageNext       = 100;
        }
    }
}
