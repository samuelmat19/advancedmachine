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
$doc->addStyleSheet(JURI::root().'modules/mod_gamificationleaderboard/css/style.css');
?>
<div class="gfy-modlb<?php echo $moduleclass_sfx;?>">
<?php for($i = 0; $i < $numberItems; $i++) {
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
        <?php if($displayNumber) {?>
        <div class="pull-left"><?php echo $i + 1;?></div>
        <?php }?>
        
        <a class="pull-left" href="<?php echo $link;?>">
            <?php echo JHtml::_('gamification.avatar', $socialProfiles, $avatarOptions);?>
        </a>
            
        <div class="media-body">
            <h5 class="media-heading"><?php echo $name;?></h5>
            <?php if($displayLevelTitle) {?>
            <p class="gfy-media-level">
                <?php echo htmlspecialchars($leaderboard[$i]->title, ENT_QUOTES, 'UTF-8');?>
                <?php if($displayLevelRank AND !empty($leaderboard[$i]->rank)) {?>
                ( <?php echo htmlspecialchars($leaderboard[$i]->rank, ENT_QUOTES, 'UTF-8');?> )
                <?php } ?>
            </p>
            <?php }?>
        </div>
        
    </div>
        
<?php }?>
</div>