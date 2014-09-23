<?php

defined('_JEXEC') or die;
jimport('joomla.user.helper');
jimport('joomla.application.component.modeladmin');

class Membership_directoryModelPass_change extends JModelAdmin {

    public function getForm($data = array(), $loadData = true) {
        // Initialise variables.
        $app = JFactory::getApplication();

        // Get the form.
        $form = $this->loadForm('com_membership_directory.pass_change', 'pass_change', array('control' => 'jform', 'load_data' => $loadData));
        if (empty($form)) {
            return false;
        }
        return $form;
    }

    public function getDefaultPass() {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query = "SELECT *  FROM jos_config WHERE name LIKE 'pass'";
        $db->setQuery($query);
        $config = $db->loadObject();
        return $config;
    }

}
