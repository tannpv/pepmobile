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
 * View class for a list of Membership_directory.
 */
class Membership_directoryViewImport extends JView {

    /**
     * Display the view
     */
    public function display($tpl = null) {


        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }

        $this->addToolbar();

        $input = JFactory::getApplication()->input;
        $view = $input->getCmd('view', '');
        Membership_directoryHelper::addSubmenu($view);

        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     *
     * @since	1.6
     */
    protected function addToolbar() {
        //require_once JPATH_COMPONENT.'/helpers/membership_directory.php';
        //$state	= $this->get('State');
        //$canDo	= Membership_directoryHelper::getActions($state->get('filter.category_id'));
        //JToolBarHelper::title(JText::_('imp'), '');		
        //Check if the form exists before showing the add/edit buttons
        //$formPath = JPATH_COMPONENT_ADMINISTRATOR.'/views/directory';
        // if (file_exists($formPath)) {
        //   if ($canDo->get('core.create')) {
        //	    JToolBarHelper::addNew('directory.add','JTOOLBAR_NEW');
        //   }
        //   if ($canDo->get('core.edit') && isset($this->items[0])) {
        //	    JToolBarHelper::editList('directory.edit','JTOOLBAR_EDIT');
        //  }
        // }
        //if ($canDo->get('core.edit.state')) {
        //    if (isset($this->items[0]->state)) {
        //	    JToolBarHelper::divider();
        //	    JToolBarHelper::custom('import.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
        //	    JToolBarHelper::custom('import.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
        //     } else if (isset($this->items[0])) {
        //If this component does not use state then show a direct delete button as we can not trash
        //         JToolBarHelper::deleteList('', 'import.delete','JTOOLBAR_DELETE');
        //    }
        ///    if (isset($this->items[0]->state)) {
        //	    JToolBarHelper::divider();
        //	    JToolBarHelper::archiveList('import.archive','JTOOLBAR_ARCHIVE');
        //    }
        //    if (isset($this->items[0]->checked_out)) {
        //    	JToolBarHelper::custom('import.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
        //   }
        //}
        //Show trash and delete for components that uses the state field
        // if (isset($this->items[0]->state)) {
        //    if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
        //	    JToolBarHelper::deleteList('', 'import.delete','JTOOLBAR_EMPTY_TRASH');
        //	    JToolBarHelper::divider();
        //  } else if ($canDo->get('core.edit.state')) {
        //	    JToolBarHelper::trash('import.trash','JTOOLBAR_TRASH');
        //	    JToolBarHelper::divider();
        //    }
        // }
        //if ($canDo->get('core.admin')) {
        //	JToolBarHelper::preferences('com_membership_directory');
        //}
        JToolBarHelper::title(JText::_('Import Members from Spreadsheet'), 'directory.png');
    }

}
