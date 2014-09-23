<?php
/**
* @version $Id: view.html.php $ 
* @version		1.8.0 12/04/2012
* @package		com_myjspace
* @author       Bernard Saulmé
* @copyright	Copyright (C) 2010-2011-2012 Bernard Saulmé
* @license      GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

jimport( 'joomla.application.component.view');

class MyjspaceViewSearch extends JView
{
	function display($tpl = null)
	{		
        require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'user.php';
		
		// Config
		$pparams = &JComponentHelper::getParams('com_myjspace');
	  	$user = &JFactory::getuser();

		// Param
		$Itemid = JRequest::getInt( 'Itemid' , 0);
		$aff_titre = JRequest::getInt( 'title' , 1); 	// print the title
		$aff_select = JRequest::getInt( 'select' , 1); 	// print the search selector
		$aff_sort = JRequest::getInt( 'sort' , 4); 		// sort order
		$separ = JRequest::getInt( 'separ' , 0);		// tab or space or \n between each space  

		// Limit for the number of links printed
		$aff_number = JRequest::getInt( 'numb', 0);
		if ($pparams->get('search_max_line', '100') > 0 && JRequest::getInt('numb', 0) > 0)
 			$aff_number = min($aff_number, $pparams->get('search_max_line', '100'));
		if (JRequest::getInt('numb', 0) <= 0)
 			$aff_number = $pparams->get('search_max_line', '100');
		if ($pparams->get('search_max_line', '100') < 0)
 			$aff_number = $pparams->get('search_max_line', '100');
		$aff_number = intval($aff_number);

		// Result display
		$search_aff_add = intval($pparams->get('search_aff_add', 69));
		if ($search_aff_add <= 0 || $search_aff_add > 127)
			$search_aff_add = 1;
		
		// Folder root dir
		$user_page = New BSHelperUser();
		$link_folder = $pparams->get('link_folder', 1);
		if ($link_folder == 1) {
			$user_page->getFoldername();
			$foldername = $user_page->foldername;
		} else
			$foldername = null;
		
		// Selection checked
		$check_search = JRequest::getVar( 'check_search' , array('name','content','description'));
		foreach ($check_search as $i => $value) {
			$check_search_asso[$value] = '1';
		}
		
		// Search key for search content value
		$svalue = JRequest::getVar( 'svalue' , '');
		
		// Autorisation & search
		if ( $aff_number >= 0 ) {
			$result = BSHelperUser::loadPagename($aff_sort, $aff_number, 1, 1, 1, $check_search_asso, $svalue, $search_aff_add);
		} else {
			$result = array();
			$aff_select = 0;
			$aff_titre = 0;
		}
		
		$app = &JFactory::getApplication();
		$document = &JFactory::getDocument();

        // Web page title
		if ($pparams->get('pagetitle',1) == 1) {
			$title = JText::_('COM_MYJSPACE_TITLESEARCH');
			if (empty($title)) {
				$title = $app->getCfg('sitename');
			} elseif ($app->getCfg('sitename_pagetitles', 0) == 1) {
				$title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
			} elseif ($app->getCfg('sitename_pagetitles', 0) == 2) {
				$title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
			}
			if ($title)
				$document->setTitle($title);
		}

		// Breadcrumbs
		$pathway =& $app->getPathway();
		$pathway->addItem(JText::_('COM_MYJSPACE_PAGE'), Jroute::_('index.php?option=com_myjspace&view=config'));
		$pathway->addItem(JText::_('COM_MYJSPACE_TITLESEARCH', ''));
		
		// Lightbox usage & preview
		$add_lightbox = $pparams->get('add_lightbox',1);
		
		// Date format
		$date_fmt = $pparams->get('date_fmt', 'Y-m-d H:i:s');
		$date_fmt_tab = explode(' ',$date_fmt);
		$date_fmt = $date_fmt_tab[0];
		
		// Var assign
		$this->assignRef('Itemid', $Itemid);
		$this->assignRef('aff_titre', $aff_titre);
		$this->assignRef('aff_select', $aff_select);
		$this->assignRef('aff_sort', $aff_sort);
		$this->assignRef('aff_number', $aff_number);
		$this->assignRef('svalue', $svalue);
		$this->assignRef('separ', $separ);		
		$this->assignRef('result', $result);
		$this->assignRef('search_aff_add', $search_aff_add);
		$this->assignRef('add_lightbox', $add_lightbox);	
		$this->assignRef('date_fmt', $date_fmt);
		$this->assignRef('link_folder', $link_folder);
		$this->assignRef('foldername', $foldername);
		$this->assignRef('check_search_asso', $check_search_asso);
		
		parent::display($tpl);
	}
}
?>
