<?php
/**
* @version $Id: view.html.php $ 
* @version		1.7.4 26/11/2011
* @package		com_myjspace
* @author       Bernard Saulmé
* @copyright	Copyright (C) 2010-2011 Bernard Saulmé
* @license      GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

jimport( 'joomla.application.component.view');

class MyjspaceViewDelete extends JView
{
	function display($tpl = null)
	{
        require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'user.php';
		
		// Config
		$pparams = &JComponentHelper::getParams('com_myjspace');
		
		// Itemid
		$Itemid = JRequest::getInt( 'Itemid' , 0);
		
		// User info
		$user = &JFactory::getuser();
		$pageid = $user->id;
		
		// Personnal page info
		$user_page = New BSHelperUser();
		$user_page->userid = $pageid;
		$user_page->loadUserInfoOnly();
		
		// If no page
		if ($user_page->userid == 0) {
			$mainframe = JFactory::getApplication();
			$mainframe->redirect(JRoute::_('index.php?option=com_myjspace&view=see', false));
			return;		
		}
		
		$app = &JFactory::getApplication();
		$document = &JFactory::getDocument();		

        // Web page title
		if ($pparams->get('pagetitle',1) == 1) {
			$title = $user_page->pagename;
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
		$pathway->addItem($user_page->pagename, '');	

		// Vars assign
		$this->assignRef('Itemid', $Itemid);
		
		parent::display($tpl);
	}
}
?>
