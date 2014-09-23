<?php
    class modTopnews
    {
        function getTopnews() 
        {                   
            $db=& JFactory::getDBO();
            $query="SELECT * FROM jos_content WHERE catid = '90' and featured = '1' ORDER BY created DESC LIMIT 0,1";
            $db->setQuery($query);
            $list=$db->loadObject();
            return $list;
        }
    }

?>