<?php
defined('_JEXEC') or die;
jimport('joomla.application.component.modellist');

class UploadpdfModelUploadpdfs extends JModelList{
    
   protected function getListQuery() {
        //create query
        $db=JFactory::getDbo();
        $query=$db->getQuery(true);
        $query->select('*');
        $query->from('#__uploadpdf');
        $query->order('`id` desc');
        //var_dump($query); exit;
        return $query; 
    }
}