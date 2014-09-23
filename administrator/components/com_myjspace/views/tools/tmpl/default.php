<?php
/**
* @version $Id: default.php $ 
* @version		1.7.3 14/10/2011
* @package		com_myjspace
* @author       Bernard Saulmé
* @copyright	Copyright (C) 2010-2011 Bernard Saulmé
* @license      GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

// Pas d'accès direct
defined('_JEXEC') or die('Restricted access');
?>
<div class="myjspace width-70">
<?php if ($this->link_folder == 1) { ?>
		
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_MYJSPACE_ADMIN_SYNCHRO_DB_FOLDER').': '.JText::_('COM_MYJSPACE_ADMIN_DELETE_FOLDER');?></legend>
			<a href="<?php echo Jroute::_('index.php?option=com_myjspace&amp;task=adm_delete_folder'); ?>"><?php echo JText::_('COM_MYJSPACE_ADMIN_DELETE_FOLDER');?></a><?php echo JText::_('COM_MYJSPACE_ADMIN_DELETE_FOLDER_2');?>
		</fieldset>

		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_MYJSPACE_ADMIN_SYNCHRO_DB_FOLDER').': '.JText::_('COM_MYJSPACE_ADMIN_CREATE_FOLDER');?></legend>
			<a href="<?php echo Jroute::_('index.php?option=com_myjspace&amp;task=adm_create_folder'); ?>"><?php echo JText::_('COM_MYJSPACE_ADMIN_CREATE_FOLDER');?></a>
		</fieldset>

<?php } else echo JText::_('COM_MYJSPACE_ADMIN_LINK_MSG'); ?>

<br />
</div>
