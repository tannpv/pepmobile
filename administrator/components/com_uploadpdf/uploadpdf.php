<?php
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

// Set some global property
$document = JFactory::getDocument();
$document->addStyleDeclaration('.icon-48-uploadpdf {background-image: url(../media/com_uploadpdf/images/icon-48-uploadpdf.png);}');

// Require helper file
//JLoader::register('HelloWorldHelper', dirname(__FILE__) . DS . 'helpers' . DS . 'helloworld.php');

// Get an instance of the controller prefixed by HelloWorld
$controller = JController::getInstance('Uploadpdf');

// Perform the Request task
$controller->execute(JRequest::getCmd('task'));

// Redirect if set by the controller
$controller->redirect();
