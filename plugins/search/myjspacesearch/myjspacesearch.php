<?php
/**
* @version		1.8.0 12/04/2012
* @package		myjspacesearch.php
* @author       Bernard Saulmé
* @copyright	Copyright (C) 2010-2011-2012 Bernard Saulmé
* @license      GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/
defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');
jimport( 'joomla.html.parameter' );

/*
$app = JFactory::getApplication ();
// J!1.5
$app->registerEvent ('onSearch', 'plgSearchMyjspace');
$app->registerEvent ('onSearchAreas', 'plgSearchMyjspaceAreas');
// >= J!1.6
$app->registerEvent ('onContentSearch', 'plgSearchMyjspace');
$app->registerEvent ('onContentSearchAreas', 'plgSearchMyjspaceAreas');

// Language file
JPlugin::loadLanguage( 'plg_search_myjspacesearch', JPATH_ADMINISTRATOR);

*/

class plgSearchMyjspacesearch extends JPlugin
{
	// Add language
	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage( 'plg_search_myjspacesearch', JPATH_ADMINISTRATOR );
	}

	// Search function J!1.5
	function onSearch($text, $phrase = '', $ordering = '', $areas = null) {
		return($this->onContentSearch($text, $phrase, $ordering, $areas));
	}

	// Search Areas function J!1.5
	function onSearchAreas() {
		return($this->onContentSearchAreas());
	}

	// Function to return an array of search areas.
	function onContentSearchAreas() {
		static $areas = array();

		// Define the parameters. First get the right plugin; 'search' (the group)
		$plugin = JPluginHelper::getPlugin ( 'search', 'myjspacesearch' );
		// Load de parameters
		$pluginParams = new JParameter ($plugin->params);

		// BS Myjspace component ACL
		if (version_compare(JVERSION,'1.6.0','ge') && ($pluginParams->def( 'use_com_acl', 0) && !JFactory::getUser()->authorise('user.search', 'com_myjspace') )) 
			return array();
		
		if (empty($areas)) {
			$areas['myjspace'] = JText::_('PLG_MYJSPACESEARCH_PAGE');
		}
		return $areas;
	}
	
	// Search function
	function onContentSearch($text, $phrase = '', $ordering = '', $areas = null) {
		
		$db = JFactory::getDBO();
		$user_actual = &JFactory::getuser();

		// BS MyJspace component not installed
		if (!file_exists(JPATH_ROOT.DS.'components'.DS.'com_myjspace'.DS.'myjspace.php'))
			return array();

		// Define the parameters. First get the right plugin; 'search' (the group)
		$plugin = JPluginHelper::getPlugin ( 'search', 'myjspacesearch' );
		// Load de parameters
		$pluginParams = new JParameter ($plugin->params);
		
		// BS Myjspace component ACL
		if (version_compare(JVERSION,'1.6.0','ge') && ($pluginParams->def( 'use_com_acl', 0) && !JFactory::getUser()->authorise('user.search', 'com_myjspace') )) 
			return array();
		
		// If the array is not correct, return it:
		if (is_array($areas)) {
			if (!array_intersect($areas, array_keys($this->onContentSearchAreas()))) {
				return array();
			}
		}

		// Define the parameters
		$limit = $pluginParams->def('search_limit',50);
		$contentLimit = $pluginParams->def('content_limit',150);
		// URL display mode
		$param_url_mode = $pluginParams->def('param_url_mode',0);	

		// Cleaning searching terms
		$text = trim ( $text );

		// Return empty array when nothing was filled in
		if ($text == '') {
			return array ();
		}

		// Search for direct characters or for html equivalent for text with accent
		if ($pluginParams->def( 'search_html', 1))
			$text = htmlentities($text,ENT_QUOTES,'UTF-8');
			
		// Search
		$wheres = array ();
		switch ($phrase) {

			// Search exact
			case 'exact' :
				$text = $db->Quote( '%' . $db->getEscaped ($text, true) . '%', false);
				$wheres2 = array();
				$wheres2 [] = 'pagename LIKE ' . $text . ' OR content LIKE ' . $text;
				$where = '(' . implode( ') OR (', $wheres2 ) . ')';
				break;

			// Search all or any
			case 'all' :
			case 'any' :

			// Set default
			default :
				$words = explode (' ', $text);
				$wheres = array ();
				foreach ( $words as $word ) {
					$word = $db->Quote( '%' . $db->getEscaped ($word, true) . '%', false);
					$wheres2 = array();
					$wheres2 [] = 'pagename LIKE ' . $word . ' OR content LIKE ' . $word;
					$wheres [] = implode( ' OR ', $wheres2 );
				}
				$where = '(' . implode( ($phrase == 'all' ? ') AND (' : ') OR ('), $wheres ) . ')';
				break;
		}

		// Ordering of the results
		switch ($ordering) {

			// Oldest first
			case 'oldest' :
				$order = 'create_date ASC';
				break;

			// Popular first
			case 'popular' :
				$order = 'hits ASC, create_date DESC';
				break;

			// Newest first
			case 'newest' :
				$order = 'create_date DESC';
				break;

			// Alphabetic, ascending
			case 'alpha' :
			// Default setting: hit, create_date descending
			default :
				$order = 'hits ASC, create_date DESC';
		}
		
		$query = "SELECT `pagename` AS title, `content` AS text, `create_date` AS created FROM `#__myjspace` WHERE `blockView` != 1 AND `content` != '' AND
				`publish_up` < NOW() AND (`publish_down` >= NOW() OR `publish_down` = '0000-00-00 00:00:00')
				AND {$where} ORDER BY {$order}";

		// Query
		$db->setQuery ( $query, 0, $limit );
		$rows = $db->loadObjectList();

		// Search for folder
		if ($param_url_mode == 1) {
			$pparams = &JComponentHelper::getParams('com_myjspace');
			$repertoire = $pparams->get('foldername','myjsp') . '/';
			$id_itemid = '?Itemid=';
		} else {
			$repertoire = 'index.php?option=com_myjspace&view=see&pagename=';
			$id_itemid = '&Itemid=';
		}
		
		// Itemid
		$itemid = $pluginParams->get( 'forced_itemid', '');
		if ($itemid == '') {
			if ( ($itemid = JRequest::getInt( 'Itemid' , 0) ) == 0) { // If not into the parameter
				$itemid = JSite::getMenu()->getDefault()->id; // Get the default menu value
			}
		}

		foreach ( $rows as $key => $row ) {
			$rows[$key]->section = JText::_('PLG_MYJSPACESEARCH_PAGE');	
			$rows[$key]->href = Jroute::_($repertoire . $row->title . $id_itemid. $itemid, true);
			$rows[$key]->browsernav = '2';
			
			// Workaround for preg_replace
			if (strlen($row->text) > 92160) // 90 ko (real limit is little bit biggger)
				$row->text = substr($row->text, 0, 92160);		
			// Html tags
			$row->text = strip_tags($row->text);
	//		$row->text = preg_replace( '#<[^>]*>#i', '', $row->text);
			// Delete #Tags
			$search  = array('#userid', '#name', '#username', '#pagename', '#lastupdate', '#lastaccess', '#createdate', '#description', '#bsmyjspace', '#fileslist', '#cbprofile', '#hits', '#jomsocial-profile', '#jomsocial-photos');
			$replace = array('','','','','','','','','','','','','','');
			$row->text = str_replace($search, $replace, $row->text);
			// BBCode [register]
			if ($user_actual->id != 0) // if the user is registered
				$row->text = preg_replace('!\[register\](.+)\[/register\]!isU', '$1', $row->text);
			else // if not registered
				$row->text = preg_replace('!\[register\](.+)\[/register\]!isU', '', $row->text); // Keep it secret :-)
			// {} tags (enleves par la fct d'affichage de search)
			// Length
			$row->text = substr($row->text, 0, $contentLimit) . '...';
		}

		// Return the search results in an array	
		return $rows;
	}

}

