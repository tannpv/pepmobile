<?php
/**
* @version $Id: uninstall.myjspace.php $ 
* @version		1.8.0 09/04/2012
* @package		com_myjspace
* @author       Bernard Saulmé
* @copyright	Copyright (C) 2010-2011-2012 Bernard Saulmé
* @license      GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/
 
// no direct access
defined('_JEXEC') or die('Restricted access');

?>
<h1>MyJspace Uninstall</h1>
<?php
	// Config
	$pparams = &JComponentHelper::getParams('com_myjspace');
	$foldername = $pparams->get('foldername','myjsp');
	
	// Get old content, save the content into param and drop old table #__myjspace_cfg
	echo "<p>Recreating the #__myjspace table and it's content in case of downgrade to older version than BS MyJspace 1.8.0 ...<br /></p>";

	$db	=& JFactory::getDBO();		
	$query = "CREATE TABLE IF NOT EXISTS `#__myjspace_cfg` ( `foldername` varchar(100) NOT NULL, PRIMARY KEY (`foldername`) ) ENGINE=MyISAM DEFAULT CHARSET=utf8";
	$db->setQuery($query);
	$db->query();

	$db	=& JFactory::getDBO();
	$query = "DELETE FROM `#__myjspace_cfg`";
	$db->setQuery($query);
	$db->query();	

	$db	=& JFactory::getDBO();
	$query = "INSERT INTO `#__myjspace_cfg` (`foldername`) VALUES (".$db->Quote($foldername).");";
	$db->setQuery($query);
	$db->query();
?>
<p>
<b><u>bye bye :-(</u></b><br /><br />
BS MyJspace tables (with user's data) and files into the folder '<?php echo $foldername; ?>' are not deleted during the uninstall process<br />
So you can upgrade MyJspace keeping user's data installing the new version<br />
If you don't want to keep them: delete manually folders/files and tables #__myjspace and #__myjspace_cfg<br />
</p>
