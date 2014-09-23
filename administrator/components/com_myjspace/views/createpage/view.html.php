<?php
/**
* @version $Id: view.php $ 
* @version		1.8.0 08/04/2012
* @package		com_myjspace
* @author       Bernard Saulmé
* @copyright	Copyright (C) 2011-2012 Bernard Saulmé
* @license      GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

class MyjspaceViewCreatepage extends JView
{
	/**
	 * display method of BSbanner view
	 * @return void
	 **/
	function display($tpl = null)
	{
        require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'user_event.php';
		
	// Menu bar
		if ( version_compare(JVERSION,'1.6.0','ge') )
			$add_icon = 'article-add.png';
		else
			$add_icon = 'addedit.png';
			
		JToolBarHelper::title( JText::_( 'COM_MYJSPACE_HOME' ) .': <small>'.JText::_( 'COM_MYJSPACE_CREATEPAGE' ).'</small>', $add_icon);
		JToolBarHelper::apply('adm_create_page');	
		JToolBarHelper::divider();

		$model_page_list = BSUserEvent::model_pagename_list(); 	// Model page list
		$this->assignRef('model_page_list', $model_page_list);
		
		parent::display($tpl);
	}
}
