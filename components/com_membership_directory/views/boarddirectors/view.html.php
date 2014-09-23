<?php

/**
 * @version     1.0.0
 * @package     com_membership_directory
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomla Component <Joomla@Joomla.com> - http://www.joomla.org
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View to edit
 */
class Membership_directoryViewBoarddirectors extends JView {

 
    protected $params;

    /**
     * Display the view
     */
    public function display($tpl = null) {
        
	
      	//$app	= JFactory::getApplication();
//      
//
//        $this->params = $app->getParams('com_membership_directory');
//        $this->getdata(364);
        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }
         $document = &JFactory::getDocument();
         
           $this->_prepareDocument();
           $this->item = $this->get('item');
       
		// Display the view
		parent::display($tpl);
 	  
        //if($this->_layout == 'edit') {
//            
//            $authorised = $user->authorise('core.create', 'com_membership_directory');
//
//            if ($authorised !== true) {
//                throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
//            }
//        }
        
    

      
    }

function getdata($id){
    $model= new Membership_directoryModelBoarddirectors();
    $date=$model->getcontentboard($id);
    $this->assignRef('data', $data);
}
function _prepareDocument(){
      $document = &JFactory::getDocument();
         
        $document->addStyleSheet(JUri::root().'components/com_membership_directory/css/darkbox.css');
 	    $document->addScript(JUri::root()."components/com_membership_directory/js/ibox.js");
       
    
}     
    
}
