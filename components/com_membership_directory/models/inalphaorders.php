<?php

/**
 * @version     1.0.0
 * @package     com_membership_directory
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomla Component <Joomla@Joomla.com> - http://www.joomla.org
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');
jimport('joomla.application.component.view');

/**
 * Methods supporting a list of Membership_directory records.
 */
class Membership_directoryModelInalphaorders extends JModelList {

    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     * @see        JController
     * @since    1.6
     */
    public function __construct($config = array()) {
        parent::__construct($config);
    }

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @since	1.6
     */
    protected function populateState($ordering = null, $direction = null) {

        // Initialise variables.
        $app = JFactory::getApplication();

        // List state information
        $limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'));
        // $this->setState('list.limit', $limit);

        $limitstart = JFactory::getApplication()->input->getInt('limitstart', 0);
        // $this->setState('list.start', $limitstart);
        // List state information.
        //   parent::populateState($ordering, $direction);
    }

    /**
     * Build an SQL query to load the list data.
     *
     * @return	JDatabaseQuery
     * @since	1.6
     */
    protected function getListQuery() {

        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);
        // Select the required fields from the table.
        $query->select(
                $this->getState(
                        'list.select', '*'
                )
        );
        $user = JFactory::getUser();
        $query->from('`#__membership_directory`');
        $query->where("desingated_rep=" . $db->quote('True'));
        if (isset($_GET["alpha"]) && $_GET["alpha"] != "all") {
            $text = str_replace('all', '', $_GET["alpha"]);
            $textc = eregi_replace('[^a-zA-Z0-9_-]', '', $text);

            $query
                    ->where(" REPLACE(company,' ','') LIKE '$textc%'");
            $query->group("company");
        } else if (isset($_GET["alpha"]) && $_GET["alpha"] == "all") {
            //$query->order("company asc");
            //$query->group("company");
        } else {
            $query->order("company asc");
            //$query->group("company");
        }


        if (isset($_GET["business_category"]) && $_GET["business_category"] != "All") {
            $query
                    ->where("business_category = " . $db->quote($_GET["business_category"]));
            $query->group("company,first_name,last_name");
        }

        // Filter by search in title
        $search = $this->getState('filter.search');

        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('a.id = ' . (int) substr($search, 3));
            } else {
                $search = $db->Quote('%' . $db->escape($search, true) . '%');
            }
        }
        //echo $query;exit;
        // Check for a database error.
        if ($db->getErrorNum()) {
            JError::raiseWarning(500, $db->getErrorMsg());
        }
        return $query;
    }

    public function sortabc() {
        $arr[] = "All";
        for ($i = 'A'; $i != 'AA'; $i++) {
            $arr[] = $i;
        }
        return $arr;
    }

    Public function getbusinessdirectory() {
        $db = & JFactory::getDBO();
        $query = " SELECT distinct business_category FROM #__membership_directory ORDER BY business_category ASC";
        $db->setQuery((string) $query);
        $businessdirectory = $db->loadObjectList();
        return $businessdirectory;
    }

}
