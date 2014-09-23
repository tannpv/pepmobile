<?php
defined('_JEXEC') or die;
jimport('joomla.application.component.controlleradmin');

class BpsmemberControllerBpsmembers extends JControllerAdmin{
    
    public function getModel($name='Bpsmember', $prefix='BpsmemberModel'){
        $model=parent::getModel($name,$prefix, array('ignore_request' => true));
        return $model;
    }
}