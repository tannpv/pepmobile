<?php

/**
 * @package		Joomla.Tutorials
 * @subpackage	Component
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		License GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

class BpsmemberViewBpsmember extends JView
{
	public function display($tpl = null) 
	{

		// get the Data
		$form = $this->get('Form');
		$item = $this->get('Item');

		// Assign the Data
		$this->form = $form;
		$this->item = $item;
        $this->getuseredit();
		// Set the toolbar
		$this->addToolBar();
        //$document = JFactory::getDocument();
       
       //  $document->addJ('components/com_bpsmember/css/bpsmember.css');
		// Display the template
		parent::display($tpl);

		// Set the document
		$this->setDocument();
	}

	protected function addToolBar() 
	{
		JRequest::setVar('hidemainmenu', true);
		$isNew = ($this->item->id == 0);
        if($isNew){
       	$document = JFactory::getDocument();
 	    $document->addScript("https://code.jquery.com/jquery-1.10.1.min.js");
     	$document->addScript("components/com_bpsmember/js/bpsmember.js");
        }
		JToolBarHelper::title($isNew ? JText::_('BPS MEMBER NEW') 
			: JText::_('BPS MEMBER EDIT'), 'bpsmember');
		JToolBarHelper::save('bpsmember.save');
		JToolBarHelper::cancel('bpsmember.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
	}

	protected function setDocument() 
	{
		$isNew = ($this->item->id < 1);
		$document = JFactory::getDocument();
		$document->setTitle($isNew ? JText::_('BPS MEMBER CREATING') : JText::_('BPS MEMBER EDITING'));
        $document->addStyleSheet('components/com_bpsmember/css/bpsmember.css');
     
	}
  public function getuseredit(){
     $id =trim(JRequest::getVar('id', null, 'GET'));
    $model= $this->getModel('bpsmember');
    $data= $model->getuseredit($id);
    $this->assignRef("member",$data);
  }
    
}
