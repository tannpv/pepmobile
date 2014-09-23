<?php
/**
* TorTags component for Joomla 1.6, Joomla 1.7
* @package TorTags
* @author Tormix Team
* @Copyright Copyright (C) Tormix, www.tormix.com
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.database.table');

class TorTagsTableComponents extends JTable
{
	function __construct(&$db)
	{
		parent::__construct('#__tortags_components', 'id', $db);
	}
	
	public function delete($pk = null)
	{
		$db = $this->getDBO();

		$query = $db->getQuery(true);
		$query->select('id');
		$query->from('#__tortags');
		$query->where('oid='.$pk);
		
		$db->setQuery($query);
		$ids = $db->loadResultArray();
		
		if ($ids) {
			$elem = JTable::getInstance('Elements', 'TorTagsTable', array());
			foreach ($ids as $id) {
				$elem->delete($id);
			}
		}

		return parent::delete($pk);
	}
}
