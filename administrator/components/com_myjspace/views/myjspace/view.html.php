<?php
/**
* @version $Id: view.php $ 
* @version		1.7.3 16/10/2011
* @package		com_myjspace
* @author       Bernard Saulmé
* @copyright	Copyright (C) 2010-2011 Bernard Saulmé
* @license      GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

class MyjspaceViewMyjspace extends JView
{
	/**
	 * display method of BSbanner view
	 * @return void
	 **/
	function display($tpl = null)
	{
        require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'version.php';
	// Menu bar
		JToolBarHelper::title( JText::_( 'COM_MYJSPACE_HOME' ), 'systeminfo.png');

	// Content
        $version = BS_Helper_version::get_version('com_myjspace.manage');
        $this->assignRef( 'version', $version );
		
	// New version
		$newversion = BS_Helper_version::get_newversion('com_myjspace');
        $this->assignRef( 'newversion', $newversion );
	
		parent::display($tpl);
	}
}
