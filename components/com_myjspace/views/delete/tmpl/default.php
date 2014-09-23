<?php
/**
* @version $Id: default.php $ 
* @version		1.7.7 17/03/2011
* @package		com_myjspace
* @author       Bernard Saulmé
* @copyright	Copyright (C) 2010-2011 Bernard Saulmé
* @license      GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

// Pas d'accès direct
defined('_JEXEC') or die('Restricted access');
$document = &JFactory::getDocument();
$document->addStyleSheet(JURI::root() . 'components/com_myjspace/assets/myjspace.css');
?>
<h2><?php echo JText::_('COM_MYJSPACE_TITLEDELETE'); ?></h2>
<div class="myjspace">
	<br />
	<fieldset class="adminform">
	<legend><?php echo  JText::_('COM_MYJSPACE_AREYOUSURE'); ?></legend>
		<form method="post" action="<?php echo JRoute::_('index.php'); ?>">
			<input name="option" type="hidden" value="com_myjspace" />
			<input name="task" type="hidden" value="del_page" />
			<input name="Itemid" type="hidden" value="<?php echo $this->Itemid; ?>" />
			<input type="submit" class="button mjp-config" value="<?php echo JText::_('COM_MYJSPACE_DELETE'); ?>" />
		</form>
	</fieldset>
</div>
