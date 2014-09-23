<?php
defined('_JEXEC') or die;
jimport('jomla.application.component.controller');
class BpsmemberController extends JController{
    
    function display($cachable=false){
        JRequest::setVar("view", JRequest::getCmd('view','bpsmembers'));
        parent::display($cachable);
    }
    
}