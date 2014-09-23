<?php
/**
* @version $Id: view.php $ 
* @version		1.7.5 03/12/2011
* @package		com_myjspace
* @author       Bernard Saulmé
* @copyright	Copyright (C) 2010-2011 Bernard Saulmé
* @license      GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

class MyjspaceViewPages extends JView
{
	function display($tpl = null)
	{
		JToolBarHelper::title( JText::_( 'COM_MYJSPACE_HOME' ) .': <small>'.JText::_( 'COM_MYJSPACE_PAGES' ).'</small>', 'user.png' );
		JToolBarHelper::addNew('pages.createpage');
		JToolBarHelper::editList();
		JToolBarHelper::deleteList();
		JToolBarHelper::divider();
		
		$db	=& JFactory::getDBO();
		$mainframe = JFactory::getApplication();
		$option = JRequest::getCmd( 'option' );

		$filter_order		= $mainframe->getUserStateFromRequest( "$option.filter_order",		'filter_order',		'a.pagename',	'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( "$option.filter_order_Dir",	'filter_order_Dir',	'',			'word' );
		
		$filter_type		= $mainframe->getUserStateFromRequest( "$option.filter_type",		'filter_type', 		0,			'int' );
		$filter_logged		= $mainframe->getUserStateFromRequest( "$option.filter_logged",		'filter_logged', 	0,			'int' );
		$search				= $mainframe->getUserStateFromRequest( "$option.search",			'search', 			'',			'string' );
		if (strpos($search, '"') !== false) {
			$search = str_replace(array('=', '<'), '', $search);
		}
		$search = JString::strtolower($search);

		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );

		$where = array();
		if (isset( $search ) && $search!= '')
		{
			$searchEscaped = $db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
			$where[] = 'a.pagename LIKE '.$searchEscaped.' OR b.username LIKE '.$searchEscaped;
		}
		
		// Filters
		if ( isset($filter_type) && $filter_type != 0) {
			$where[] = ' a.blockEdit = '. ($filter_type-1) . ' ';
		}
		
		if ( isset($filter_logged) && $filter_logged != 0)
			$where[] = ' a.blockView = '. ($filter_logged-1) . ' ';
		
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
		$query = 'SELECT COUNT(a.id)'
		. ' FROM #__myjspace AS a'
		. $where
		;
		$db->setQuery( $query );
		$total = $db->loadResult();

		jimport('joomla.html.pagination');
		$pagination = new JPagination( $total, $limitstart, $limit );

		
		$orderby = ' ORDER BY '. $filter_order .' '. $filter_order_Dir;
	
		$query = 'SELECT a.id, a.pagename, a.blockEdit, a.blockView, b.username, b.block, a.hits, a.create_date, LENGTH(content) AS size'
			. ' FROM #__myjspace AS a LEFT JOIN #__users b ON a.id=b.id'
			. $where
			. $orderby
		;
		
		$db->setQuery( $query, $pagination->limitstart, $pagination->limit );
		$rows = $db->loadObjectList();

		// get list of Log Status for dropdown filter
		$types[] =  JHTML::_('select.option',  0, '- '. JText::_( 'COM_MYJSPACE_TITLEMODEEDIT' ) .' -' );
		$types[] =  JHTML::_('select.option',  1, JText::_( 'COM_MYJSPACE_TITLEMODEEDIT0' ) );
		$types[] =  JHTML::_('select.option',  2, JText::_( 'COM_MYJSPACE_TITLEMODEEDIT1' ) );
		$lists['type'] 	= JHTML::_('select.genericlist',   $types, 'filter_type', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', "$filter_type" );

		// get list of Log Status for dropdown filter
		$logged[] = JHTML::_('select.option',  0, '- '. JText::_( 'COM_MYJSPACE_TITLEMODEVIEW' ) .' -');
		$logged[] = JHTML::_('select.option',  1, JText::_( 'COM_MYJSPACE_TITLEMODEVIEW0' ) );
		$logged[] = JHTML::_('select.option',  2, JText::_( 'COM_MYJSPACE_TITLEMODEVIEW1' ) );
		$logged[] = JHTML::_('select.option',  3, JText::_( 'COM_MYJSPACE_TITLEMODEVIEW2' ) );
		$lists['logged'] = JHTML::_('select.genericlist',   $logged, 'filter_logged', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', "$filter_logged" );

		// table ordering
		$lists['order_Dir']	= $filter_order_Dir;
		$lists['order']		= $filter_order;

		// search filter
		$lists['search']= $search;

		$this->assignRef('user',		JFactory::getUser());
		$this->assignRef('lists',		$lists);
		$this->assignRef('items',		$rows);
		$this->assignRef('pagination',	$pagination);
		
		parent::display($tpl);
	}
}
