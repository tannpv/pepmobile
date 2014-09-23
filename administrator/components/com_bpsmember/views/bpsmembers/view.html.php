<?php
defined('_JEXEC') or die;
jimport('joomla.application.component.view');
class BpsmemberViewBpsmembers extends JView{
    function display($tpl=null){
        $items=$this->get('Items');
        $pagination=$this->get('Pagination');
        // Check for errors.
	       if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
        $this->items=$items;
        $this->pagination=$pagination;
         $this->searchterms      = $this->get('State')->get('filter.search');
        $this->addtoolbar();
        parent::display($tpl);
        $this->setdocument();
    }
    
    protected function addtoolbar(){
        JToolBarHelper::title(JText::_('BPS MEMBER'));
        JToolBarHelper::deleteListX('','bpsmembers.delete');
        JToolBarHelper::editListX('bpsmember.edit');
        JToolBarHelper::addNewX('bpsmember.add');
    }
    protected function setdocument(){
        $document=JFactory::getDocument();
        $document->setTitle('BPS ADMISNISTRATOR');
    }
    
}