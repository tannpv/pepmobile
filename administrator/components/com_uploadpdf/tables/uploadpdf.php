<?php

defined('_JEXEC') or die;
jimport('joomla.database.table');
class UploadpdfTableUploadpdf extends JTable{
    
    function __construct(&$db){
        parent::__construct('#__uploadpdf','id',$db);
    }
}