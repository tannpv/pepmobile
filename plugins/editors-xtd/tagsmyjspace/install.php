<?php
/**
* @version $Id: install.php $ 
* @version		1.7.7 07/02/2012
* @package		plg_jsmyjspace
* @author       Bernard Saulmé
* @copyright	Copyright (C) 2012 Bernard Saulmé
* @license      GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/*
 * Enable, the plugin after install >= J1.6
 */
 
class plgeditorsxtdtagsmyjspaceInstallerScript {
	function postflight($type, $parent) {

		if ($type == 'install') {
			$db = JFactory::getDBO();
			// Get this plugin group, element
			$group = 'editors-xtd';
			$element = 'tagsmyjspace';
			// Enable plugin
			$query = 'UPDATE `#__extensions`' .
				' SET `enabled` = 1' .
				' WHERE folder = '.$db->Quote($group) .
				' AND element = '.$db->Quote($element);
				
			$db->setQuery($query);
			try {
				$db->Query();
			}
			catch(JException $e)
			{
				// Return warning message that cannot update order			
				echo JText::_('Cannot enable the plugin');
			}
		}
   }
}