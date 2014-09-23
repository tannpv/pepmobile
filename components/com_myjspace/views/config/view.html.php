<?php
/**
* @version $Id: view.html.php $
* @version		1.8.0 30/05/2012
* @package		com_myjspace
* @author       Bernard Saulmé
* @copyright	Copyright (C) 2010-2011-2012 Bernard Saulmé
* @license      GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

// Pas d'accès direct

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

/**
 * HTML View pour la page 
 * @package myjspace
 */

class MyjspaceViewConfig extends JView
{
	function display($tpl = null)
	{
        require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'user.php';
        require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'util.php';
        require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'user_event.php';
		
		// Itemid
		$Itemid = JRequest::getInt( 'Itemid' , 0);
		
		// User info
		$user = &JFactory::getuser();
		$pageid = $user->id;

		// Config
		$pparams = &JComponentHelper::getParams('com_myjspace');
		$file_max_size = $pparams->get('file_max_size', 204800);
		$auto_create_page = $pparams->get('auto_create_page', 3);	
		
		// Personnal page info
		$user_page = New BSHelperUser();
		$user_page->userid = $pageid;
		$user_page->loadUserInfoOnly();
		$user_page->getFoldername();
		if ($user_page->pagename == '')
			$user_page->blockView = $pparams->get('user_mode_view_default', 0);
		
		// Links
		$link_folder = $pparams->get('link_folder', 1);
		$link_folder_print = $pparams->get('link_folder_print',1 );
			
		// Test if foldername exist => Admin
		$alert_root_page = 0;
		if (!BSHelperUser::ifExistFoldername($user_page->foldername) && $link_folder == 1) {
			$alert_root_page = 1;
		}	

		// Create automaticaly page if none & if option 'auto_create_page' is activated & less or equal than 1 model
		$model_page_list = BSUserEvent::model_pagename_list(); 	// Model page list
		if ( $alert_root_page == 0 && $user_page->pagename == '' && ($auto_create_page == 1 || $auto_create_page == 3) && count($model_page_list) <= 2) {
			if ($pparams->get('user_mode_view', 1) == 0)
				$blockview = $pparams->get('user_mode_view_default', 0); // Do do take param in this case (safety)
			else
				$blockview = JRequest::getVar('mjs_mode_view', 0);
			
			if (count($model_page_list) == 2)
				$model_page_id = 1;
			else
				$model_page_id = 0;
				
			BSUserEvent::Adm_save_page_conf($pageid, $user->username, $blockview, 0, '', '', '', '', $model_page_id, null, 'siteadmin');
			$user_page->userid = $pageid;
			$user_page->loadUserInfoOnly(); // Reload the user data
		}
		
		// Page link
		if ($user_page->pagename != '') { // Yet or not yes a page
			if ($link_folder_print == 1 && $link_folder == 1)
				$link = JURI::base().$user_page->foldername.'/'.$user_page->pagename.'/';
			else
				$link = JURI::base().'index.php?option=com_myjspace&amp;view=see&amp;pagename='.$user_page->pagename;
				
			$link = Jroute::_($link);
		} else 
			$link = null;

		$user_mode_view = $pparams->get('user_mode_view', 1);
		$page_increment = $pparams->get('page_increment', 1);
		$pagename_username = $pparams->get('pagename_username', 0);
		$date_fmt = $pparams->get('date_fmt', 'Y-m-d H:i:s');
		$uploadimg = $pparams->get('uploadimg', 1);
		$uploadmedia = $pparams->get('uploadmedia', 1);
		$publish_mode = $pparams->get('publish_mode', 2);

		// Files uploaded
		if ( $link_folder == 1 && ($uploadimg > 0 || $uploadmedia > 0)) {
			list($page_number, $page_size) = dir_size(JPATH_ROOT.DS.$user_page->foldername.DS.$user_page->pagename);
		} else {
			$page_size = 0;
			$page_number = 0;		
		}
		$page_size = convertSize($page_size);
		$dir_max_size = convertSize($pparams->get('dir_max_size', 2097152)); // Max upload
		$file_img_size = convertSize($pparams->get('file_max_size', 204800));
		$resize_x = $pparams->get('resize_x', 800);
		$resize_y = $pparams->get('resize_y', 600);
		if ($resize_x != 0 || $resize_y != 0) {
			if ($resize_x == 0)
				$resize_x = '&#8734';
			if ($resize_y == 0)
				$resize_y = '&#8734';
			$file_img_size .= JText::sprintf('COM_MYJSPACE_LABELUSAGE3',$resize_x,$resize_y);
		}
		
		// Files list
		$uploadadmin = $pparams->get('uploadadmin', 1);
		$forbiden_files = array('.','..','index.html','index.htm','index.php');
		$tab_list_file = null;
		if ($uploadadmin == 1 && ($uploadimg > 0 || $uploadmedia > 0))
			$tab_list_file = list_file_dir(JPATH_ROOT.DS.$user_page->foldername.DS.$user_page->pagename, array('*'), $forbiden_files, 1);
			
		// Dates check if no set with interesting date
		$vide = '';
		if ($user_page->create_date == '0000-00-00 00:00:00' || $user_page->create_date == null)
			$this->assignRef('create_date', $vide);
		else
			$this->assignRef('create_date', date($date_fmt, strtotime($user_page->create_date)));

		if ($user_page->last_update_date == '0000-00-00 00:00:00' || $user_page->last_update_date == null)
			$this->assignRef('last_update_date', $vide);
		else
			$this->assignRef('last_update_date', date($date_fmt, strtotime($user_page->last_update_date)));

		if ($user_page->last_access_date == '0000-00-00 00:00:00' || $user_page->last_access_date == null)
			$this->assignRef('last_access_date', $vide);
		else
			$this->assignRef('last_access_date', date($date_fmt, strtotime($user_page->last_access_date)));

		// Lock or not
		$lock_img = JURI::base().'components/com_myjspace/assets/checked_out.png';
		$aujourdhui = time();
		if (strtotime($user_page->publish_up) >= $aujourdhui)
			$img_publish_up = '<img src="'.$lock_img.'" alt="lock" />';
		else
			$img_publish_up = '';
		if ($user_page->publish_down != '0000-00-00 00:00:00' && $user_page->publish_down != null && strtotime($user_page->publish_down) < $aujourdhui)
			$img_publish_down = '<img src="'.$lock_img.'" alt="lock" />';
		else
			$img_publish_down = '';
			
		// Publish date : for several date format
		$date_fmt_tab = explode(' ',$date_fmt);
		$replace = array('%Y', '%d', '%m');
		$search = array('Y', 'd', 'm');		
		$date_fmt_pub = str_replace($search, $replace, $date_fmt_tab[0]);
		
		if ($user_page->publish_up == '0000-00-00 00:00:00' || $user_page->publish_up == null)
			$this->assignRef('publish_up', $vide);
		else
			$this->assignRef('publish_up', date($date_fmt_tab[0], strtotime($user_page->publish_up)));
			
		if ($user_page->publish_down == '0000-00-00 00:00:00' || $user_page->publish_down == null)
			$this->assignRef('publish_down', $vide);
		else
			$this->assignRef('publish_down', date($date_fmt_tab[0], strtotime($user_page->publish_down)));
					
		// Automatic configuration :-)
		if ($user_page->pagename == '' || $link_folder == 0) {
			$uploadadmin = 0;
			$uploadimg = 0;
			$uploadmedia = 0;
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
		
		// Templates list proposed for user selection
		$template_list = $pparams->get('template_list', '');
		if ($template_list != '')
			$tab_template = explode(',', $template_list);
		else
			$tab_template = null;
	
		// Vars assign
		$this->assignRef('Itemid', $Itemid);
		$this->assignRef('pagename_username', $pagename_username);
		$this->assignRef('alert_root_page', $alert_root_page);
		$this->assignRef('user_mode_view', $user_mode_view);
		$this->assignRef('blockview', $user_page->blockView);
		$this->assignRef('blockedit', $user_page->blockEdit);
		$this->assignRef('link', $link);
		$this->assignRef('pagename', $user_page->pagename);
		$this->assignRef('username', $user->username);
		$this->assignRef('hits', $user_page->hits);
		$this->assignRef('page_increment', $page_increment);
		$this->assignRef('uploadimg', $uploadimg);
		$this->assignRef('page_size', $page_size);
		$this->assignRef('page_number', $page_number);
		$this->assignRef('uploadadmin', $uploadadmin);
		$this->assignRef('uploadmedia', $uploadmedia);
		$this->assignRef('file_max_size', $file_max_size);
		$this->assignRef('tab_list_file', $tab_list_file);
		$this->assignRef('publish_mode', $publish_mode);
		$this->assignRef('date_fmt_pub', $date_fmt_pub);
		$this->assignRef('img_publish_up', $img_publish_up);
		$this->assignRef('img_publish_down', $img_publish_down);
		$this->assignRef('metakey', $user_page->metakey);
		$this->assignRef('dir_max_size', $dir_max_size);
		$this->assignRef('file_img_size', $file_img_size);
		$this->assignRef('tab_template', $tab_template);
		$this->assignRef('template', $user_page->template);
		$this->assignRef('model_page_list', $model_page_list);

		parent::display($tpl);
	}
}

?>