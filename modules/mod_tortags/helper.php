<?php
/**
* TorTags component for Joomla 1.6, Joomla 1.7
* @package TorTags
* @author Tormix Team
* @Copyright Copyright (C) Tormix, www.tormix.com
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/
// no direct access
defined('_JEXEC') or die;

class modTorTagsHelper
{
	static function getList($params)
	{
		$limit		= (int) $params->get('limitags',0);
		$clouds = 10;
		$db	=& JFactory::getDBO();
		$query = "SELECT '' AS `slug`, " .
				" t.`title`, " .
				" COUNT(x.`tid`) `frequency` " .
				" FROM #__tortags x, #__tortags_tags t " .
				" WHERE t.`id`=x.`tid` " .
				" GROUP BY t.`id` " .
				" ORDER BY `frequency` ASC ";
		if ($limit) $query.=' LIMIT '.$limit;
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		if (!$rows) return null;
		
		foreach ($rows as $row)
			{
				$vals["{$row->frequency}"] = $row->frequency;
			}
			$maxFreq = max($vals);
			$minFreq = min($vals);
			
			$freqSize = $maxFreq - $minFreq;
			$freqSpacing	= $freqSize / $clouds;
			
			if($freqSpacing < 1){$freqSpacing = 1;}
			
			foreach ($rows as $row)
			{
				$tagClass = round($row->frequency / $freqSpacing);
				$result[] = array (
					'name' => $row->title,
					'cloud' => $tagClass,
					'slug'	=> $row->slug
				);
			}
			usort($result, array("modTorTagsHelper", "SortTags"));
		return $result;

	}
	
	function SortTags($a, $b)
	{
		return (strtoupper($a['name']) < strtoupper($b['name'])) ? -1 : 1;
	}

}
