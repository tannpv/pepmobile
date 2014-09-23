<?php
/**
 * @version     1.0.0
 * @package     com_membership_directory
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomla Component <Joomla@Joomla.com> - http://www.joomla.org
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');
//require_once( JPATH_COMPONENT . DS . 'controller.php' );
// Execute the task.
$controller	= JController::getInstance('Membership_directory');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
//$controller = JController::getInstance('inalphaorders');
//$controller->execute(JRequest::getCmd('task'));
//$controller->redirect();