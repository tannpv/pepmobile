<?php
/**
 * @version     1.0.0
 * @package     com_membership_directory
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomla Component <Joomla@Joomla.com> - http://www.joomla.org
 */

// No direct access
defined('_JEXEC') or die;

require_once JPATH_COMPONENT.'/controller.php';

/**
 * Directory controller class.
 */

class Membership_directoryControllerBoarddirectors extends Membership_directoryController
{
       public function getdatebox()
        {
        global $mainframe;
        
        $db = & JFactory::getDBO();
        $id=JRequest::getInt('id');//365;
      // Content Items only
        $query = " SELECT a.* FROM #__content as a ";
        $query .= " WHERE a.id =".$id;
        $db->setQuery($query);
      //  echo $query;
        $lists = $db->loadObjectList(); 
        echo $lists[0]->introtext ;exit;
           // echo "sfgsdhuhrdtrdhhy  htyer hyuiei  y ytert 5tewt 7e ty87e7 e4y5t87e55y 68e4y5"; exit;
        }
    
    
}