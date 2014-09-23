<?php
/**
* @package Redirect-On-Login (com_redirectonlogin)
* @version 3.1.0
* @copyright Copyright (C) 2008 - 2013 Carsten Engel. All rights reserved.
* @license GPL versions free/trial/pro
* @author http://www.pages-and-items.com
* @joomla Joomla is Free Software
*/

// No direct access
defined('_JEXEC') or die;

class JFormFieldDynamicredirectid extends JFormField{

	var $type = 'dynamicredirectid';
	
	 protected function getInput() {		
				 
		$database = JFactory::getDBO();	
		$array_dynamics = array();
		
		$array_dynamics[0]->id = '';
		$array_dynamics[0]->name = ' - '.JText::_("COM_REDIRECTONLOGIN_SELECT_DYNAMIC_REDIRECT").' - ';

		$database->setQuery("SELECT id, name "
		." FROM #__redirectonlogin_dynamics "		
		." ORDER BY name ASC "
		);
		$rows = $database->loadObjectList();
		$n = 1;
		foreach($rows as $row){			
			$array_dynamics[$n]->id = $row->id;
			$array_dynamics[$n]->name = addslashes($row->name);	
			$n++;
		}		
		
		return JHTML::_('select.genericlist', $array_dynamics, $this->name, '', 'id', 'name', $this->value ).'<span style="color: red; padding-left: 10px;">'.JText::_('COM_REDIRECTONLOGIN_NOT_IN_FREE_VERSION').'</span>';			
	}	

}

?>