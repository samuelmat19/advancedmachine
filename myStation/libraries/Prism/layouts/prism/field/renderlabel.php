<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

extract($displayData);

/**
 * Layout variables
 * ---------------------
 *    $text         : (string)  The label text
 *    $description  : (string)  An optional description to use in a tooltip
 *    $for          : (string)  The id of the input this label is for
 *    $required     : (boolean) True if a required field
 *    $classes      : (array)   A list of classes
 *    $position     : (string)  The tooltip position. Bottom for alias
 */

$link = $field->getAttribute('link');
/** @var JFormFieldCfText $field  */

$classes = array_filter((array)$classes);

$id    = $for . '-lbl';
$title = '';

if ($description !== null and $description !== '') {
    JHtml::_('bootstrap.tooltip');
    $classes[] = 'hasTooltip';
    $title     = ' title="' . JHtml::tooltipText(trim($text, ':'), $description, 0) . '"';
}

if ($required) {
    $classes[] = 'required';
}
?>
<label id="<?php echo $id; ?>" for="<?php echo $for; ?>" class="<?php echo implode(' ', $classes); ?>"<?php echo $title; ?><?php echo $position; ?>>
    <?php echo $text; ?><?php if ($required) : ?><span class="star">&#160;*</span><?php endif; ?>
</label>

<?php if ($link !== null and $link !== '') {?>
<a href="<?php echo $link; ?>" class="btn btn-mini" role="button" target="_blank"><i class="icon icon-link"></i></a>
<?php } ?>
