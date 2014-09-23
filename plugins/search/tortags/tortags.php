<?php
/**
* TorTags component for Joomla 1.6, Joomla 1.7
* @package TorTags
* @author Tormix Team
* @Copyright Copyright (C) Tormix, www.tormix.com
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/


defined( '_JEXEC' ) or die();
jimport( 'joomla.html.parameter' );

class plgSearchTorTags extends JPlugin
{
   
   public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}

	function onContentSearchAreas() {
		static $areas = array(
			'tortags' => 'PLG_SEARCH_TORTAGS'
			);
			return $areas;
	}

	function onContentSearch($text, $phrase='', $ordering='', $areas=null)
	{
		$text = trim($text);
		if ($text == '') {return array();}
		
		$db		= JFactory::getDbo();
		$app	= JFactory::getApplication();
		$user	= JFactory::getUser();
		$limit	= $this->params->def('search_limit', 50);
		$nav	= $this->params->def('nav', 2);
		
		if (is_array($areas)) {
			if (!array_intersect($areas, array_keys($this->onContentSearchAreas()))) {
				return array();
			}
		}
		
		$query = $db->getQuery(true);
		$query->select('t.id');
		$query->from('#__tortags_tags AS t');
				
		switch ($phrase)
		{
			case 'exact':
				$text		= $db->Quote('%'.$db->getEscaped($text, true).'%', false);
				$query->where("`t`.`title` LIKE ".$text);
				break;

			case 'all':
			case 'any':
			default:
				$words	= explode(' ', $text);
				$wheres = array();
				foreach ($words as $word)
				{
					$word		= $db->Quote('%'.$db->getEscaped($word, true).'%', false);
					$wheres2	= array();
					$wheres2[]	= '`t`.`title` LIKE '.$word;
					$wheres[]	= implode(' OR ', $wheres2);
				}
				$where	= '(' . implode(($phrase == 'all' ? ') AND (' : ') OR ('), $wheres) . ')';
				$query->where($where);
				break;
		}
				
		$db->setQuery($query);
		$tagids = $db->loadResultArray();
		
		if(!sizeof($tagids)) return array();
		
		$ids = implode(',',$tagids);
		
		$query = $db->getQuery(true);
		$query->select('m.oid');
		$query->from('#__tortags AS m');
		$query->where('m.tid IN ('.$ids.')');
		$query->group('m.oid');
		$db->setQuery($query);
		$oids = $db->loadResultArray();
		if(!sizeof($oids)) return array();

		foreach ( $oids as $oid ) 
		{
			$query = $db->getQuery(true);
			$query->select('m.item_id');
			$query->from('#__tortags AS m');
			$query->where('m.tid IN ('.$ids.')');
			$query->where('m.oid='.$oid);
			$db->setQuery($query);
			$itemids = $db->loadResultArray();
			if (sizeof($itemids))
			{
				$query = $db->getQuery(true);
				$query->select('c.*');
				$query->from('#__tortags_components AS c');
				$query->where('c.id ='.$oid);
				$db->setQuery($query);
				$param = $db->loadObject();
				if ($param->table)
				{
					if ($param->table!='#__')
					{
						$query = $db->getQuery(true);
						$table 			= $param->table;
						$title			= $param->title_field?$param->title_field:'NULL';
						$description	= $param->description_field?$param->description_field:'NULL';
						$created		= $param->created_field?$param->created_field:'NULL';
						$query->select('id');
						$query->select($title.' AS `title`');
						$query->select($description.' AS `text`');
						$query->select($created.' AS `created`');
						$query->select('"1" AS browsernav');
						$query->where('id IN ('.implode(',',$itemids).')');
						$query->from($table);
						$db->setQuery($query);
						$res = $db->loadObjectList();
						
						if (sizeof($res))
						{
							foreach ( $res as $r ) 
							{
								$a = $b = array();
								$a[] = '[COMPONENT]';
								$b[] = $param->component;
								$a[] = '[ID]';
								$b[] = $r->id;
								$url= str_replace($a,$b,$param->url_template);
								$menu = &JSite::getMenu();
								$item = $menu->getItems('link', $url, true);
								
								if(isset($item)) {
							        $Itemid = $item->id;
							    } else if (JRequest::getInt('Itemid') > 0) {
							        $Itemid = JRequest::getInt('Itemid');
							    }
							    if ($Itemid) $url.='&Itemid='.$Itemid;
								
								switch ( $param->component ) 
								{
									case 'com_content':	
										require_once(JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');
										$r->href = ContentHelperRoute::getArticleRoute($r->id);
									break;
									
									case 'com_category':	
										require_once(JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');
										$r->href = ContentHelperRoute::getCategoryRoute($r->id);
									break;
									default:
										$r->href = JRoute::_($url);
									break;
								}
								$r->browsernav=$nav;
								$return[]=$r;
							}
						}
					}
				}
			}
			
		}
		//echo '<pre>';print_R($return);echo'</pre>';
		return $return;
	}
}
?>