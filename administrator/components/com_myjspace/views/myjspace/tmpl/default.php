<?php
/**
* @version $Id: default.php $ 
* @version		1.7.3 15/10/2011
* @package		com_myjspace
* @author       Bernard Saulmé
* @copyright	Copyright (C) 2010-2011 Bernard Saulmé
* @license      GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

// Pas d'accès direct
defined('_JEXEC') or die('Restricted access');
?>
<div class="myjspace width-70">
	<fieldset class="adminform">
		<legend><?php echo JText::_('COM_MYJSPACE_TITLE');?></legend>
		<?php echo $this->version; ?>
	</fieldset>
	
<?php if ($this->newversion != '' ) { ?>
	<fieldset class="adminform">
		<legend><?php echo JText::_('COM_MYJSPACE_NEWVERSION');?></legend>
		<?php echo '<span style="color:orange">'.JText::_('COM_MYJSPACE_NEWVERSION').'</span> '.$this->newversion; ?>
	</fieldset>
<?php } ?>

<br />
</div>

