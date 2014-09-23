<?php
/**
* TorTags component for Joomla 1.6, Joomla 1.7
* @package TorTags
* @author Tormix Team
* @Copyright Copyright (C) Tormix, www.tormix.com
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/
defined('_JEXEC') or die('Restricted access');
 
class com_tortagsInstallerScript
{

	function install($parent) 
	{
	}
 
	function uninstall($parent) 
	{
	}

	function update($parent) 
	{
	}
 
	function preflight($type, $parent) 
	{
	}

	function postflight($type, $parent) 
	{
	?>
	<div>
		<h2>TorTags</h2>
		<div>
			This is a unique component to create tag system on your site.<br />
			Through this component, and a few plug-ins you can add tags to virtually all components using the editor in their fields. 
		</div>
		<small>Version 1.0.0</small>
	</div>
	<?php
	}
}
