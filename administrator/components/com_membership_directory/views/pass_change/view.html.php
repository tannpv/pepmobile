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
class Membership_directoryViewPass_change extends JView {

    /**
     * Display the view
     */
    public function display($tpl = null) {


        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }
        $model = $this->getModel();
        $pass = $model->getDefaultPass();
        if ($pass) {
            $this->item = $pass;
        }
        $this->addToolbar();

        $input = JFactory::getApplication()->input;
        $view = $input->getCmd('view', '');
        Membership_directoryHelper::addSubmenu($view);

        parent::display($tpl);
    }

    protected function addToolbar() {
        
    }

}
