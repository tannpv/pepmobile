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

class redirectonloginViewConfiguration extends JViewLegacy{
	
	function display($tpl = null){
					
		$database = JFactory::getDBO();
		$ds = DIRECTORY_SEPARATOR;
		
		//get configuration
		$controller = new redirectonloginController();	
		$this->assignRef('controller', $controller);
		
		//get components
		$components_array = $this->controller->get_components_array();		
		$this->assignRef('components', $components_array);			
		
		//get helper for menuitem selects and dynamic selects	
		require_once(JPATH_ROOT.$ds.'administrator'.$ds.'components'.$ds.'com_redirectonlogin'.$ds.'helpers'.$ds.'redirectonlogin.php');
		$redirectonloginHelper = new redirectonloginHelper();
		
		$menuitem_login = $this->controller->rol_config['menuitem_login'];			
		$this->assignRef('menuitem_login', $menuitem_login);
		$menuitem_login_select = $redirectonloginHelper->menuitems('menuitem_login', '', array($menuitem_login));	
		$this->assignRef('menuitem_login_select', $menuitem_login_select);
		
		$dynamic_login = $this->controller->rol_config['dynamic_login'];			
		$this->assignRef('dynamic_login', $dynamic_login);
		$dynamic_login_select = $redirectonloginHelper->get_dynamics_select('dynamic_login', $dynamic_login);	
		$this->assignRef('dynamic_login_select', $dynamic_login_select);
		
		$menuitem_open = $this->controller->rol_config['menuitem_open'];				
		$this->assignRef('menuitem_open', $menuitem_open);
		$menuitem_open_select = $redirectonloginHelper->menuitems('menuitem_open', '', array($menuitem_open));	
		$this->assignRef('menuitem_open_select', $menuitem_open_select);
		
		$dynamic_open = $this->controller->rol_config['dynamic_open'];			
		$this->assignRef('dynamic_open', $dynamic_open);
		$dynamic_open_select = $redirectonloginHelper->get_dynamics_select('dynamic_open', $dynamic_open);	
		$this->assignRef('dynamic_open_select', $dynamic_open_select);		
		
		$menuitem_logout = $this->controller->rol_config['menuitem_logout'];				
		$this->assignRef('menuitem_logout', $menuitem_logout);
		$menuitem_logout_select = $redirectonloginHelper->menuitems('menuitem_logout', '', array($menuitem_logout));	
		$this->assignRef('menuitem_logout_select', $menuitem_logout_select);
		
		$dynamic_logout = $this->controller->rol_config['dynamic_logout'];			
		$this->assignRef('dynamic_logout', $dynamic_logout);
		$dynamic_logout_select = $redirectonloginHelper->get_dynamics_select('dynamic_logout', $dynamic_logout);	
		$this->assignRef('dynamic_logout_select', $dynamic_logout_select);

		//toolbar
		// Options button.
		if (JFactory::getUser()->authorise('core.admin', 'com_redirectonlogin')) {
			JToolBarHelper::preferences('com_redirectonlogin');
		}		
		JToolBarHelper::apply('config_save', 'JToolbar_Apply');	
		
		if($redirectonloginHelper->joomla_version >= '3.0'){
			//sidebar
			$this->add_sidebar($controller);	
		}			
		
		parent::display($tpl);
	}
	
	function add_sidebar($controller){
	
		JHtmlSidebar::setAction('index.php?option=com_redirectonlogin&view=configuration');	
				
		$controller->add_submenu();			
		
		$this->sidebar = JHtmlSidebar::render();
	}	
	

	
}
?>