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

/**
 * Methods supporting a list of Membership_directory records.
 */
class Membership_directoryModeldirectorys extends JModelList {

    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     * @see        JController
     * @since    1.6
     */
    public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                                'id', 'a.id',
                'size_of_company', 'a.size_of_company',
                'year_joined', 'a.year_joined',
                'dues_2014', 'a.dues_2014',
                'dues_2013', 'a.dues_2013',
                'desingated_rep', 'a.desingated_rep',
                'new_2013', 'a.new_2013',
                'new_2014', 'a.new_2014',
                'term_expires', 'a.term_expires',
                'board_position', 'a.board_position',
                'business_category', 'a.business_category',
                'paid_2013', 'a.paid_2013',
                'business_directory', 'a.business_directory',
                'company', 'a.company',
                'address', 'a.address',
                'city_state_zip', 'a.city_state_zip',
                'first_name', 'a.first_name',
                'last_name', 'a.last_name',
                'job_title', 'a.job_title',
                'email', 'a.email',
                'website', 'a.website',
                'phone', 'a.phone',
                'cell', 'a.cell',
                'fax', 'a.fax',
                'contact', 'a.contact',
                'ap_email', 'a.ap_email',
                'description', 'a.description',
                'referred_by', 'a.referred_by',
                'pass', 'a.pass',
				'uptodate', 'a.uptodate',

            );
        }

        parent::__construct($config);
    }

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     */
    protected function populateState($ordering = null, $direction = null) {
        // Initialise variables.
        $app = JFactory::getApplication('administrator');

        // Load the filter state.
        $search = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $published = $app->getUserStateFromRequest($this->context . '.filter.state', 'filter_published', '', 'string');
        $this->setState('filter.state', $published);

        

        // Load the parameters.
        $params = JComponentHelper::getParams('com_membership_directory');
        $this->setState('params', $params);

        // List state information.
        parent::populateState('a.id', 'asc');
    }

    /**
     * Method to get a store id based on model configuration state.
     *
     * This is necessary because the model is used by the component and
     * different modules that might need different sets of data or different
     * ordering requirements.
     *
     * @param	string		$id	A prefix for the store id.
     * @return	string		A store id.
     * @since	1.6
     */
    protected function getStoreId($id = '') {
        // Compile the store id.
        $id.= ':' . $this->getState('filter.search');
        $id.= ':' . $this->getState('filter.state');

        return parent::getStoreId($id);
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
                        'list.select', 'a.*'
                )
        );
        $query->from('`#__membership_directory` AS a');

        

        

        // Filter by search in title
        $search = $this->getState('filter.search');		
        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('a.id = ' . (int) substr($search, 3));
            } else {
                $search = $db->Quote('%' . $db->escape($search, true) . '%');
				/**
				*codeSMILE:) add $query for filter Frist name of user
				**/
				$query->where("a.first_name LIKE ".$search." ".
				            "OR a.last_name LIKE ".$search." ".
							"OR a.company LIKE ".$search." ".
							"OR a.term_expires LIKE ".$search." ".
							"OR a.board_position LIKE ".$search." ".
							"OR a.business_category LIKE ".$search." ".
							"OR a.business_directory LIKE ".$search." ".
							"OR a.company LIKE ".$search." ".
							"OR a.address LIKE ".$search." ".
							"OR a.city_state_zip LIKE ".$search." ".
							"OR a.job_title LIKE ".$search." ".
							"OR a.email LIKE ".$search." ".
							"OR a.website LIKE ".$search." ".
							"OR a.contact LIKE ".$search." ".
							"OR a.ap_email LIKE ".$search." ".
							"OR a.description LIKE ".$search." ".
							"OR a.referred_by LIKE ".$search
							);
            }
        }
		//echo $query;exit();
        


        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering');
        $orderDirn = $this->state->get('list.direction');
        if ($orderCol && $orderDirn) {
            $query->order($db->escape($orderCol . ' ' . $orderDirn));
        }
        return $query;
    }

    public function getItems() {
        $items = parent::getItems();
        return $items;
    }
	
	public function del_both(){
		$row = JRequest::get( 'post' );
		$id =  $row[cid];
		$id = implode(',',$id);
		$ids = "(".$id.")";

		$db = JFactory::getDbo();
		$queryuser = $db->getQuery(true);
 
		// delete all custom keys for user 1001.
		$conditions = array(
			$db->quoteName('membership_id') . ' in '.$ids
		);
		
		
		$queryuser->delete($db->quoteName('#__users'));
		$queryuser->where($conditions);

		$db->setQuery($queryuser);
		$result = $db->query();
		/////////////////////////////////////////////////
		
		$querymem = $db->getQuery(true);
 
		// delete all custom keys for user 1001.
		$conditions = array(
			$db->quoteName('id') . ' in '.$ids
		);
 
		$querymem->delete($db->quoteName('#__membership_directory'));
		$querymem->where($conditions);

		$db->setQuery($querymem);
		$result1 = $db->query();
		
	}

}
