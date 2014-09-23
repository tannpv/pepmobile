<?php
/**
* @package Redirect-On-Login (com_redirectonlogin)
* @version 3.1.0
* @copyright Copyright (C) 2008 - 2013 Carsten Engel. All rights reserved.
* @license GPL versions free/trial/pro
* @author http://www.pages-and-items.com
* @joomla Joomla is Free Software
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view');

class redirectonloginViewAccesslevel extends JViewLegacy{
	
	function display($tpl = null){
					
		$database = JFactory::getDBO();
		$ds = DIRECTORY_SEPARATOR;
		
		//get controller
		$controller = new redirectonloginController();	
		$this->assignRef('controller', $controller);
		
		//get group id
		$group_id = intval(JRequest::getVar('group_id', ''));
		$this->assignRef('group_id', $group_id);
		
		//get redirect
		$database->setQuery("SELECT * "
		."FROM #__redirectonlogin_levels "
		."WHERE group_id='$group_id' "
		."LIMIT 1 "
		);
		$items = $database->loadObjectList();
		$item = '';
		$menuitem_login = 0;
		$dynamic_login = 0;	
		$menuitem_open = 0;
		$dynamic_open = 0;	
		$menuitem_logout = 0;
		$dynamic_logout = 0;
		$inherit_login = 0;
		$inherit_open = 0;
		$inherit_logout = 0;
		foreach($items as $item_temp){
			$item = $item_temp;
			$menuitem_login = $item_temp->menuitem_login;
			$dynamic_login = $item_temp->dynamic_login;	
			$menuitem_open = $item_temp->menuitem_open;
			$dynamic_open = $item_temp->dynamic_open;	
			$menuitem_logout = $item_temp->menuitem_logout;
			$dynamic_logout = $item_temp->dynamic_logout;
			$inherit_login = $item_temp->inherit_login;
			$inherit_open = $item_temp->inherit_open;
			$inherit_logout = $item_temp->inherit_logout;
		}	
		$this->assignRef('item', $item);	
		
		//get helper for menuitem selects and dynamic selects	
		require_once(JPATH_ROOT.$ds.'administrator'.$ds.'components'.$ds.'com_redirectonlogin'.$ds.'helpers'.$ds.'redirectonlogin.php');
		$redirectonloginHelper = new redirectonloginHelper();		
		
		$menuitem_login_select = $redirectonloginHelper->menuitems('menuitem_login', '', array($menuitem_login));	
		$this->assignRef('menuitem_login_select', $menuitem_login_select);
		
		$dynamic_login_select = $redirectonloginHelper->get_dynamics_select('dynamic_login', $dynamic_login);	
		$this->assignRef('dynamic_login_select', $dynamic_login_select);
		
		$menuitem_open_select = $redirectonloginHelper->menuitems('menuitem_open', '', array($menuitem_open));	
		$this->assignRef('menuitem_open_select', $menuitem_open_select);
		
		$dynamic_open_select = $redirectonloginHelper->get_dynamics_select('dynamic_open', $dynamic_open);	
		$this->assignRef('dynamic_open_select', $dynamic_open_select);
		
		$menuitem_logout_select = $redirectonloginHelper->menuitems('menuitem_logout', '', array($menuitem_logout));	
		$this->assignRef('menuitem_logout_select', $menuitem_logout_select);
		
		$dynamic_logout_select = $redirectonloginHelper->get_dynamics_select('dynamic_logout', $dynamic_logout);	
		$this->assignRef('dynamic_logout_select', $dynamic_logout_select);	
		
		$inherit_login_select = $this->get_acceslevel_select('inherit_login', $inherit_login);	
		$this->assignRef('inherit_login_select', $inherit_login_select);
		
		$inherit_open_select = $this->get_acceslevel_select('inherit_open', $inherit_open);	
		$this->assignRef('inherit_open_select', $inherit_open_select);
		
		$inherit_logout_select = $this->get_acceslevel_select('inherit_logout', $inherit_logout);	
		$this->assignRef('inherit_logout_select', $inherit_logout_select);
		
		
		
		//get usergroup name
		$database->setQuery("SELECT title "
		."FROM #__viewlevels "
		."WHERE id='$group_id' "
		."LIMIT 1 "
		);
		$groups = $database->loadObjectList();
		$group_title = '';
		foreach($groups as $group){
			$group_title = $group->title;
		}	
		$this->assignRef('group_title', $group_title);
			
			
		// Check for errors.
		if(count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		//toolbar		
		JToolBarHelper::apply('accesslevel_apply', 'JToolbar_Apply');
		JToolBarHelper::save('accesslevel_save', 'JToolbar_Save');
		JToolBarHelper::cancel('cancel', 'JToolbar_Close');		
		
		if($redirectonloginHelper->joomla_version >= '3.0'){
			//sidebar
			$this->add_sidebar($controller);	
		}
		
		parent::display($tpl);
	}	
	
	function get_levels(){
		
		return $accesslevels;		
	}
	
	function get_acceslevel_select($element_name, $selection){	
	
		$database = JFactory::getDBO();
		
		$database->setQuery("SELECT id, title "
		."FROM #__viewlevels "
		."ORDER BY ordering ASC "		
		);
		$levels = $database->loadObjectList();		
							
		$accesslevels_select = '<select name="'.$element_name.'">';			
		$accesslevels_select .= '<option value="0"> - '.JText::_('COM_REDIRECTONLOGIN_SELECT_ACCESSLEVEL').' - </option>';			
		foreach ($levels as $level){				
			$accesslevels_select .= '<option';
			if($level->id==$selection){
				$accesslevels_select .= ' selected="selected"';
			}
			$accesslevels_select .= ' value="'.$level->id.'">'.$level->title.'</option>';
		}
		$accesslevels_select .= '</select>';
		
		return $accesslevels_select;
	}
	
	function add_sidebar($controller){
	
		JHtmlSidebar::setAction('index.php?option=com_redirectonlogin&view=accesslevel');	
				
		$controller->add_submenu();			
		
		$this->sidebar = JHtmlSidebar::render();
	}
	
}
?>