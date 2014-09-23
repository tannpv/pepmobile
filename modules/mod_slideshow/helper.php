<?php
    class modSlideshow
    {
        function getImgSlideshow() 
        {                   
            $db=& JFactory::getDBO();
            $query="select * from jos_phocagallery where published = '1' order by ordering ASC";
            $db->setQuery($query);
            $list=$db->loadObjectList();
            return $list;
        }
    }

?>