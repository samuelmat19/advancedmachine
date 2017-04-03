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

$doc = JFactory::getDocument();
$doc->addStyleSheet(JUri::root().'modules/mod_gamificationleaderboard/css/style.css');
?>
<div class="gfy-modlb<?php echo $moduleclass_sfx;?>">

<?php for ($i = 0; $i < $numberItems; $i++) {
    switch ($pointsType) {
        case 'abbr':
            $pointsTypeClean = htmlspecialchars($leaderboard[$i]->abbr, ENT_QUOTES, 'UTF-8');
            break;

        case 'title':
            $pointsTypeClean = strtolower(htmlspecialchars($leaderboard[$i]->title, ENT_QUOTES, 'UTF-8'));
            break;

        default:
            $pointsTypeClean = '';
            break;
    }

    $link = ($socialProfiles !== null) ? $socialProfiles->getLink($leaderboard[$i]->user_id) : '';

    $avatarOptions = array(
        'user_id' => $leaderboard[$i]->user_id,
        'name'    => $leaderboard[$i]->name,
        'size'    => $avatarSize,
        'default' => $componentParams->get('integration_avatars_default'),
        'link'    => $link,
        'class'   => 'media-object'
    );

    $name = htmlspecialchars($leaderboard[$i]->name, ENT_QUOTES, 'UTF-8');
    if ($nameLinkable and $link) {
        $name = '<a href="'.$link.'">'.$name.'</a>';
    }?>
    <div class="media">
    <?php if ($displayNumber) {?>
        <div class="pull-left gfy-modlb-number"><?php echo $i + 1;?></div>
    <?php } ?>
        <div class="media-left">
            <?php echo JHtml::_('gamification.avatar', $socialProfiles, $avatarOptions);?>
        </div>

        <div class="media-body">
            <h5 class="media-heading">
                <?php echo $name;?>
            </h5>
            <p class="gfy-media-points">
                <?php echo (int)$leaderboard[$i]->points_number.' '.$pointsTypeClean;?>
            </p>
        </div>

    </div>
<?php }?>
</div>
