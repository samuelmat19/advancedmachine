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

JFactory::getDocument()->addStyleSheet(JUri::root() . 'modules/mod_gamificationprofile/css/style.css');
?>
<div class="row">
    <?php if ($params->get('display_points', 0)) {?>
    <div class="col-xs-12 col-md-4 gfy-modprofile-points">
        <h4><?php echo JText::_('MOD_GAMIFICATIONPROFILE_POINTS');?></h4>
        <p class="gfy-modprofile-points-value">
        <?php if ($params->get('display_points_abbr', 0)) {
            echo $userPoints;
        } else {
            echo $userPoints->getPointsNumber();
        }?>
        <p>
    </div>
    <?php }?>

    <?php if ($params->get('display_level', 0)) {?>
    <div class="col-xs-12 col-md-4 gfy-modprofile-level">
        <h4><?php echo JText::_('MOD_GAMIFICATIONPROFILE_LEVEL');?></h4>
        <p class="gfy-modprofile-level-value"><?php echo $level->getLevel();?><p>

    <?php if ($level->getId()) { ?>

        <?php if ($params->get('display_level_title', 0)) {?>
        <p><?php echo $level->getLevel()->getTitle(); ?></p>
        <?php }?>

        <?php if ($params->get('display_level_rank', 0) and $level->getRank()->getRankId()) {?>
        <p><?php echo $level->getRank()->getTitle(); ?></p>
        <?php }?>

    <?php }?>

    </div>
    <?php } ?>

    <?php if ($params->get('display_rank')) {?>
    <div class="col-xs-12 col-md-4 gfy-modprofile-rank">
        <h4><?php echo JText::_('MOD_GAMIFICATIONPROFILE_RANK');?></h4>

        <?php if ($rank->getId()) { ?>
            <?php if ($params->get('display_rank_picture')) {?>
                <?php echo JHtml::_('gamification.rank', $rank, $mediaFolder, $params->get('display_rank_description', 0), $placeholders); ?>
            <?php } ?>

            <p><?php echo $rank->getRank()->getTitle();?><p>
        <?php } ?>
    </div>
    <?php } ?>

</div>

<?php if ($params->get('display_badges', 0)) { ?>
<div class="row">
    <div class="col-xs-12 gfy-modprofile-badges">
    <h4><?php echo JText::_('MOD_GAMIFICATIONPROFILE_BADGES');?></h4>
    <?php
    $badges_ = $badges->getBadges($params->get('badges_group_id'));
    foreach ($badges_ as $badge) {
        echo JHtml::_('gamification.badge', $badge, $mediaFolder, $params->get('display_badge_description', 0), $placeholders);
    }
    ?>
    </div>
</div>
<?php }?>

<?php if ($params->get('display_progress_bar', 0) and $userPoints->getId()) { ?>
<div class="row">
    <div class="col-xs-12 gfy-modprofile-progress">
        <h4><?php echo JText::_('MOD_GAMIFICATIONPROFILE_PROGRESS');?></h4>
        <?php echo $progressbar->render($progressData);?>
    </div>
</div>
<?php }?>