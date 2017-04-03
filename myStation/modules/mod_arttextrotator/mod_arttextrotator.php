<?php
/**
* @module		Art ZoomIn
* @copyright	Copyright (C) 2010 artetics.com
* @license		GPL
*/

defined('_JEXEC') or die('Restricted access');
error_reporting(E_ERROR);
define ("DS", DIRECTORY_SEPARATOR);
$document = &JFactory::getDocument();
$moduleId = $module->id;

$loadJ = $params->get('loadJ', true);
$texts = $params->get('texts', '');
$links = $params->get('links', '');
$width = $params->get('width', 320);
$height = $params->get('height', 102);
$pause = $params->get('pause', 3000);
$rotateSpeed = $params->get('rotateSpeed', 2500);
$fadeSpeed = $params->get('fadeSpeed', 1000);

if ($loadJ) {
  $document->addScript(JURI::root() . 'modules/mod_arttextrotator/js/jquery.js');
}
$document->addScript(JURI::root() . 'modules/mod_arttextrotator/js/jquery.nc.js');
$document->addScript(JURI::root() . 'modules/mod_arttextrotator/js/script.js');
$document->addStylesheet(JURI::root() . 'modules/mod_arttextrotator/css/style.css');

$textsArray = explode ("\n", $texts);
$linksArray = explode ("\n", $links);

?>
<style type="text/css">
.jLetter .panel{
	width : <?php echo $width; ?>px;
	height : <?php echo $height; ?>px;
} 
</style>
<div id="textrotator_<?php echo $moduleId; ?>">
    <div>
        <?php
          for ($i = 0; $i < count($textsArray); $i++) {
          if ($links) {
        ?>
        <div class="slide"><p><a href="<?php echo trim($linksArray[$i]); ?>" title=""><?php echo $textsArray[$i]; ?></a></p></div>
        <?php
          } else {
        ?>
        <div class="slide"><p><?php echo $textsArray[$i]; ?></p></div>
        <?php
          }
          }
        ?>
    </div>
</div>
<script type="text/javascript" language="javascript">
    atrJQuery("document").ready(function(){
        atrJQuery("#textrotator_<?php echo $moduleId; ?>").jLetter({
            pause: <?php echo $pause; ?>,
            rotateSpeed: <?php echo $rotateSpeed; ?>,
            fadeSpeed: <?php echo $fadeSpeed; ?>
        });
    });
</script>