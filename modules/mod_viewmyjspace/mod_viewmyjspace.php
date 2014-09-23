<?php
/*
* @version $Id: mod_viewmyjspace.php $ 
* @version		1.8.0 09/04/2012
* @author       Bernard Saulm�
* @copyright	Copyright (C) 2010-2011-2012 Bernard Saulm�
* @license      GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

// Pas d'acces direct
defined('_JEXEC') or die('Restricted access');

// Inclus les fonctions mod_viewmyjspace une fois 
require_once (dirname(__FILE__).DS.'helper.php');

// Parameter reading
$showmode = $params->get( 'showmode', 1);  // Counter or page list or both
$showmode0 = $params->get( 'showmode0', 'inherit'); // Contaet align
$showmode1 = $params->get( 'showmode1', 1); // Content to be displayed
$showmode2 = $params->get( 'showmode2', 1); // Content orientation
$showmode3 = $params->get( 'showmode3', 1); // Style for URL joomla or folder
$trie_tmp = $params->get( 'triemode', 2);
$affmax = $params->get( 'affmax', 20);
$affimgcon = $params->get( 'affimgcon', 1);
$delaisimgcon = intval($params->get( 'delais', 604800));
$emptymode = $params->get( 'emptymode', 0);
$nonvisiblemode = $params->get( 'nonvisiblemode', 0);
$date_fmt = $params->get( 'date_fmt', 'Y-m-d');
$preview_width = $params->get( 'preview_width', '100px'); // Max Image size
$preview_height = $params->get( 'preview_height', '100px');
$forced_itemid = $params->get( 'forced_itemid', 0);

$itemid = 0;
if ($forced_itemid == 1) {
	if ( ($itemid = JRequest::getInt( 'Itemid' , 0) ) == 0) { // If not into the parameter
	
		if (version_compare(JVERSION,'1.6.0','lt'))
			$menu = &JSite::getMenu();
		else {
			$app = JFactory::getApplication();
			$menu = $app->getMenu();
		}
		
		$defaultMenu = & $menu->getDefault();
		$itemid = $defaultMenu->id; // Get the default menu value
	}
}

if ($showmode1 < 0 || $showmode1 > 127) // Control
	$showmode1 = 1;

$pparams = &JComponentHelper::getParams('com_myjspace');
$repertoire = $pparams->get('foldername','myjsp');

if ($showmode == 1 || $showmode == 2)
	$names = modViewMyJspaceHelper::getListPage($trie_tmp, $affmax, $emptymode, $nonvisiblemode, 1, $showmode1);
else
	$names = null;
 
if ($showmode == 0 || $showmode == 2)
	$nbpages = modViewMyJspaceHelper::getNbPage($emptymode, $nonvisiblemode);
else
	$nbpages = -1;
	
require(JModuleHelper::getLayoutPath('mod_viewmyjspace'));

?>
