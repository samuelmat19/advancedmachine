<?php
/**
 * @package      Virtualcurrency
 * @subpackage   Components
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */
// no direct access
defined('_JEXEC') or die;
?>
<?php if (!empty($this->sidebar)): ?>
<div id="j-sidebar-container" class="span2">
    <?php echo $this->sidebar; ?>
</div>
<div id="j-main-container" class="span10">
    <?php else : ?>
<div id="j-main-container">
    <?php endif; ?>

    <div class="span8">

    </div>
    <div class="span4">
        <a href="http://itprism.com/free-joomla-extensions/ecommerce-gamification/virtual-currency-accounts-manager" target="_blank"><img src="../media/com_virtualcurrency/images/logo.png" alt="<?php echo JText::_('COM_VIRTUALCURRENCY'); ?>"/></a>
        <a href="http://itprism.com" target="_blank"><img src="../media/com_virtualcurrency/images/product_of_itprism.png" alt="<?php echo JText::_('COM_VIRTUALCURRENCY_PRODUCT'); ?>"/></a>
        <p><?php echo JText::_('COM_VIRTUALCURRENCY_YOUR_VOTE'); ?></p>
        <p><?php echo JText::_('COM_VIRTUALCURRENCY_SUBSCRIPTION'); ?></p>
        <table class="table table-striped">
            <tbody>
            <tr>
                <td><?php echo JText::_('COM_VIRTUALCURRENCY_INSTALLED_VERSION'); ?></td>
                <td><?php echo $this->version->getShortVersion(); ?></td>
            </tr>
            <tr>
                <td><?php echo JText::_('COM_VIRTUALCURRENCY_RELEASE_DATE'); ?></td>
                <td><?php echo $this->version->releaseDate ?></td>
            </tr>
            <tr>
                <td><?php echo JText::_('COM_VIRTUALCURRENCY_PRISM_LIBRARY_VERSION'); ?></td>
                <td><?php echo $this->prismVersion; ?></td>
            </tr>
            <tr>
                <td><?php echo JText::_('COM_VIRTUALCURRENCY_COPYRIGHT'); ?></td>
                <td><?php echo $this->version->copyright; ?></td>
            </tr>
            <tr>
                <td><?php echo JText::_('COM_VIRTUALCURRENCY_LICENSE'); ?></td>
                <td><?php echo $this->version->license; ?></td>
            </tr>
            </tbody>
        </table>

        <?php if (!empty($this->prismVersionLowerMessage)) {?>
            <p class="alert alert-warning upgrade-info"><i class="icon-warning"></i> <?php echo $this->prismVersionLowerMessage; ?></p>
        <?php } ?>
        <p class="alert alert-info cf-upgrade-info"><i class="icon-info"></i> <?php echo JText::_('COM_VIRTUALCURRENCY_HOW_TO_UPGRADE'); ?></p>
        <div class="alert alert-info"><i class="icon-comment"></i> <?php echo JText::_('COM_VIRTUALCURRENCY_FEEDBACK_INFO'); ?></div>
    </div>

</div>