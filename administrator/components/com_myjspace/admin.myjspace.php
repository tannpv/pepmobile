<?php
/**
* @version $Id: admin.myjspace.php $ 
* @version		1.7.3 01/11/2011
* @package		com_myjspace
* @author       Bernard Saulmé
* @copyright	Copyright (C) 2010-2011 Bernard Saulmé
* @license      GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Access check
if (version_compare(JVERSION,'1.6.0','ge') && !JFactory::getUser()->authorise('core.manage', 'com_myjspace')) {
	return JError::raiseWarning(403, JText::_('JERROR_ALERTNOAUTHOR'));
}

// Require the base controller
require_once (JPATH_COMPONENT.DS.'controller.php');
require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'version.php';

// Require specific controller if requested
if($controller = JRequest::getVar('controller')) {
	require_once (JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php');
}

// Create the controller
$classname	= 'MyjspaceController'.$controller;
$controller = new $classname( );

// Perform the Request task
$controller->execute( JRequest::getVar('task'));

// Redirect if set by the controller
$controller->redirect();
		
// Pour afficher Paramètres de configurations
// OK pour afficher bouton à droite pour configuration
JToolBarHelper::preferences('com_myjspace', 400);

JToolBarHelper::divider();		

$bar = & JToolBar::getInstance('toolbar');
$bar->appendButton( 'Popup', 'help', JText::_( 'COM_MYJSPACE_HELP' ), BS_Helper_version::get_xml_item(null, 'authorUrl',true), 1024, 768);

?>