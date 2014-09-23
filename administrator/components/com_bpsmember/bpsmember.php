<?php
defined('_JEXEC') or die;
jimport('joomla.application.component.controller');
$document = JFactory::getDocument();
$document->addStyleDeclaration('.icon-48-bpsmember {background-image: url(../media/com_bpsmember/images/icon-48-bps.png);}');
// Require helper file
//JLoader::register('HelloWorldHelper', dirname(__FILE__) . DS . 'helpers' . DS . 'helloworld.php');


// Get an instance of the controller prefixed by HelloWorld
$controller = JController::getInstance('Bpsmember');

// Perform the Request task
$controller->execute(JRequest::getCmd('task'));

// Redirect if set by the controller
$controller->redirect();
