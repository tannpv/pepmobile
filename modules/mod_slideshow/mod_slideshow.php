<?php
    defined('_JEXEC') or die('Restricted access.');
    require_once (dirname(__FILE__).DS.'helper.php');
    $items=  modSlideshow::getImgSlideshow();
    require JModuleHelper::getLayoutPath('mod_slideshow');
?>