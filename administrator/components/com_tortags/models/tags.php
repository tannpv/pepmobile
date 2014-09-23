<?php
/**
* TorTags component for Joomla 1.6, Joomla 1.7
* @package TorTags
* @author Tormix Team
* @Copyright Copyright (C) Tormix, www.tormix.com
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modellist');

class TorTagsModelTags extends JModelList
{
	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'`t`.`id`','`t`.`title`'
			);
		}
		parent::__construct($config);
	}
	
	protected function populateState()
	{
		$this->setState('filter.search_tag', $this->getUserStateFromRequest('com_tortags.filter.search_tag', 'filter_search_tag'));
		parent::populateState();
	}

	protected function getListQuery() 
	{
		$db = $this->_db;
		$query = $db->getQuery(true);

		$query->select('t.*');
		$query->from('`#__tortags_tags` AS `t`');
		$query->order($db->getEscaped($this->getState('list.ordering', '`t`.`title`')).' '.$db->getEscaped($this->getState('list.direction', 'ASC')));

		$search = $this->getState('filter.search_tag');
		if (!empty($search)) {
			$search = $db->Quote('%'.$db->getEscaped($search, true).'%');
			$query->where('`t`.`title` LIKE '.$search);
		}
		return $query;
	}
}
