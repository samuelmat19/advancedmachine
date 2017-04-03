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
?>
<div class="gfy-mod-activities<?php echo $moduleclass_sfx;?>">
<?php for ($i = 0; $i < $numberItems; $i++) {
    if ($socialProfiles !== null) {
        $avatar = $socialProfiles->getAvatar($activities[$i]['user_id'], $avatarSize, $returnDefaultAvatar);
        if (!$avatar) {
            $avatar = '<img class="media-object" src="'.$defaultAvatar.'">';
        } else {
            $avatar = '<img class="media-object" src="'.$avatar.'">';
        }
    
        $link   =  $socialProfiles->getLink($activities[$i]['user_id']);
    } else {
        $avatar = '<img class="media-object" src="media/com_gamification/images/profile_50x50.png" width="50" height="50">';
        $link   = '';
    }

    $name = htmlspecialchars($activities[$i]['name'], ENT_QUOTES, 'UTF-8');
    if ($nameLinkable and $link) {
        $name = '<a href="'.$link.'">'.$name.'</a>';
    }?>
    <div class="media">
        <div class="media-left">
            <?php if ($link !== '') {?>
                <a href="<?php echo $link;?>"><?php echo $avatar; ?></a>
            <?php } else {
                echo $avatar;
            }?>
        </div>

        <div class="media-body">
            <h5 class="media-heading"><?php echo $name;?></h5>
            <p><?php echo htmlspecialchars($activities[$i]['content'], ENT_QUOTES, 'UTF-8');?></p>
            <?php if ($params->get('display_link', 0) and !empty($activities[$i]['url'])) {
                $title = (!empty($activities[$i]['title'])) ? JText::sprintf('MOD_GAMIFICATIONACTIVITIES_LINK_TO_S', $activities[$i]['title']) : JText::_('MOD_GAMIFICATIONACTIVITIES_LINK_TO');
                echo JHtml::_('gamification.link', $activities[$i]['url'], $title, array('class' => 'small'));
            }?>
        </div>
    </div>
<?php } ?>

</div>
