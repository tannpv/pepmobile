<?php
/**
* @version $Id: view.html.php $
* @version		1.8.0 24/04/2012
* @package		com_myjspace
* @author       Bernard Saulmé
* @copyright	Copyright (C) 2010-2011-2012 Bernard Saulmé
* @license      GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

jimport( 'joomla.application.component.view');

class MyjspaceViewEdit extends JView
{
	function display($tpl = null)
	{
        require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'user.php';
        require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'user_event.php';
	    require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'edit_plus.php';
	    require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'util.php';

		// Config
		$pparams = &JComponentHelper::getParams('com_myjspace');
		
		// E_name for pagebreak
		$e_name = JRequest::getVar( 'e_name' , 'mjs_editable');
				
		// User info
		$user = &JFactory::getuser();
		if ((JRequest::getInt( 'id' , 0)) > 0)
			$pageid = JRequest::getInt( 'id' );
		else
			$pageid = $user->id;

		// Itemid
		$Itemid = JRequest::getInt( 'Itemid' , 0);
		
		// Personnal page info
		$user_page = New BSHelperUser();
		$user_page->userid = $pageid;
		$user_page->loadUserInfo();
		$user_page->getFoldername();
		
		// Test if foldername exist => Admin
		$link_folder = $pparams->get('link_folder', 1);
		if (!BSHelperUser::ifExistFoldername($user_page->foldername) && $link_folder == 1) {
			$mainframe = JFactory::getApplication();
			$mainframe->redirect(JRoute::_('index.php?option=com_myjspace&view=config', false));
			return;
		}

		// Create automaticaly page if none, if option 'auto_create_page' is activated & max 1 model
		$auto_create_page = $pparams->get('auto_create_page', 3);
		$model_page_list = BSUserEvent::model_pagename_list();  // Model page list
		if ( $user_page->pagename == '' && ($auto_create_page == 2 || $auto_create_page == 3) && count($model_page_list) < 2) {
			if ($pparams->get('user_mode_view', 1) == 0)
				$blockview = $pparams->get('user_mode_view_default', 0); // Do do take param in this case (safety)
			else
				$blockview = JRequest::getVar('mjs_mode_view', 0);
			BSUserEvent::Adm_save_page_conf($pageid, $user->username, $blockview, 0, '', '', '', '', 0, null, 'siteadmin');
			$user_page->userid = $pageid;
			$user_page->loadUserInfoOnly(); // Reload the user data
		}

		if ( $user_page->pagename == '' ) { // Page not found => Go to create it
			$mainframe = JFactory::getApplication();
			$mainframe->redirect(JRoute::_('index.php?option=com_myjspace&view=config', false));
			return;
		}
		
		$this->assignRef('content', $user_page->content);
		$msgvide = null;
		$this->assignRef('msg', $msgvide );
		if ($user_page->blockView == null) // Test Not necessary any more, since redirect if no page ?
			$this->assignRef('msg', JText::_('COM_MYJSPACE_PAGENOTFOUND') );
		else if ($user_page->blockEdit == 1)
			$this->assignRef('msg', JText::_('COM_MYJSPACE_EDITBLOCKED') );

		// Links
		$link_folder = $pparams->get('link_folder',1);
	
		// Editor selection
		$editor_selection = $pparams->get('editor_selection', 'myjsp');
		if (check_editor_selection($editor_selection) == false || $editor_selection == '-') // Use the Joomla default editor
			$editor_selection = null;

		// Editor button
		if ($pparams->get('allow_editor_button', 1) == 1)
			$editor_button = true;
		else
			$editor_button = false;

		// Editor 'windows' size
		$edit_x = $pparams->get('user_edit_x', '100%');
		$edit_y = $pparams->get('user_edit_y', '600px');
			
		// Pagebreak button
		$pagebreak = $pparams->get('pagebreak', 1);
		
		// Upload images 
		$uploadimg = $pparams->get('uploadimg', 1);
		$uploadmedia = $pparams->get('uploadmedia', 1);
		$downloadimg = $pparams->get('downloadimg', 1);
		if ($link_folder == 0) { // Automatic configuration :-)
			$uploadimg = 0;
			$uploadmedia = 0;
			$downloadimg = 0;
		}

        // Web page title
		$app = &JFactory::getApplication();
		$document = &JFactory::getDocument();
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

		// Vars Assign
		$this->assignRef('Itemid', $Itemid);
		$this->assignRef('uploadimg', $uploadimg);
		$this->assignRef('uploadmedia', $uploadmedia);
		$this->assignRef('downloadimg', $downloadimg);
		$this->assignRef('editor_selection', $editor_selection);
		$this->assignRef('edit_x', $edit_x);
		$this->assignRef('edit_y', $edit_y);		
		$this->assignRef('foldername', $user_page->foldername);
		$this->assignRef('pagename', $user_page->pagename);
		$this->assignRef('pagebreak', $pagebreak);
		$this->assignRef('template', $user_page->template);
		$this->assignRef('editor_button', $editor_button);
		$this->assignRef('e_name', $e_name);
		
		parent::display($tpl);
	}
}
?>
