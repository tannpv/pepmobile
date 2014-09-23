<?php
    defined('_JEXEC') or die('Restricted access.');
    require_once (dirname(__FILE__).DS.'helper.php');
    $item=  modTopnews::getTopnews();
    require JModuleHelper::getLayoutPath('mod_top_news');
?>