<?php
/**
* @package Redirect-On-Login (com_redirectonlogin)
* @version 3.1.0
* @copyright Copyright (C) 2008 - 2013 Carsten Engel. All rights reserved.
* @license GPL versions free/trial/pro
* @author http://www.pages-and-items.com
* @joomla Joomla is Free Software
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modellist');

class redirectonloginModelAccesslevels extends JModelList{	

	protected $option = 'com_redirectonlogin';	
	
	public function __construct($config = array()){
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'access_level_name', 'a.title',
				'frontend_type', 't.frontend_type',				
				'opening_site', 't.opening_site',	
				'frontend_type_logout', 't.frontend_type_logout',	
				'redirect_order', 'o.redirect_order',	
				'id', 'a.id'				
			);
		}
		parent::__construct($config);
	}	

	protected function populateState(){
	
		// Initialise variables.
		$app = JFactory::getApplication('administrator');

		// Load the filter state.
		$search = $app->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		// Load the parameters.
		$params = JComponentHelper::getParams('com_redirectonlogin');
		$this->setState('params', $params);		
		
		// List state information.		
		parent::populateState('o.redirect_order', 'asc');
	}
	
	protected function getStoreId($id = ''){
	
		// Compile the store id.
		$id	.= ':'.$this->getState('filter.search');

		return parent::getStoreId($id);
	}
	
	protected function getListQuery(){
	
		// Create a new query object.
		$db	= $this->getDbo();
		$query = $db->getQuery(true);

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				'a.*, '.
				'o.redirect_order AS redirect_order, '.
				'o.id AS order_id, '.
				't.frontend_type AS frontend_type, '.	
				't.frontend_type_logout AS frontend_type_logout, '.
				't.open_type AS open_type, '.
				't.opening_site AS opening_site '				
			)
		);
		$query->from('`#__viewlevels` AS a');
		
		// Join with level order
		$query->join('LEFT', '#__redirectonlogin_order_levels AS o ON a.id = o.level_id');
		
		// Join with level type
		$query->join('LEFT', '#__redirectonlogin_levels AS t ON a.id = t.group_id');
		
		// Add the level in the tree.
		$query->group('a.id');

		// Filter the items over the search string if set.
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			if (stripos($search, 'id:') === 0) {
				$query->where('a.id = '.(int) substr($search, 3));
			} else {
				$search = $db->Quote('%'.$db->escape($search, true).'%');
				$query->where('a.title LIKE '.$search);
			}
		}		

		$query->group('a.id');	
		
		// Add the list ordering clause.
		$orderCol	= $this->state->get('list.ordering');
		$orderDirn	= $this->state->get('list.direction');		
		$query->order($db->escape($orderCol.' '.$orderDirn));
		
		return $query;
	}
}
?>