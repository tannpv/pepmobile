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

class redirectonloginViewUser extends JViewLegacy{
	
	function display($tpl = null){
					
		$database = JFactory::getDBO();
		$ds = DIRECTORY_SEPARATOR;
		
		//get controller
		$controller = new redirectonloginController();	
		$this->assignRef('controller', $controller);	
		
		//get helper
		$helper = $this->get_helper();
		$this->assignRef('helper', $helper);	
		
		//get user id
		$user_id = intval(JRequest::getVar('user_id', ''));
		$this->assignRef('user_id', $user_id);
		
		//get redirect
		$database->setQuery("SELECT * "
		."FROM #__redirectonlogin_users "
		."WHERE user_id='$user_id' "
		."LIMIT 1 "
		);
		$redirects = $database->loadObjectList();
		$redirect = '';	
		$menuitem_login = 0;
		$dynamic_login = 0;	
		$menuitem_open = 0;
		$dynamic_open = 0;	
		$menuitem_logout = 0;
		$dynamic_logout = 0;	
		foreach($redirects as $temp){
			$redirect = $temp;	
			$menuitem_login = $temp->menuitem_login;
			$dynamic_login = $temp->dynamic_login;	
			$menuitem_open = $temp->menuitem_open;
			$dynamic_open = $temp->dynamic_open;	
			$menuitem_logout = $temp->menuitem_logout;
			$dynamic_logout = $temp->dynamic_logout;		
		}	
		$this->assignRef('redirect', $redirect);
		
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
		
		//get components
		$components_array = $this->controller->get_components_array();		
		$this->assignRef('components', $components_array);
		
		//get user name
		$database->setQuery("SELECT name, username "
		."FROM #__users "
		."WHERE id='$user_id' "
		."LIMIT 1 "
		);
		$users = $database->loadObjectList();
		$name = '';
		$username = '';
		foreach($users as $user){
			$name = $user->name;
			$username = $user->username;
		}	
		$this->assignRef('name', $name);
		$this->assignRef('username', $username);
			
			
		// Check for errors.
		if(count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		//toolbar		
		JToolBarHelper::apply('user_apply', 'JToolbar_Apply');
		JToolBarHelper::save('user_save', 'JToolbar_Save');
		JToolBarHelper::cancel('cancel', 'JToolbar_Close');		
		
		if($redirectonloginHelper->joomla_version >= '3.0'){
			//sidebar
			$this->add_sidebar($controller);	
		}
		
		parent::display($tpl);
	}	
	
	function get_helper(){
		$ds = DIRECTORY_SEPARATOR;
		require_once(JPATH_ROOT.$ds.'administrator'.$ds.'components'.$ds.'com_redirectonlogin'.$ds.'helpers'.$ds.'redirectonlogin.php');
		$helper = new redirectonloginHelper();
		return $helper;
	}
	
	function add_sidebar($controller){
	
		JHtmlSidebar::setAction('index.php?option=com_redirectonlogin&view=user');	
				
		$controller->add_submenu();			
		
		$this->sidebar = JHtmlSidebar::render();
	}
	
}
?>