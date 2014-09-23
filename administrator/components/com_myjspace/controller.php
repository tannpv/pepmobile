<?php
/**
* @version $Id: controller.php $
* @version		1.8.1 23/05/2012
* @package		com_myjspace
* @author       Bernard Saulmé
* @copyright	Copyright (C) 2010-2011-2012 Bernard Saulmé
* @license      GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

jimport('joomla.application.component.controller');

class MyjspaceController extends JController
{
// Displays a view
	function display( )
	{
		// Add menu
        JSubMenuHelper::addEntry(JText::_('COM_MYJSPACE_HOME'),'index.php?option=com_myjspace');
        JSubMenuHelper::addEntry(JText::_('COM_MYJSPACE_LINKS'),'index.php?option=com_myjspace&view=url');
        JSubMenuHelper::addEntry(JText::_('COM_MYJSPACE_PAGES'),'index.php?option=com_myjspace&view=pages');
        JSubMenuHelper::addEntry(JText::_('COM_MYJSPACE_TOOLS'),'index.php?option=com_myjspace&view=tools');
        JSubMenuHelper::addEntry(JText::_('COM_MYJSPACE_HELP'),'index.php?option=com_myjspace&view=help');
	
		switch($this->getTask())
		{
			case 'edit'    :
			{
				JRequest::setVar( 'view', 'page' );
			} break;
			case 'remove'    :
			{
				JRequest::setVar( 'task', 'remove' );
			} break;
			case 'pages.createpage'    :
			{
				JRequest::setVar( 'view', 'createpage' );

				// If no root pages forder existing & root page folder supposed to be used
				// Config
				$pparams = &JComponentHelper::getParams('com_myjspace');
				require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'user.php';
				$user_page = New BSHelperUser();
				$user_page->getFoldername();
				$link_folder = $pparams->get('link_folder', 1);
				// Test itself
				if (!BSHelperUser::ifExistFoldername($user_page->foldername) && $link_folder == 1) {
					$this->setRedirect(JRoute::_('index.php?option=com_myjspace&view=url', false), JText::_('COM_MYJSPACE_ALERTYOURADMIN'), 'error');
					return;
				}
				
			} break;
		}
	
		parent::display();
	}
	
// create an empty page or a page with a model
	function adm_create_page()
	{
        require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'user_event.php';
        require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'user.php';
		
		$pagename = JRequest::getVar('mjs_pagename', '');
		$user_name = JRequest::getVar('mjs_username', '');
		$mjs_model_page = JRequest::getInt('mjs_model_page', 0);
		
		if ($pagename == '')
			$pagename = $user_name;

		$user = &JFactory::getuser($user_name);
	
		if ($user) {
			if (BSHelperUser::ifExistUserId($user->id)) // already a page
				$this->setRedirect(JRoute::_('index.php?option=com_myjspace&view=pages', false), JText::_('COM_MYJSPACE_USERPAGEEXISTS'), 'error');
			else // create empty page or a page with a model
				BSUserEvent::Adm_save_page_conf($user->id, $pagename, 0,  0, '', '', '', '', $mjs_model_page, JRoute::_('index.php?option=com_myjspace&view=page&task=edit&id='.$user->id, false), 'admin');
		} else // user do no exist
			$this->setRedirect(JRoute::_('index.php?option=com_myjspace&view=pages', false), '', 'error');
	}
	
// Remove the personal page record from the database and forder & files from disk
	function remove()
	{
        require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'user_event.php';
		$pageid_tab = JRequest::getVar('cid', array(0));
		
		BSUserEvent::adm_page_remove(intval($pageid_tab[0]), JRoute::_('index.php?option=com_myjspace&view=pages', false) );
	}
	
// Save (update configuration & page)
	function adm_save_page_all()
	{
		$this->adm_save_page_content();	
		$this->adm_save_page();
	}

// Save (update configuration & page) & exit to pages list
	function adm_save_page_all_exit()
	{
		$this->adm_save_page_content('index.php?option=com_myjspace&view=pages');	
		$this->adm_save_page('index.php?option=com_myjspace&view=pages');
	}
	
// Save(update) page configuration 'only'
	function adm_save_page($url = '')
	{
        require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'user_event.php';
		$id = JRequest::getInt( 'id', 0);
		$pagename = JRequest::getVar('mjs_pagename', 0);
		$blockview = JRequest::getVar('mjs_mode_view', 0);
		$blockedit = JRequest::getVar('mjs_mode_edit', 0);
		$resethits =  JRequest::getVar('resethits','no');
		$publish_up = JRequest::getVar('publish_up');
		$publish_down = JRequest::getVar('publish_down');
		$metakey = JRequest::getVar('mjs_metakey', '');
		$mjs_template = JRequest::getVar('mjs_template', '');
	
		if ($url == '')
			$url = 'index.php?option=com_myjspace&view=page&id='.$id;
			
		if ($resethits != 'yes') {
			BSUserEvent::Adm_save_page_conf($id, $pagename, $blockview, $blockedit, $publish_up, $publish_down, $metakey, $mjs_template, 0, JRoute::_($url, false) , 'admin');
		} else {
			BSUserEvent::Adm_reset_page_access($id, JRoute::_($url, false));
		}
	}

// Upload file for user page
	function upload_file()
	{
		$Itemid = JRequest::getInt('Itemid' , 0);
		$id = JRequest::getInt('id', 0);

		require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'user_event.php';
		
		if (!isset($_FILES['upload_file']))
			return;
		$FileObject = $_FILES['upload_file'];

		BSUserEvent::Adm_upload_file($id, $FileObject, JRoute::_('index.php?option=com_myjspace&view=page&id='.$id, false));
	}
	
// Delete file from user page
	function delete_file()
	{
		$Itemid = JRequest::getInt('Itemid' , 0);
		$id = JRequest::getInt('id', 0);

		require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'user_event.php';
		
		$file_name = JRequest::getVar('delete_file');
		BSUserEvent::Adm_delete_file($id, $file_name, JRoute::_('index.php?option=com_myjspace&view=page&id='.$id, false));
	}	

// Save(update) page content 'only'
	function adm_save_page_content($url = '')
	{
        require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'user_event.php';
        require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'util.php';

		$id = JRequest::getInt('id', 0);
		
		$content = JRequest::getVar('mjs_content', '@@vide@@', 'POST', 'STRING', JREQUEST_ALLOWRAW);
		if ($content == '@@vide@@') { // To allow really empty page
			$this->setRedirect(JRoute::_('index.php', false), JText::_('COM_MYJSPACE_ERRUPDATINGPAGE'), 'error');
			return;
		}		

		$pparams = &JComponentHelper::getParams('com_myjspace');
		if ( $pparams->get('editor_bbcode',1) == 1)
			$content = bs_bbcode($content, $pparams->get('editor_bbcode_width', 800), $pparams->get('editor_bbcode_height'));

		if ($url == '')
			$url = 'index.php?option=com_myjspace&view=page&id='.$id;
			
		BSUserEvent::Adm_save_page_content($id, $content, $pparams->get('name_page_max_size',92160), JRoute::_($url, false), 'admin');
	}
	
// Rename/create/move the personnal Root pages folder or subfolders
	function adm_ren_folder () 
	{
        require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'user_event.php';
		
		$foldername_new = JRequest::getVar('mjs_foldername');
		$keep = JRequest::getInt('keep', 0);
		
		BSUserEvent::Adm_ren_folder($foldername_new, $keep, JRoute::_('index.php?option=com_myjspace&view=url', false));
	}

// Create folders and link pages for all personal pages
	function adm_create_folder()
	{
        require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'user_event.php';
		
		$msg = BSUserEvent::Adm_create_folder();
		$this->setRedirect(JRoute::_('index.php?option=com_myjspace&view=tools', false), JText::_($msg), 'message');
	}

// Delete folders and link pages for all personal pages
	function adm_delete_folder()
	{
        require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'user_event.php';
		
		$msg = BSUserEvent::Adm_delete_folder();
		$this->setRedirect(JRoute::_('index.php?option=com_myjspace&view=tools', false), JText::_($msg), 'message');
	}
	
}
?>
