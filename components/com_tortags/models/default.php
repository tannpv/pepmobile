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

class TorTagsModelDefault extends JModelList
{
	public function __construct($config = array())
	{
		parent::__construct($config);
	}
	
	protected function populateState($ordering = null, $direction = null)
	{
		parent::populateState($ordering, $direction);
		$this->setState('list.start', 0);
		$this->state->set('list.limit', 0);
	}
	
	protected function getListQuery() 
	{
		$db = $this->_db;
		$query = $db->getQuery(true);
		$query->select('`t`.*');
		$query->from('`#__tortags_tags` AS `t`');
		$query->join('INNER','`#__tortags` AS `m` ON `m`.`tid`=`t`.`id`');
		$query->group('`t`.`id`');
		return $query;
	}
	
	
}
