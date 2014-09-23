<?php

defined('_JEXEC') or die;
jimport('joomla.application.component.view');
class UploadpdfViewUploadpdfs extends JView{
    
    function display($tpl=null){
        // get data from modul
        $items = $this->get('Items');
		$pagination = $this->get('Pagination');

		// Assign data to the view
		$this->items = $items;
		$this->pagination = $pagination;
 	    $this->state		= $this->get('State');
		$this->authors		= $this->get('Authors');
        // add toolbar
        $this->addToolbar();
        // display template
        parent::display($tpl);
        //set document
        $this->setDocument();
    }
     protected function addToolbar(){
        JToolBarHelper:: title("PEP talk issue",'uploadpdf');
        JToolBarHelper::addNewX('uploadpdf.add');
        
        JToolBarHelper::editListX('uploadpdf.edit');
        JToolBarHelper::deleteListX('', 'uploadpdfs.delete');
     }
    
   protected function setDocument(){
    $document= JFactory::getDocument();
    $document->setTitle('Manager Upload file');
   } 
    
}