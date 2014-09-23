<?php
/**
* TorTags component for Joomla 1.6, Joomla 1.7
* @package TorTags
* @author Tormix Team
* @Copyright Copyright (C) Tormix, www.tormix.com
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/

defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

class TorTagsViewTags extends JView
{
	function display($tpl = null) 
	{
		$this->tags = $this->get('Items');
		$this->state = $this->get('State');
		$this->pagination = $this->get('Pagination');
		$this->user = &JFactory::getUser();

		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}

		$this->addToolBar();
		$this->setDocument();

		parent::display($tpl);
	}

	protected function addToolBar() 
	{
		JToolBarHelper::title(JText::_('COM_TORTAGS_TAGS'), 'tags');
		if ($this->user->authorise('core.create')) {
			JToolBarHelper::addNew('tag.add', 'JTOOLBAR_NEW');
		}
		if ($this->user->authorise('core.edit') or $this->user->authorise('core.edit.own')) {
			JToolBarHelper::editList('tag.edit', 'JTOOLBAR_EDIT');
			JToolBarHelper::divider();
		}
		if ($this->user->authorise('core.delete')) {
			JToolBarHelper::deleteList('', 'tags.delete', 'JTOOLBAR_DELETE');
		}
		if ($this->user->authorise('core.admin')) {
			JToolBarHelper::divider();
			JToolBarHelper::preferences('com_tortags');
		}
	}

	protected function setDocument() 
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('COM_TORTAGS_TAGS'));
	}
}
