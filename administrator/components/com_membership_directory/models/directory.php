<?php

/**
 * @version     1.0.0
 * @package     com_membership_directory
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomla Component <Joomla@Joomla.com> - http://www.joomla.org
 */
// No direct access.
defined('_JEXEC') or die();
jimport('joomla.user.helper');
jimport('joomla.application.component.modeladmin');

/**
 * Membership_directory model.
 */
class Membership_directoryModeldirectory extends JModelAdmin {

    /**
     *
     * @var string prefix to use with controller messages.
     * @since 1.6
     */
    protected $text_prefix = 'COM_MEMBERSHIP_DIRECTORY';

    /**
     * Returns a reference to the a Table object, always creating it.
     *
     * @param
     *        	type	The table type to instantiate
     * @param
     *        	string	A prefix for the table class name. Optional.
     * @param
     *        	array	Configuration array for model. Optional.
     * @return JTable database object
     * @since 1.6
     */
    public function getTable($type = 'Directory', $prefix = 'Membership_directoryTable', $config = array()) {
        return JTable::getInstance($type, $prefix, $config);
    }

    /**
     * Method to get the record form.
     *
     * @param array $data
     *        	array of data for the form to interogate.
     * @param boolean $loadData
     *        	the form is to load its own data (default case), false if not.
     * @return JForm JForm object on success, false on failure
     * @since 1.6
     */
    public function getForm($data = array(), $loadData = true) {
        // Initialise variables.
        $app = JFactory::getApplication();

        // Get the form.
        $form = $this->loadForm('com_membership_directory.directory', 'directory', array(
            'control' => 'jform',
            'load_data' => $loadData
        ));
        if (empty($form)) {
            return false;
        }
        return $form;
    }

    /**
     * Method to get the data that should be injected in the form.
     *
     * @return mixed data for the form.
     * @since 1.6
     */
    protected function loadFormData() {
        // Check the session for previously entered form data.
        $data = JFactory::getApplication()->getUserState('com_membership_directory.edit.directory.data', array());

        if (empty($data)) {
            $data = $this->getItem();
        }

        return $data;
    }

    /**
     * Method to get a single record.
     *
     * @param
     *        	integer	The id of the primary key.
     *        	
     * @return mixed on success, false on failure.
     * @since 1.6
     */
    public function getItem($pk = null) {
        if ($item = parent::getItem($pk)) {

            // Do any procesing on fields here if needed
        }

        return $item;
    }

    /**
     * Prepare and sanitise the table prior to saving.
     *
     * @since 1.6
     */
    protected function prepareTable(&$table) {
        jimport('joomla.filter.output');
        $jform = JRequest::getVar('jform'); // load all submitted data
        if (!isset($jform ['desingated_rep'])) { // see if the checkbox has been submitted
            $table->desingated_rep = "False"; // if it has not been submitted, mark the field unchecked
        }

        if (!isset($jform ['new_2013'])) { // see if the checkbox has been submitted
            $table->new_2013 = "False"; // if it has not been submitted, mark the field unchecked
        }
        if (!isset($jform ['new_2014'])) { // see if the checkbox has been submitted
            $table->new_2014 = "False"; // if it has not been submitted, mark the field unchecked
        }
        if (!isset($jform ['paid_2013'])) { // see if the checkbox has been submitted
            $table->paid_2013 = "False"; // if it has not been submitted, mark the field unchecked
        }

        if (empty($table->id)) {

            // Set ordering to the last item if not set
            if (@$table->ordering === '') {
                $db = JFactory::getDbo();
                $db->setQuery('SELECT MAX(ordering) FROM #__membership_directory');
                $max = $db->loadResult();
                $table->ordering = $max + 1;
            }
        }
    }

