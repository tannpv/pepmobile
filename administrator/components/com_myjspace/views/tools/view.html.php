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

class MyjspaceViewTools extends JView
{
	/**
	 * display method of BSbanner view
	 * @return void
	 **/
	function display($tpl = null)
	{
        require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'version.php';
	// Menu bar
		JToolBarHelper::title( JText::_( 'COM_MYJSPACE_HOME' ) .': <small>'.JText::_( 'COM_MYJSPACE_TOOLS' ).'</small>', 'config.png' );

	// Content
	// Config
		$pparams = &JComponentHelper::getParams('com_myjspace');
		$link_folder = $pparams->get('link_folder',1);
		$this->assignRef( 'link_folder',$link_folder);

		parent::display($tpl);
	}
}
