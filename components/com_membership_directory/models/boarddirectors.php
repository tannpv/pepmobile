<?php
/**
 * @version     1.0.0
 * @package     com_membership_directory
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomla Component <Joomla@Joomla.com> - http://www.joomla.org
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modelitem');
jimport('joomla.event.dispatcher');

/**
 * Membership_directory model.
 */
class Membership_directoryModelBoarddirectors extends JModelItem
{    protected $item;

     public function getItem() 
     	{
         global $mainframe;
      	$app	= JFactory::getApplication();
        $this->params = $app->getParams('com_membership_directory');
        $id= $this->params->get('idart');
        $db = & JFactory::getDBO();
        
        // Content Items only
        $query = " SELECT a.* FROM #__content as a ";
        $query .= " WHERE a.id =". $id;
              $db->setQuery($query);

        $lists = $db->loadObjectList();

        return $lists;
       }
    
}