    public function check_exist_email($data) {
        // $row = JRequest::getVar ( 'jform', array (), 'post', 'array' );
        // Get a db connection.
        $db = JFactory::getDbo();
        // Create a new query object.
        $query = $db->getQuery(true);
        if ($data ['id']) {
            $query->select("*")->from($db->quoteName("#__users"))->where($db->quoteName('email') . ' = ' . "'" . $data ['email'] . "'")->where($db->quoteName('membership_id') . ' != ' . "'" . $data ['id'] . "'");
        } else {
            $query->select('*')->from("#__users")->where('email = ' . $db->quote($data ['email']));
        }
        // Reset the query using our newly populated query object.

        $db->setQuery($query); //echo $query;exit;

        if ($db->loadResult()) {
            return true;
        } else {
            return false;
        }
    }

    public function check_exist_membershipid($membership_id) {
        // $row = JRequest::getVar ( 'jform', array (), 'post', 'array' );
        // Get a db connection.
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query = "SELECT * from jos_users where membership_id =" . $db->quote($membership_id);
        $db->setQuery($query);
        if ($db->loadResult()) {
            return true;
        } else {
            return false;
        }
    }

    public function addUser($data) {
        // $row = JRequest::getVar ( 'jform', array (), 'post', 'array' );
        $first_name = $data ['first_name'];
        $last_name = $data ['last_name'];
        $email = $data ['email'];
        $datetime = date('Y-m-d H:i:s');
        /* password */
        $salt = JUserHelper::genRandomPassword(32);
        $crypt = JUserHelper::getCryptedPassword($data ["pass"], $salt);
        $pass = $crypt . ':' . $salt;
//		JUserHelper::addUserToGroup($userId, $groupId);
        // ////////////////////////////////////////////////////////////
        $db = JFactory::getDbo();
        // Create and populate an object.
        $insert = new stdClass ();
        $insert->id = '';
        $insert->name = $first_name . " " . $last_name;
        $insert->username = $email;
        $insert->email = $email;
        $insert->password = $pass;
        $insert->usertype = '';
        $insert->block = '';
        $insert->sendEmail = '';
        $insert->registerDate = $datetime;
        $insert->lastvisitDate = '';
        $insert->activation = '';
        $insert->params = '';
        $insert->button = '';
        $insert->membership_id = $data ['id'];

        try {
            $result = $db->insertObject('#__users', $insert);
            $user_id = $db->insertid();
        } catch (Exception $e) {
            echo "Insert Fail !!!";
        }
        return $user_id;
    }

    public function updateUser($data) {
        $db = JFactory::getDbo();
        // $row = JRequest::getVar ( 'jform', array (), 'post', 'array' );
        $first_name = $data ['first_name'];
        $last_name = $data ['last_name'];
        $email = $data ['email'];
        /* password */
        $salt = JUserHelper::genRandomPassword(32);
        $crypt = JUserHelper::getCryptedPassword($data ["pass"], $salt);
        $pass = $crypt . ':' . $salt;
        $query = $db->getQuery(true);
        $query->update('#__users')->set(array(
            $db->quoteName("name") . "=" . $db->quote($first_name . " " . $last_name),
            $db->quoteName("username") . "=" . $db->quote($email),
            $db->quoteName("email") . "=" . $db->quote($email),
            $db->quoteName("password") . "=" . $db->quote($pass)
        ))->where(array(
            $db->quoteName("membership_id") . "=" . $db->quote($data ['id'])
        ));
        $db->setQuery($query);
        $result = $db->query();
        $query = $db->getQuery(true);
        $query->select("id")
                ->from("#__users")
                ->where($db->quoteName("membership_id") . "=" . $db->quote($data ['id']));
        $db->setQuery($query);
        $user_id = $db->loadResult();
        return $user_id;
    }

    public function getUserName($name) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select("username")->from("#__users")->where("username=" . $db->quote($name));
        $db->setQuery($query);
        if ($db->loadResult()) {
            $this->getUserName($name . "-1");
        } else {
            return $name;
        }
    }

}
