<?php
/**
* @version $Id: user_event.php $
* @version		1.8.0 08/04/2012
* @package		com_myjspace
* @author       Bernard Saulmé
* @copyright	Copyright (C) 2010-2011-2012 Bernard Saulmé
* @license      GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

// Pas d'accés direct
defined( '_JEXEC' ) or die( 'Restricted access' );

// Component Helper
jimport('joomla.application.component.helper');

// -----------------------------------------------------------------------------

// Theses function are here because they can be call from user or admin interface

class BSUserEvent
{
// Constructeur
	function bshelperuserevent() {}

// Rename personal page folder or create	
	function Adm_ren_folder($foldername_new = '', $keep = 0, $url_redirect = 'index.php') 
	{
        require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'user.php';
		
		$user_page = New BSHelperUser();
		$foldername_old = $user_page->getFoldername(); // Get the actual folder

		$pparams = &JComponentHelper::getParams('com_myjspace');		
		$link_folder = $pparams->get('link_folder',1);
		$uploadadmin = $pparams->get('uploadadmin',1);
		$uploadimg = $pparams->get('uploadimg',1);		
		
		$foldername_new = trim($foldername_new); // Whitespace stripped from the beginning and end
		$foldername_new = trim($foldername_new, '/'); // '/' stripped from the beginning and end
		
		if ($user_page->checkFoldername($foldername_new)) { // Test if characters allowed
			if ($user_page->updateFoldername( $foldername_new, $link_folder, $keep )) {
				if ($uploadadmin == 1 || $uploadimg == 1) // Rename folder inside all pages content !
					BSUserEvent::adm_rename_folder_in_pages($foldername_old, $foldername_new);
			
				$this->setRedirect($url_redirect, JText::_('COM_MYJSPACE_FOLDERNAMEUPDATED'), 'message');
			} else
				$this->setRedirect($url_redirect, JText::_('COM_MYJSPACE_ERRUPDATINGFOLDERNAMEFILE'), 'error');
		} else
			$this->setRedirect($url_redirect, JText::_('COM_MYJSPACE_NOTVALIDFOLDERNAME'), 'error');
	}
	
// Removes the personal page record from the database and files
	function Adm_page_remove($page_id = 0, $url_redirect = 'index.php')
	{
        require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'user.php';
	
		$user_page = New BSHelperUser();
		$user_page->userid = $page_id; // To set pageid
		$user_page->loadUserInfoOnly(); // To get pagename
		$user_page->getFoldername(); // To get foldername
		
		$pparams = &JComponentHelper::getParams('com_myjspace');		
		$link_folder = $pparams->get('link_folder',1);
		
		if ($user_page->deletePage($link_folder)) // Delete
			$this->setRedirect($url_redirect, JText::_('COM_MYJSPACE_PAGEDELETED'), 'message');
		else
			$this->setRedirect($url_redirect, JText::_('COM_MYJSPACE_ERRDELETINGPAGE'), 'error');	

	}
	
// Save (=update) page content
	function Adm_save_page_content($page_id = 0, &$content = null, $name_page_max_size = 0, $url_redirect = 'index.php', $caller = 'site')
	{
        require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'user.php';
        require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'util.php';

		// Size test
		if ($name_page_max_size > 0 && strlen($content) > $name_page_max_size) {
			$this->setRedirect($url_redirect, JText::_('COM_MYJSPACE_ERRCREATEPAGESIZE').' '.$name_page_max_size, 'error');
			return;
		}

		// Param
		$pparams = &JComponentHelper::getParams('com_myjspace');
		$email_user = $pparams->get('email_user',0);	
		$email_admin_from = $pparams->get('email_admin_from','');	
		$add_hostname = $pparams->get('add_hostname',0);	
		
		$user_page = New BSHelperUser();
		$user_page->userid = $page_id; // To set pageid
		$user_page->getFoldername(); // To get foldername
		$user_page->loadUserInfoOnly(); // Get info (for pagename)

		// bBegin workaround
		// Update image link or link (relative & absolute), ok with Tiny mce V 3.4.3.2
		if ($caller == 'admin') {
			$uri_rel = str_replace('/administrator','',JURI::base(true));
			$content = str_replace('href="../'.$user_page->foldername.'/'.$user_page->pagename.'/', 'href="'.$uri_rel.'/'.$user_page->foldername.'/'.$user_page->pagename.'/', $content);
			$content = str_replace('src="../'.$user_page->foldername.'/'.$user_page->pagename.'/', 'src="'.$uri_rel.'/'.$user_page->foldername.'/'.$user_page->pagename.'/', $content);
		}
		// End workaround

		// Add hostname in / url 
		if ($add_hostname == 1) {
			$uri_rel = str_replace('/administrator','',JURI::base(true));
			$abs_rel = str_replace('/administrator','',JURI::base());
		
			$content = str_replace('href="'.$uri_rel.'/', 'href="'.$abs_rel, $content);
			$content = str_replace('src="'.$uri_rel.'/', 'src="'.$abs_rel, $content);

// If for files inside user page only : 			
//			$content = str_replace('href="'.$uri_rel.'/'.$user_page->foldername.'/'.$user_page->pagename, 'href="'.$abs_rel.$user_page->foldername.'/'.$user_page->pagename, $content);
//			$content = str_replace('src="'.$uri_rel.'/'.$user_page->foldername.'/'.$user_page->pagename, 'src="'.$abs_rel.$user_page->foldername.'/'.$user_page->pagename, $content);
		}
	
		$user_page->content = $content; // To set content
		if ($user_page->updateUserContent()) {
			if ($email_user == 1 && $caller == 'admin') { // Send email to user
				$subject = JText::sprintf('COM_MYJSPACE_EMAIL_SUBJECT2', $user_page->pagename);
				$site_msg = str_replace('/administrator', '', JURI::base());
				$body = JText::sprintf('COM_MYJSPACE_EMAIL_CONTENT2', $user_page->pagename, $site_msg);
				$user = &JFactory::getuser($user_page->userid);
				send_mail($email_admin_from , $user->email, $subject, $body);			
			}
			$this->setRedirect($url_redirect, JText::_('COM_MYJSPACE_EUPDATINGPAGE'), 'message');
		} else
			$this->setRedirect($url_redirect, JText::_('COM_MYJSPACE_ERRUPDATINGPAGE'), 'error');
	}

// Save (=update) page (out of content)
	function Adm_save_page_conf($page_id = 0, $pagename = null, $blockview = 0, $blockedit = 0, $publish_up = '', $publish_down = '', $metakey = '', $template = '', $mjs_model_page = 0, $url_redirect = 'index.php', $caller = 'site')
	{
        require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'user.php';
        require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'util.php';
		
		$user_page = New BSHelperUser();
		$user_page->userid = $page_id;
		$creation = 0;
		
		// Param
		$pparams = &JComponentHelper::getParams('com_myjspace');		
		$link_folder = $pparams->get('link_folder',1);
		$msg_error = $pparams->get('name_page_caract_error',JText::_('COM_MYJSPACE_NOTVALIDPAGENAME'));
		$name_page_caract_ok = $pparams->get('name_page_caract_ok','/^[A-Za-z0-9]+$/');
		$name_page_size_min = $pparams->get('name_page_size_min',0);
		$name_page_size_max = $pparams->get('name_page_size_max',20);
		$pagename_username = $pparams->get('pagename_username',0);
		$uploadadmin = $pparams->get('uploadadmin',1);
		$uploadimg = $pparams->get('uploadimg',1);	
		$email_admin = $pparams->get('email_admin',0);	
		$email_user = $pparams->get('email_user',0);	
		$email_admin_from = $pparams->get('email_admin_from','');	
		$email_admin_to = $pparams->get('email_admin_to','');
		$date_fmt = $pparams->get('date_fmt','Y-m-d H:i:s');
		$publish_mode = $pparams->get('publish_mode',2);
		$user_mode_view	= $pparams->get('user_mode_view',1);	
		
		$pagename = trim($pagename);
		if ( !preg_match($name_page_caract_ok, $pagename) || $pagename == '') { // Test avec les regles de nommage
			if ($caller != 'siteadmin')
				$this->setRedirect(JRoute::_(JRequest::getURI(), false), $msg_error, 'error');
			return 0;
		}
		if ( $pagename_username == 0 && (strlen($pagename) < $name_page_size_min || strlen($pagename) > $name_page_size_max)) { // Test la longueur du nommage
			if ($caller != 'siteadmin')
				$this->setRedirect(JRoute::_(JRequest::getURI(), false), JText::sprintf('COM_MYJSPACE_ADMIN_NAME_PAGE_SIZE_ERROR', $name_page_size_min, $name_page_size_max), 'error');
			return 0;
		}
		
		$user_page->loadUserInfoOnly(); // Charge les infos de la page de l'id si existe
		$id_recup = $user_page->userid;
		$user_page->userid = $page_id; // Cas si la page n'existait pas !
				
		if ( $user_page->pagename != $pagename ) { // Test si changement de nom (ou nouveau)
			if ($user_page->ifExistPageName($pagename)) {
				if ($caller != 'siteadmin')
					$this->setRedirect(JRoute::_(JRequest::getURI(), false), JText::_('COM_MYJSPACE_PAGEEXISTS'), 'error');
				return 0;	
			}
			$user_page->getFoldername();
			if ($user_page->pagename != '' && $link_folder == 1) { // Si la page existe & pages avec repertoires configuré
// A completer en cas de pb et pas bien affecte ? 
// if ( !$user_page->pagename || $user_page->pagename = '' || !(pagename) || pagename = '') 
				@rename(JPATH_SITE.DS.$user_page->foldername.DS.$user_page->pagename, JPATH_SITE.DS.$user_page->foldername.DS.$pagename);
				
				// Dans ce cas si on change le contenu de la page pour les url (cas ou page avec contenu autorisés)
				if ($uploadadmin == 1 || $uploadimg == 1) {
					// Chargement du contenu de la page
					$user_page->loadUserInfo();
					// Modifications des url d'images et de liens absolus et relatifs
					$user_page->content = str_replace('href="'.str_replace('/administrator','',JURI::base(true)).'/'.$user_page->foldername.'/'.$user_page->pagename, 'href="'.str_replace('/administrator','',JURI::base(true)).'/'.$user_page->foldername.'/'.$pagename, $user_page->content);
					$user_page->content = str_replace('href="'.str_replace('/administrator','',JURI::base()).$user_page->foldername.'/'.$user_page->pagename, 'href="'.str_replace('/administrator','',JURI::base()).$user_page->foldername.'/'.$pagename, $user_page->content);
					$user_page->content = str_replace('src="'.str_replace('/administrator','',JURI::base(true)).'/'.$user_page->foldername.'/'.$user_page->pagename, 'src="'.str_replace('/administrator','',JURI::base(true)).'/'.$user_page->foldername.'/'.$pagename, $user_page->content);
					$user_page->content = str_replace('src="'.str_replace('/administrator','',JURI::base()).$user_page->foldername.'/'.$user_page->pagename, 'src="'.str_replace('/administrator','',JURI::base()).$user_page->foldername.'/'.$pagename, $user_page->content);
					// re-Sauvegarde du contenu modifié !
					$user_page->updateUserContent();
				}
				
			} else {
				$creation = 1;
				// Creation page DB & repertoire et fichier (si page avec répertoire configuré)
				if ( !($id_recup) && (!$user_page->createPage($pagename) || ($link_folder == 1 && $user_page->CreateDirFilePage($pagename) == 0) )) { // A completer en cas d'erreur de l'un ou de l'autre seulement ?
					if ($caller != 'siteadmin')
						$this->setRedirect(JRoute::_(JRequest::getURI(), false), JText::_('COM_MYJSPACE_ERRCREATEPAGE'), 'error');
					return 0;
				}
				// Model Page(s) ?
				$mjs_model_page = BSUserEvent::model_pagename_id($mjs_model_page);
				if ($mjs_model_page) { // If model page to use
					if (intval($mjs_model_page) != 0) // page id
						$user_page->content = $user_page->GetContentPageId($mjs_model_page);
					else { // file content to upload
						$user_page->content = file_get_contents($mjs_model_page);
						
						if (strlen($user_page->content) <= 92160 && strstr($user_page->content, '<body>') && preg_match('#<body>(.*)</body>#Us', $user_page->content, $sortie))
							$user_page->content = $sortie[1];
					}
					
					if ($user_page->content)
						$user_page->updateUserContent();	
				}
				if ($email_admin == 1) { // Send Email to admin
					$subject = JText::sprintf('COM_MYJSPACE_EMAIL_SUBJECT1', $pagename);					
					$body = JText::sprintf('COM_MYJSPACE_EMAIL_CONTENT1', $pagename, JURI::base());
					send_mail($email_admin_from , $email_admin_to, $subject, $body);
				}
			}
		}

		// Maj. des infos transmises et conservation des anciennes si pas données
		$user_page->pagename = $pagename;
		if ($blockview != null)
			$user_page->blockView = $blockview;
		if ($blockedit != null)
			$user_page->blockEdit = $blockedit;

		// Maj. des Metakey transmis
		$user_page->metakey = trim(substr($metakey,0,150)); // Max. 150 caractères
		
		// Template choice
		$user_page->template = trim(substr($template,0,50)); // Max. 50 caractères
				
		// Maj. des dates de publication transmises au bon format
		$publish_up = trim($publish_up);
		$publish_down = trim($publish_down);
		
		$date_fmt_tab = explode(' ',$date_fmt);
		$user_page->publish_up = valid_date($publish_up, $date_fmt_tab[0]).' 00:00:00';
		$user_page->publish_down = valid_date($publish_down, $date_fmt_tab[0]).' 23:59:59';
		
		// Affectation des droits de mise à jour (tous $droits = 31) pour éviter qu'un user ne change ses parametres non autorisés en changement en url directe
		$droits = 0;
		if ($pagename_username == 0)
			$droits += 1;
		if ($user_mode_view == 1 || $caller == 'admin')
			$droits += 2;			
		if ($caller == 'admin')
			$droits += 4;
		if ($publish_mode == 2 || ($publish_mode == 1 && $caller == 'admin'))
			$droits += 8 + 16;
		$droits += 32; // metakey
		if ($user_page->template != '')
			$droits += 64;
			
		if ($user_page->SetConfPage($droits)) { // Mise à jour de la configuration de la page avec les bons parametres
			if ($email_user == 1 && $creation == 0 && $caller == 'admin') { // Send email to user
				$subject = JText::sprintf('COM_MYJSPACE_EMAIL_SUBJECT2', $pagename);
				$edit_msg = 'COM_MYJSPACE_TITLEMODEEDIT'.$blockedit;
				$view_msg = 'COM_MYJSPACE_TITLEMODEVIEW'.$blockview;
				$site_msg = str_replace('/administrator', '', JURI::base());
				$body = JText::sprintf('COM_MYJSPACE_EMAIL_CONTENT2', $pagename, $site_msg);
				$body .= "\n  ". JText::_('COM_MYJSPACE_TITLEMODEEDIT').' : '. JText::_($edit_msg);
				$body .= "\n  ". JText::_('COM_MYJSPACE_TITLEMODEVIEW').' : '. JText::_($view_msg);
				$user = &JFactory::getuser($user_page->userid);
				send_mail($email_admin_from , $user->email, $subject, $body);			
			}
			if ($caller != 'siteadmin')
				$this->setRedirect($url_redirect, JText::_('COM_MYJSPACE_EUPDATINGPAGE'), 'message');
		} else if ($caller != 'siteadmin')
			$this->setRedirect($url_redirect, JText::_('COM_MYJSPACE_ERRUPDATINGPAGE'), 'error');		
	}
	

	// Reset page hit
	function Adm_reset_page_access($page_id = 0, $url_redirect = 'index.php')
	{
        require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'user.php';
	
		$user_page = New BSHelperUser();
		$user_page->userid = $page_id; // To set pageid
		
		if ($user_page->ResetLastAccess()) // Reset hit
			$this->setRedirect($url_redirect, JText::_('COM_MYJSPACE_EUPDATINGPAGE'), 'message');
		else
			$this->setRedirect($url_redirect, JText::_('COM_MYJSPACE_ERRUPDATINGPAGE'), 'error');	
	}	
	
	
// Delete the selected file for a user
	function Adm_delete_file($page_id, $file_name, $url_redirect = 'index.php') {
	    require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'user.php';

		// Extra controls
		$forbiden_files = array('','.','..','index.html','index.htm','index.php','configuration.php','.htaccess',basename(__FILE__));
		
		if ( in_array(strtolower($file_name), $forbiden_files) ) { 
			if ($file_name == '')
				$file_name = JText::_('COM_MYJSPACE_UPLOADCHOOSE');
			$this->setRedirect($url_redirect, JText::_('COM_MYJSPACE_UPLOADERROR11').$file_name, 'error');	
			return;
		}
		
		$user_page = New BSHelperUser();
		$user_page->userid = $page_id; // To set pageid
		$user_page->loadUserInfoOnly(); // To get pagename
		$user_page->getFoldername(); // To get foldername
		
		if (@unlink(JPATH_ROOT.DS.$user_page->foldername.DS.$user_page->pagename.DS.$file_name))
			$this->setRedirect($url_redirect, JText::_('COM_MYJSPACE_UPLOADERROR10').$file_name, 'message');
		else
			$this->setRedirect($url_redirect, JText::_('COM_MYJSPACE_UPLOADERROR11').$file_name, 'error');	
	}
	
		
// Upload the file for a user into his personal folder 
	function Adm_upload_file($page_id, $FileObject, $url_redirect = 'index.php')
	{
	    require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'user.php';
	    require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'util.php';
		
		// User
		$user_page = New BSHelperUser();
		$user_page->userid = $page_id; // To set pageid
		$user_page->loadUserInfoOnly(); // To get pagename
		$user_page->getFoldername(); // To get foldername
		
		// Secure
		if ($user_page->pagename == '') {
			$this->setRedirect($url_redirect, JText::_(COM_MYJSPACE_UPLOADNOALLOWED), 'error');	
			return 0;
		}
	
		// 'Params'
		$DestPath = JPATH_ROOT.DS.$user_page->foldername.DS.$user_page->pagename.DS;
		$pparams = &JComponentHelper::getParams('com_myjspace');		
		$ResizeSizeX = $pparams->get('resize_x',800);
		$ResizeSizeY = $pparams->get('resize_y',600);
		$uploadfile = strtolower(str_replace(' ','',$pparams->get('uploadfile','*'))); // Files suffixes
		$uploadimg = $pparams->get('uploadimg',1);
		$uploadmedia = $pparams->get('uploadmedia',0);
		
		$forbiden_files = array('','.','..','index.html','index.htm','index.php','configuration.php','.htaccess',basename(__FILE__));
			
		$allowed_types = array();
		if ($uploadimg == 1)
			$allowed_types = array_merge($allowed_types, array('jpg','png','gif'));
		if ($uploadmedia == 1)
			$allowed_types = array_merge($allowed_types, array('flv','avi','mp4','mov','wmv'));
		
		$uploadfile = str_replace(array('|',' '),array(',',''),$uploadfile); // Compatibility with MyJspace < 1.7.7 and cleanup
		$uploadfile_tab = explode(',',$uploadfile);
		$allowed_types = array_merge($allowed_types, $uploadfile_tab);
		$File_max_size = $pparams->get('file_max_size','204800');
		$Dir_max_size = $pparams->get('dir_max_size','2097152');
		$StatusMessage = '';
		$ActualFileName = '';	
		$ReplaceFile = 'yes';
		$error = 0;
		$retour = false;

		//
		list($rien, $dir_size_var) = dir_size($DestPath);
		
		$FileBasename = basename($FileObject['name']);
		$type_parts = strtolower(pathinfo($FileObject['name'], PATHINFO_EXTENSION));
		if (!isset($FileObject) || $FileObject['size'] <= 0 || !($uploadfile_tab[0] == '*' || in_array($type_parts, $allowed_types)) || in_array(strtolower($FileBasename), $forbiden_files)) {		
			$StatusMessage = JText::_('COM_MYJSPACE_UPLOADERROR2');
			$error = 1;
		} else if ($FileObject["size"] > $File_max_size && $ResizeSizeX == 0 && $ResizeSizeY == 0) {
			$StatusMessage = JText::_('COM_MYJSPACE_UPLOADERROR4').convertSize($FileObject['size']).JText::_('COM_MYJSPACE_UPLOADERROR3').convertSize($File_max_size);
			$error = 1;
		} else if (($dir_size_var + $FileObject["size"]) > $Dir_max_size ) {
			$StatusMessage = JText::_('COM_MYJSPACE_UPLOADERROR5').convertSize($FileObject['size']+$dir_size_var).JText::_('COM_MYJSPACE_UPLOADERROR3').convertSize($Dir_max_size);
			$error = 1;
		} else {	
			$ActualFileName = $DestPath.DS.$FileBasename;													// formulate path to file
			if (file_exists($ActualFileName)) {																// check to see if the file already exists
				if ($ReplaceFile == 'yes') {
					$StatusMessage .= JText::_('COM_MYJSPACE_UPLOADERROR6');								// if so, we'll let the user know
					$error = 0;
				} else {
					$StatusMessage .= JText::_('COM_MYJSPACE_UPLOADERROR7');
					$error = 1;
				}
			}
			if ($ReplaceFile == 'yes') { // Voir le cas no si plus choix forcé
				if ($ResizeSizeX != 0 || $ResizeSizeY != 0) {												// if we need to resize the file
					$uploadedfile = $FileObject['tmp_name'];												// get the handle to the file that was just uploaded
					if (resize_image($uploadedfile, $ResizeSizeX, $ResizeSizeY, $ActualFileName) != true) {
						if ($FileObject["size"] <= $File_max_size)											// just process without resizing
							$retour = move_uploaded_file($FileObject['tmp_name'], $ActualFileName);
						else {
							$retour = false;
							$StatusMessage .= JText::_('COM_MYJSPACE_UPLOADERROR4').convertSize($FileObject['size']).JText::_('COM_MYJSPACE_UPLOADERROR3').convertSize($File_max_size);
						}
					} else {
						$StatusMessage .= JText::_('COM_MYJSPACE_UPLOADERROR1');							// Image resized : ok
						$error = 0;
						$retour = true;
					}
				} else
					$retour = move_uploaded_file($FileObject['tmp_name'], $ActualFileName);

				if ($retour == true) {
					$StatusMessage .= JText::_('COM_MYJSPACE_UPLOADERROR9');									// image uploaded ok to " . $ActualFileName . "!";						
					$error = 0;
				} else {
					$StatusMessage .= ' '.JText::_('COM_MYJSPACE_UPLOADERROR12');									// Upload error					
					$error = 1;
				}
			}
		}		

		$StatusMessage .= '.';
		$StatusMessage = str_replace("\n", '. ', $StatusMessage);
		$StatusMessage = str_replace(" .", '.', $StatusMessage);
		if (preg_match('#^. #', $StatusMessage) == 1)
			$StatusMessage = substr($StatusMessage, 1);

		if ($error == 0) {
			$u =& JURI::getInstance( JRequest::getURI() );
			$path_tab = explode('index.php', $u->getPath());
			$StatusMessage .= '</li><li>Url: '.$path_tab[0].$user_page->foldername.'/'.$user_page->pagename.'/'.$FileObject['name'];
			if ($pparams->get('editor_bbcode','1') == '1') {
				list($Originalwidth, $Originalheight, $image_type) = getimagesize($ActualFileName);
				if ($image_type > 0 && $image_type <= 3)
					$StatusMessage .= '</li><li>BBCode: [img]'.$path_tab[0].$user_page->foldername.'/'.$user_page->pagename.'/'.$FileObject['name'].'[/img]';
				else
					$StatusMessage .= '</li><li>BBCode: [url='.$path_tab[0].$user_page->foldername.'/'.$user_page->pagename.'/'.$FileObject['name'].']'.$FileObject['name'].'[/url]';
			}
			$this->setRedirect($url_redirect, $StatusMessage, 'message');
		} else
			$this->setRedirect($url_redirect, $StatusMessage, 'error');

		return !$error;
	}

	
// Delete all folders and indexes file for personal pages
	function adm_delete_folder()
	{
	    require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'user.php';
		  
		$user_page = New BSHelperUser();
		$user_page->getFoldername();
		$folder = $user_page->foldername;
		$username_list = $user_page->loadPagename();

		$nb_page = count($username_list);
		$compte_dir_ok = 0;
		$compte_dir_ko = 0;
		$compte_ide_ok = 0;
		$compte_ide_ko = 0;
		
		for ($i = 0; $i < $nb_page; $i++) {
			if (@unlink(JPATH_ROOT.DS.$folder.DS.$username_list[$i]['pagename'].DS.'index.php'))
				$compte_ide_ok = $compte_ide_ok +1;
			else
				$compte_ide_ko = $compte_ide_ko +1;
			
			if (@rmdir(JPATH_ROOT.DS.$folder.DS.$username_list[$i]['pagename']))
				$compte_dir_ok = $compte_dir_ok +1;
			else
				$compte_dir_ko = $compte_dir_ko +1;
		}

		return(JText::_('COM_MYJSPACE_ADMIN_DELETE_FOLDER_1').$compte_dir_ok.' : ok (dir), '.$compte_ide_ok.' : ok (index), ' .$compte_dir_ko.' : ko (dir), '.$compte_ide_ko.' : ko (index)'. ' /'. $nb_page);
	}

	
// Create (or Recreate after delete) all folders and indexes for personal pages
	function adm_create_folder()
	{
	    require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'user.php';

		$user_page = New BSHelperUser();
		$user_page->getFoldername();
		$username_list = $user_page->loadPagename();
		
		$nb_page = count($username_list);
		if ($nb_page <= 0)
			return('COM_MYJSPACE_ADMIN_CREATE_FOLDER_1');
		
		$retour_ok = 0;
		for ($i = 0; $i < $nb_page; $i++) {
			if ($user_page->CreateDirFilePage($username_list[$i]['pagename'], 0, $username_list[$i]['id']))
				$retour_ok = $retour_ok+1;
		}
		
		return(JText::_('COM_MYJSPACE_ADMIN_CREATE_FOLDER_2').$retour_ok.'/'.$nb_page);
	}
	
// Rename old foldername in all pages
	function adm_rename_folder_in_pages($foldername_old, $foldername_new)
	{
	    require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'user.php';

		$user_page = New BSHelperUser();
		$username_list = $user_page->loadPagename(-1, 0, 0, 0, 1, array('content'), $foldername_old); // Only page with 'potential' url content 	
		$nb_page = count($username_list);

		if ($nb_page <= 0)
			return 0;

		$uri_rel = str_replace('/administrator','',JURI::base(true));
		$uri_abs = str_replace('/administrator','',JURI::base()); 
		$user_page = New BSHelperUser();			
			
		for ($i = 0; $i < $nb_page; $i++) {
			// User info 
			$user_page->userid = $username_list[$i]['id'];
			$user_page->loadUserInfo();
			// Update image link or  link (relative & absolute)
			$user_page->content = str_replace('href="'.$uri_rel.'/'.$foldername_old.'/'.$user_page->pagename, 'href="'.$uri_rel.'/'.$foldername_new.'/'.$user_page->pagename, $user_page->content);
			$user_page->content = str_replace('href="'.$uri_abs.$foldername_old.'/'.$user_page->pagename, 'href="'.$uri_abs.$foldername_new.'/'.$user_page->pagename, $user_page->content);
			$user_page->content = str_replace('src="'.$uri_rel.'/'.$foldername_old.'/'.$user_page->pagename, 'src="'.$uri_rel.'/'.$foldername_new.'/'.$user_page->pagename, $user_page->content);
			$user_page->content = str_replace('src="'.$uri_abs.$foldername_old.'/'.$user_page->pagename, 'src="'.$uri_abs.$foldername_new.'/'.$user_page->pagename, $user_page->content);
			// Save modified content content
			$user_page->updateUserContent();
		}
		
		return 1;
	}
	

// move all pernonal pages folders to another root folder
// return the number of subfolders renamed
	function adm_rename_folders($old_root_folder, $new_root_folder)
	{
	    require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'user.php';
	
		$user_page = New BSHelperUser();
		$username_list = $user_page->loadPagename();
		
		$nb_page = count($username_list);
		if ($nb_page <= 0)
			return 0;
		
		$retour_ok = 0;
		for ($i = 0; $i < $nb_page; $i++) {
			if (@rename($old_root_folder.DS.$username_list[$i]['pagename'], $new_root_folder.DS.$username_list[$i]['pagename']))
				$retour_ok = $retour_ok+1;
		}
		return $retour_ok;
	}
	

	// List of model page
	function model_pagename_list()
	{
		$pparams = &JComponentHelper::getParams('com_myjspace');
		$model_pagename = str_replace('_',' ',$pparams->get('model_pagename',''));
		if ($model_pagename == '')
			return array();
		$model_pagename_tab = array_merge(array(JText::_('COM_MYJSPACE_MODELTOBESELECTED')) ,explode(',',$model_pagename));
		
		$model_pagename_tab_count = count($model_pagename_tab);
		$user_page = New BSHelperUser();
		
		for ($i = 1; $i < $model_pagename_tab_count; $i++) { // Page check and find the name
			if (intval($model_pagename_tab[$i]) == $model_pagename_tab[$i] && intval($model_pagename_tab[$i]) != 0) { // number
				$user_page->userid = $model_pagename_tab[$i];
				$user_page->loadUserInfoOnly(0);
				$model_pagename_tab[$i] = str_replace('_',' ',$user_page->pagename); // Replace the id with the pagename
			} else { // text
				// Check if pagename
				$user_page->userid = 0;
				$user_page->pagename = $model_pagename_tab[$i];
				$user_page->loadUserInfoOnly(1);
				if ($user_page->pagename == null) { // Not an existing pagename => file to upload 
					$chaine_tab = explode('.',str_replace('_',' ',basename($model_pagename_tab[$i])));
					$model_pagename_tab[$i] = $chaine_tab[0];
				} else
					$model_pagename_tab[$i] = str_replace('_',' ',$user_page->pagename);
			}
		}
		
		return $model_pagename_tab;
	}

	// Retreive the page id or file to use
	function model_pagename_id($select_id = 0)
	{
		if ($select_id == 0)
			return 0;
			
		$pparams = &JComponentHelper::getParams('com_myjspace');
		$model_pagename = $pparams->get('model_pagename','');
		$model_pagename_tab = array_merge(array(JText::_('COM_MYJSPACE_MODELTOBESELECTED')) ,explode(',',$model_pagename));

		if ($select_id >= count($model_pagename_tab))
			return 0;
			
		$user_page = New BSHelperUser();
		
		if (intval($model_pagename_tab[$select_id]) == 0) { // if not number ...
			$user_page->userid = 0;
			$user_page->pagename = $model_pagename_tab[$select_id];
			$user_page->loadUserInfoOnly(1);
			
			if ($user_page->userid != 0)
				$model_pagename_tab[$select_id] = $user_page->userid; // Replace the name with the the page id
			// if $user_page->userid = 0 => not a pagename => file name
		}

		return $model_pagename_tab[$select_id];
	}
	
}

?>
