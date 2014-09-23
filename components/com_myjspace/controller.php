<?php
/**
* @version $Id: controller.php $
* @version		1.8.0 07/04/2012
* @package		com_myjspace
* @author       Bernard Saulmé
* @copyright	Copyright (C) 2010-2011-2012 Bernard Saulmé
* @license      GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

class MyjspaceController extends JController
{
	function display()
	{
	  	$user = &JFactory::getuser();
		$pparams = &JComponentHelper::getParams('com_myjspace');
		$acces_ok = true;
		$get_view = JRequest::getCmd( 'view', '' );
		$get_task = JRequest::getCmd( 'task', '' );

		// J! >= 1.6 ACL
		if ( version_compare(JVERSION,'1.6.0','ge') ) {
			// View
			if ($get_view != '' && !JFactory::getUser()->authorise('user.'.$get_view, 'com_myjspace') )
				$acces_ok = false;
		}
	
		// If not connected => redirection to login page for 'admin' & 'delete', 'edit'
		if (!isset($user->username) && ( $get_view == 'config' || $get_view == 'delete' || $get_view == 'edit' || ( $get_view == 'see' && JRequest::getInt( 'id' , 0) == 0 && JRequest::getCmd( 'pagename' , '') == '' ) ) ) {
			$acces_ok = false; // Login redirection
		}

		if ($acces_ok == false && !isset($user->username) ) { // Redirect to login page
			$uri = JFactory::getURI();
			$return = $uri->toString();
			if ( version_compare(JVERSION,'1.6.0','ge') ) // J! >= 1.6
				$url = 'index.php?option=com_users&view=login';
			else
				$url = 'index.php?option=com_user&view=login';
			$url .= '&return='.base64_encode($return); // to redirect to the originaly call page
			$this->setRedirect(JRoute::_($url, false));		
			return;
		} else if ($acces_ok == false && isset($user->username) ) { // Not allowed
			$this->setRedirect('index.php', JText::_('COM_MYJSPACE_NOTALLOWED') , 'error');		
		}

		parent::display();
	}

// Compatibility <= 1.2
	function view_page()
	{
		$id = JRequest::getInt( 'id' );
		$return	=  JRoute::_('index.php?option=com_myjspace&view=see&id='.$id, false);
		$this->setRedirect( $return );
	}

// Save page content
	function save()
	{
		if (version_compare(JVERSION,'1.6.0','ge') && !JFactory::getUser()->authorise('user.config', 'com_myjspace') ) {
			$this->setRedirect('index.php', JText::_('COM_MYJSPACE_NOTALLOWED') , 'error');			
			return;
		}

		$Itemid = JRequest::getInt('Itemid' , 0);		
		$user = &JFactory::getuser(); // for 'my' page
		if ($user->id == 0) {
			$this->setRedirect('index.php?Itemid='.$Itemid, JText::_('COM_MYJSPACE_NOTALLOWED'), 'error');
			return;
		}

        require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'user_event.php';
        require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'util.php';
		
		$content = JRequest::getVar('mjs_content', '@@vide@@', 'POST', 'STRING', JREQUEST_ALLOWRAW);
		if ($content == '@@vide@@') { // To allow really empty page
			$this->setRedirect('index.php?Itemid='.$Itemid, JText::_('COM_MYJSPACE_ERRUPDATINGPAGE'), 'error');
			return;
		}

		$pparams = &JComponentHelper::getParams('com_myjspace');
		if ( $pparams->get('editor_bbcode',1) == 1)
			$content = bs_bbcode($content, $pparams->get('editor_bbcode_width', 800), $pparams->get('editor_bbcode_height'));

		BSUserEvent::Adm_save_page_content($user->id, $content, $pparams->get('name_page_max_size', 92160), JRoute::_('index.php?option=com_myjspace&view=see&Itemid='.$Itemid, false), 'site');
	}
	
// Save page config (& create page if no exist)
	function save_config()
	{
		if (version_compare(JVERSION,'1.6.0','ge') && !JFactory::getUser()->authorise('user.config', 'com_myjspace') ) {
			$this->setRedirect('index.php', JText::_('COM_MYJSPACE_NOTALLOWED') , 'error');			
			return;
		}
		
		$Itemid = JRequest::getInt('Itemid' , 0);
		$user = &JFactory::getuser(); // for 'my' page
		if ($user->id == 0) {
			$this->setRedirect('index.php?Itemid='.$Itemid, JText::_('COM_MYJSPACE_NOTALLOWED'), 'error');
			return;
		}
		
        require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'user_event.php';
        require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'user.php';
		
		$pparams = &JComponentHelper::getParams('com_myjspace');

		$pagename = JRequest::getVar('mjs_pagename', '');
		$resethits = JRequest::getVar('resethits', 'no');
		$publish_up = JRequest::getVar('publish_up', '0000-00-00');
		$publish_down = JRequest::getVar('publish_down', '0000-00-00');
		$metakey = JRequest::getVar('mjs_metakey', '');
		$mjs_template = JRequest::getVar('mjs_template', '');
		$mjs_model_page = JRequest::getInt('mjs_model_page', 0);
		
		if ($resethits != 'yes') {
			if ($pparams->get('user_mode_view',1) == 0)
				$blockview = $pparams->get('user_mode_view_default',0); // Do do take param in this case (safety)
			else
				$blockview = JRequest::getVar('mjs_mode_view', 0);
						
			BSUserEvent::Adm_save_page_conf($user->id, $pagename, $blockview, 0, $publish_up, $publish_down, $metakey, $mjs_template, $mjs_model_page, JRoute::_('index.php?option=com_myjspace&view=config&Itemid='.$Itemid, false), 'site');
		} else {
			BSUserEvent::Adm_reset_page_access($user->id, JRoute::_('index.php?option=com_myjspace&view=config&Itemid='.$Itemid, false));
		}
	}

// Delete page
	function del_page()
	{
		if (version_compare(JVERSION,'1.6.0','ge') && !JFactory::getUser()->authorise('user.delete', 'com_myjspace') ) {
			$this->setRedirect('index.php', JText::_('COM_MYJSPACE_NOTALLOWED') , 'error');			
			return;
		}

		$Itemid = JRequest::getInt('Itemid' , 0);
		$user = &JFactory::getuser(); // To delete 'my' page
		if ($user->id == 0) {
			$this->setRedirect('index.php?Itemid='.$Itemid, JText::_('COM_MYJSPACE_NOTALLOWED'), 'error');
			return;
		}

        require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'user_event.php';
		
		$pparams = &JComponentHelper::getParams('com_myjspace');
		$auto_create_page = $pparams->get('auto_create_page',3);
	
		if ($auto_create_page != 3 && $auto_create_page != 1)
			BSUserEvent::Adm_page_remove($user->id, JRoute::_('index.php?option=com_myjspace&view=config&Itemid='.$Itemid, false) );
		else
			BSUserEvent::Adm_page_remove($user->id, JRoute::_('index.php?option=com_myjspace&view=see&Itemid='.$Itemid, false) );
	}


// Upload file for user page
	function upload_file()
	{
		if (version_compare(JVERSION,'1.6.0','ge') && !JFactory::getUser()->authorise('user.config', 'com_myjspace') ) {
			$this->setRedirect('index.php', JText::_('COM_MYJSPACE_NOTALLOWED') , 'error');			
			return;
		}
	
		$Itemid = JRequest::getInt('Itemid' , 0);
		$user = &JFactory::getuser();
		if ($user->id == 0) {
			$this->setRedirect('index.php?Itemid='.$Itemid, JText::_('COM_MYJSPACE_NOTALLOWED'), 'error');
			return;
		}

		require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'user_event.php';
		
		if (!isset($_FILES['upload_file']))
			return;
		$FileObject = $_FILES['upload_file'];

		BSUserEvent::Adm_upload_file($user->id, $FileObject, JRoute::_('index.php?option=com_myjspace&view=config&Itemid='.$Itemid, false));
	}
	
// Delete file from user page
	function delete_file()
	{
		if (version_compare(JVERSION,'1.6.0','ge') && !JFactory::getUser()->authorise('user.config', 'com_myjspace') ) {
			$this->setRedirect('index.php', JText::_('COM_MYJSPACE_NOTALLOWED') , 'error');			
			return;
		}

		$Itemid = JRequest::getInt('Itemid' , 0);
		$user = &JFactory::getuser();
		if ($user->id == 0) {
			$this->setRedirect('index.php?Itemid='.$Itemid, JText::_('COM_MYJSPACE_NOTALLOWED'), 'error');
			return;
		}

		require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'user_event.php';
		
		$file_name = JRequest::getVar('delete_file');
		BSUserEvent::Adm_delete_file($user->id, $file_name, JRoute::_('index.php?option=com_myjspace&view=config&Itemid='.$Itemid, false));
	}
	
}
?>
