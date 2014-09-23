<?php
    defined('_JEXEC') or die('Restricted access.');
    require_once (dirname(__FILE__).DS.'helper.php');
    $item=  modTakeActionLeft::getArticle($params);
//    //$item2=  modTakeActionLeft::getArticle2($a);
    require JModuleHelper::getLayoutPath('mod_take_action_left');
?>