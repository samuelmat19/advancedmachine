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
<?php foreach ($this->items as $i => $item) {?>
    <tr class="row<?php echo $i % 2; ?>">
        <td class="center hidden-phone">
            <?php echo JHtml::_('grid.id', $i, $item->id); ?>
        </td>
        <td class="center">
            <?php echo JHtml::_('jgrid.published', $item->published, $i, 'currencies.'); ?>
        </td>
        <td>
            <a href="<?php echo JRoute::_('index.php?option=com_virtualcurrency&view=currency&layout=edit&id=' . $item->id); ?>">
                <?php echo $this->escape($item->title); ?>
            </a>
        </td>
        <td class="center hidden-phone">
            <?php if ($item->image_icon) { ?>
            <img src="<?php echo $this->mediaFolderUrl . '/' . $item->image_icon; ?>" />
            <?php } ?>
        </td>
        <td class="hidden-phone">
            <?php echo JHtml::_('virtualcurrency.price', $item, $this->money, $this->realCurrency, $this->virtualCurrencies); ?>
        </td>
        <td class="hidden-phone">
            <?php echo JHtml::_('virtualcurrency.currencyDetails', $item); ?>
        </td>
        <td class="center hidden-phone">
            <?php echo $item->id; ?>
        </td>
    </tr>
<?php } ?>
