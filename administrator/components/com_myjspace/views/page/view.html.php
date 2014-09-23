<?php
/**
* @version $Id: view.html.php $
* @version		1.8.0 04/04/2012
* @package		com_myjspace
* @author       Bernard Saulmé
* @copyright	Copyright (C) 2010-2011-2012 Bernard Saulmé
* @license      GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );
jimport( 'joomla.html.parameter' );

class MyjspaceViewPage extends JView
{
	function display($tpl = null)
	{
        require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'user.php';
        require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'util.php';
		require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'edit_plus.php';
		
		JToolBarHelper::title( JText::_( 'COM_MYJSPACE_HOME' ) .': <small>'.JText::_( 'COM_MYJSPACE_PAGE' ).'</small>', 'article.png' );
		JToolBarHelper::apply('adm_save_page', JText::_( 'COM_MYJSPACE_SAVE_DETAILS' ));
		JToolBarHelper::apply('adm_save_page_all');
		JToolBarHelper::save('adm_save_page_all_exit');
		JToolBarHelper::divider();
		
		// Config
		$pparams = &JComponentHelper::getParams('com_myjspace');
		
		// E_name for pagebreak
		$e_name = JRequest::getVar( 'e_name' , 'mjs_editable');
		
		$link_folder = $pparams->get('link_folder',1);
		$link_folder_print = $pparams->get('link_folder_print',1);
		
		// User info
		$pageid = JRequest::getVar( 'id', -1);
		if ($pageid < 0) {	
			$pageid_tab = JRequest::getVar( 'cid', array(0));
			$pageid = $pageid_tab[0];
		}
		
		// User (for page) info
		$table   = JUser::getTable();
		if($table->load($pageid)) { // Test if user exist before to retrive info
			$user =& JFactory::getUser($pageid);
		} else { // User no no exist any more !
			$user = new stdClass();
			$user->id = -1;
			$user->username = ' '; // '' to do NOT display a page with no user
			$user->name = '';
		}
		// Personnal page info
		$user_page = New BSHelperUser();
		$user_page->userid = $pageid;
		$user_page->loadUserInfo();
		
		// Page link
		if ($user_page->pagename != '') {
			$user_page->getFoldername();
			if ($link_folder_print == 1 && $link_folder == 1)
				$link = JURI::base().$user_page->foldername.'/'.$user_page->pagename;
			else
				$link = JURI::base().'index.php?option=com_myjspace&view=see&pagename='.$user_page->pagename;
		} else 
			$link = null;
		$link = str_replace('/administrator','',$link); 

		// Editor selection
		$editor_selection = $pparams->get('editor_selection','myjsp');
		if (check_editor_selection($editor_selection) == false || $editor_selection == '-') // Use the Joomla default editor
			$editor_selection = null;

		// Editor 'windows' size
		$edit_x = $pparams->get('admin_edit_x','100%');
		$edit_y = $pparams->get('admin_edit_y','400px');

		// Editor button
		if ($pparams->get('allow_editor_button', 1) == 1)
			$editor_button = true;
		else
			$editor_button = false;
			
		$date_fmt = $pparams->get('date_fmt','Y-m-d H:i:s');
		$uploadimg = $pparams->get('uploadimg',1);
		$uploadmedia = $pparams->get('uploadmedia',1);
		$publish_mode = $pparams->get('publish_mode',2);
		$downloadimg = $pparams->get('downloadimg', 1);
		
		// Files uploaded
		if ( $link_folder == 1 && ($uploadimg > 0 || $uploadmedia > 0)) {
			list($page_number, $page_size) = dir_size(JPATH_ROOT.DS.$user_page->foldername.DS.$user_page->pagename);
			$page_size = round($page_size/1024);
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

		// Pagebreak button
		$pagebreak = $pparams->get('pagebreak', 1);
		
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

		if ($user_page->last_access_date == '0000-00-00 00:00:00' || $user_page->last_access_date ==  null)
			$this->assignRef('last_access_date', $vide);
		else
			$this->assignRef('last_access_date', date($date_fmt, strtotime($user_page->last_access_date)));

		// Lock or not
		$lock_img = JURI::base().'components/com_myjspace/assets/checked_out.png';
		$lock_img = str_replace('/administrator','',$lock_img);
		$aujourdhui = time();
		if (strtotime($user_page->publish_up) >= $aujourdhui)
			$img_publish_up = '<img src="'.$lock_img.'" alt="lock" />';
		else
			$img_publish_up = '';
		if ($user_page->publish_down != '0000-00-00 00:00:00'  && $user_page->publish_down != null && strtotime($user_page->publish_down) < $aujourdhui)
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
		
		// Templates list proposed for user selection
		$template_list = $pparams->get('template_list', '');
		if ($template_list != '')
			$tab_template = explode(',', $template_list);
		else
			$tab_template = null;
		
		// Automatic configuration :-)
		if ($user_page->pagename == '' || $link_folder == 0) {
			$uploadadmin = 0;
			$uploadimg = 0;
			$uploadmedia = 0;
		}
		
		$this->assignRef('editor_selection',$editor_selection);
		$this->assignRef('userid', $user_page->userid);
		$this->assignRef('username', $user->username);
		$this->assignRef('pagename', $user_page->pagename);
		$this->assignRef('link', $link);
		$this->assignRef('blockview', $user_page->blockView);
		$this->assignRef('blockedit', $user_page->blockEdit);
		$this->assignRef('last_access_ip', $user_page->last_access_ip);
		$this->assignRef('hits', $user_page->hits);
		$this->assignRef('content', $user_page->content);
		$this->assignRef('edit_x',$edit_x);
		$this->assignRef('edit_y',$edit_y);
		$this->assignRef('pagebreak', $pagebreak);		
		$this->assignRef('resize_x', $resize_x);
		$this->assignRef('resize_y', $resize_y);		
		$this->assignRef('uploadimg', $uploadimg);
		$this->assignRef('uploadmedia', $uploadmedia);
		$this->assignRef('file_max_size', $file_max_size);
		$this->assignRef('tab_list_file', $tab_list_file);
		$this->assignRef('downloadimg', $downloadimg);
		$this->assignRef('uploadadmin', $uploadadmin);
		$this->assignRef('link_folder', $link_folder);
		$this->assignRef('page_size', $page_size);
		$this->assignRef('page_number', $page_number);
		$this->assignRef('foldername',$user_page->foldername);
		$this->assignRef('publish_mode', $publish_mode);
		$this->assignRef('date_fmt_pub', $date_fmt_pub);
		$this->assignRef('img_publish_up', $img_publish_up);
		$this->assignRef('img_publish_down', $img_publish_down);
		$this->assignRef('metakey', $user_page->metakey);
		$this->assignRef('dir_max_size', $dir_max_size);
		$this->assignRef('file_img_size', $file_img_size);
		$this->assignRef('tab_template', $tab_template);
		$this->assignRef('template', $user_page->template);
		$this->assignRef('editor_button', $editor_button);
		$this->assignRef('e_name', $e_name);
		
		parent::display($tpl);
	}
	
}
