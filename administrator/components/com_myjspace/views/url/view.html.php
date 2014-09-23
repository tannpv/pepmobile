<?php
/**
* @version $Id: view.php $ 
* @version		1.7.5 03/12/2011
* @package		com_myjspace
* @author       Bernard Saulmé
* @copyright	Copyright (C) 2010-2011 Bernard Saulmé
* @license      GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

class MyjspaceViewUrl extends JView
{
	/**
	 * display method of BSbanner view
	 * @return void
	 **/
	function display($tpl = null)
	{
        require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'user.php';
	// Menu bar
		JToolBarHelper::title( JText::_( 'COM_MYJSPACE_HOME' ) .': <small>'.JText::_( 'COM_MYJSPACE_LINKS' ).'</small>', 'categories.png');
		JToolBarHelper::apply('adm_ren_folder');	
		JToolBarHelper::divider();	

	// Content
		$user_page = New BSHelperUser();
		$link = $user_page->getFoldername();
		$this->assignRef('link', $link);
	
		parent::display($tpl);
	}
}
