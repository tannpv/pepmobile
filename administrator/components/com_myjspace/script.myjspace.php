<?php
/**
* @version $Id: schipt.myjspace.php $
* @version		1.7.6 10/01/2012
* @author       Bernard Saulmé
* @copyright	Copyright (C) 2012 Bernard Saulmé
* @license      GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/
 
// no direct access
defined('_JEXEC') or die('Restricted access');

class com_myjspaceInstallerScript
{
	public function __construct($installer)
	{
		$this->installer = $installer;
	}
 
	public function postflight( $type, $parent ) {

		// Installation & migrations
		define('__ROOTINSTALL__', dirname(__FILE__));
		require_once(__ROOTINSTALL__.'/install.myjspace.php');
	
		// J! >= 1.6 ACL
		$query = "SELECT COUNT(*) FROM  #__assets WHERE title = 'com_myjspace' AND name = 'com_myjspace' and rules LIKE '%user.%'";
		$db	= JFactory::getDBO();
		$db->setQuery($query);
		$db->query();
		$count = $db->loadResult();	
		if (!isset($count))
			return false;

		if ($count == 0) { // No Rules => Store the default ACL rules into the database
			$defaultRules = array(
				'core.admin' => array(),
				'core.manage' => array(),
				'user.config' => array('2' => 1),
				'user.delete' => array('2' => 1),
				'user.edit' => array('2' => 1),
				'user.myjspace' => array('1' => 1, '2' => 1),
				'user.search' => array('1' => 1, '2' => 1),
				'user.see' => array('1' => 1, '2' => 1)
			);
			jimport('joomla.access.rules');
			$rules	= new JRules($defaultRules);
			$asset	= JTable::getInstance('asset');

			if (!$asset->loadByName('com_myjspace')) {
				$root = JTable::getInstance('asset');
				$root->loadByName('root.1');
				$asset->name = 'com_myjspace';
				$asset->title = 'com_myjspace';
				$asset->setLocation($root->id, 'last-child');
			}
			$asset->rules = (string)$rules;
			
	        if(! $asset->check() || ! $asset->store()) { 
                $this->setError($asset->getError());
				return false;
			}
		}

		return true;
	}
}

?>
