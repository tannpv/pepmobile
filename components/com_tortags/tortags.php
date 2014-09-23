<?php
/**
* TorTags component for Joomla 1.6, Joomla 1.7
* @package TorTags
* @author Tormix Team
* @Copyright Copyright (C) Tormix, www.tormix.com
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/

defined('_JEXEC') or die('Restricted access');

if (!JFactory::getUser()->authorise('core.manage', 'com_tortags')) {
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

JLoader::register('TorTagsHelper', dirname(__FILE__).DS.'helpers'.DS.'helper.php');

jimport('joomla.application.component.controller');

$controller = JController::getInstance('TorTags');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();