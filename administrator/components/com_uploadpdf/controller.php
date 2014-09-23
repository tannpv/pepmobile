<?php
 
defined('_JEXEC') or die;	
class UploadpdfController extends JController{
    
  
    
    function display($cachable = false) 
	{
		// Set default view if not set
		JRequest::setVar('view', JRequest::getCmd('view', 'Uploadpdfs'));
	
		parent::display($cachable);
		
		// Add submenu
		//HelloWorldHelper::addSubmenu('messages');
	}
    
  
} 