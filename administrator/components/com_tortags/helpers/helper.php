<?php
/**
* TorTags component for Joomla 1.6, Joomla 1.7
* @package TorTags
* @author Tormix Team
* @Copyright Copyright (C) Tormix, www.tormix.com
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/
defined('_JEXEC') or die;

class TorTagsHelper
{
	public static function addSubmenu($submenu) 
	{
		JSubMenuHelper::addEntry(JText::_('COM_TORTAGS_SUBMENU_COMPONENTS'), 'index.php?option=com_tortags&view=components', $submenu == 'components');
		JSubMenuHelper::addEntry(JText::_('COM_TORTAGS_SUBMENU_TAGS'), 'index.php?option=com_tortags&view=tags', $submenu == 'tags');
		JSubMenuHelper::addEntry(JText::_('COM_TORTAGS_SUBMENU_ABOUT'), 'index.php?option=com_tortags&view=about', $submenu == 'about');
	}

	public static function getVersion() 
	{
		$params = self::getManifest();
		return $params->version;
	}

	public static function getManifest()
	{
		$db = JFactory::getDbo();
		$db->setQuery('SELECT `manifest_cache` FROM #__extensions WHERE element="com_tortags"');
		$params = json_decode($db->loadResult());
		return $params;
	}
}
