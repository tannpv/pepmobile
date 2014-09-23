<?php

require_once JPATH_SITE . '/components/com_content/helpers/route.php';

jimport('joomla.application.component.model');

JModel::addIncludePath(JPATH_SITE . '/components/com_content/models', 'ContentModel');

class modContend_MiddleHelper {
    
    function getContent($category_id){
        $db = JFactory::getDbo();
        
        $query = " SELECT * FROM jos_content WHERE catid = " . $category_id . " ORDER BY created DESC LIMIT 0,1 ";
        $db->setQuery($query);
        
        $content = $db->loadObject();
        
        return $content;
    }

}

?>