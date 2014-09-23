<?php
/**
* @version $Id: session_joomla.php $
* @version		06/04/2012
* @package		pluging : BS ccSimpleUploader for Tiny Mce
* @author       Bernard Saulm�
* @copyright	Copyright (C) 2010-2011-2012 Bernard Saulm�
* @license      GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

define( '_JEXEC', 1 );
define( 'DS', DIRECTORY_SEPARATOR);
$tab_base = explode(DS.'plugins'.DS.'editors',__FILE__);
define( 'JPATH_BASE', $tab_base[0] );

require_once (JPATH_BASE.DS.'includes'.DS.'defines.php' );
require_once (JPATH_BASE.DS.'includes'.DS.'framework.php' );

jimport ('joomla.plugin.helper'); // J!1.5
jimport( 'joomla.html.parameter' );

function iam_connected() {
	// Environement
	$view = isset($_REQUEST['view']) ? $_REQUEST['view'] : '';
	if ($view == 'page') // Specific for MyJspace backend
		$site = 'administrator';
	else
		$site = 'site';

	$mainframe = JFactory::getApplication($site);
	$session   = JFactory::getSession();
	
	// Allow upload from editor plugin myjsp ?
	$plugin =& JPluginHelper::getPlugin('editors', 'myjsp'); // No plugin or not enable
	if (!$plugin)
		return 0;
	$params_object = new JParameter( $plugin->params ); // Not allowed to upload from the plugin
	if ($params_object->get('allow_upload',1) == 0)
		return 0;
		
	// Allow upload from com_myjspace ?
	$pparams = &JComponentHelper::getParams('com_myjspace');
	if ($pparams->get('uploadmedia',1) == 0 && $pparams->get('downloadimg',1) == 0 )
		return 0;
		
	// And connected
	$user = &JFactory::getuser();
	return $user->id;
}

function my_rep($user_id = 0) {
    require_once JPATH_BASE.DS.'components'.DS.'com_myjspace'.DS.'helpers'.DS.'user.php';

	// Safety controls
	$pparams = &JComponentHelper::getParams('com_myjspace');
	if ($pparams->get('link_folder',1) == 0)
		return null;

	$user = &JFactory::getuser($user_id);
	if ($user->id) {
		$user_page = New BSHelperUser();
		$user_page->userid = $user->id;
		$user_page->loadUserInfoOnly();
		$user_page->getFoldername();
		
		if ($user_page->pagename == '')
			return null;
		else
			return $user_page->foldername.'/'.$user_page->pagename.'/';
	}
	return null;
}

// Function to check if the admin can upload for user = from back-end + admin rights
function upload_isAdmin($user) {

	if (JFactory::getApplication()->isAdmin() && version_compare(JVERSION,'1.6.0','ge') && $user->authorise('core.manage', 'com_myjspace') )
		return true;
	
	if (JFactory::getApplication()->isAdmin() && version_compare(JVERSION,'1.6.0','lt') && ($user->usertype == "Super Administrator" || $user->usertype == "Administrator" ))
		return true;

	return false;
}
?>
