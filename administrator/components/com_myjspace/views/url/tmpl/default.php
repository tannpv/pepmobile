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
?>
<div class="myjspace-admin width-70">
	<form action="<?php echo JRoute::_('index.php'); ?>" method="post" name="adminForm">
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_MYJSPACE_FOLDERNAME');?></legend>
			<?php echo JText::_('COM_MYJSPACE_FOLDERNAMEINFO');?>
			<br />
			
			<table class="admintable">
				<tr>
					<td class="key">
						<label><?php echo  JText::_('COM_MYJSPACE_FOLDERNAME'); ?></label>
					</td>
					<td>
						<input type="text" name="mjs_foldername" value="<?php echo $this->link; ?>" />
<?php
						if ( stristr($this->link,'myjspace') !== false )
							echo JText::_( 'COM_MYJSPACE_FOLDERNAME_KO' );
?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label><?php echo JText::_('COM_MYJSPACE_FOLDERNAME_KEEP'); ?></label>
					</td>
					<td>
						<input type="checkbox" name="keep" value="1" />
					</td>
				</tr>
			</table>

			<input name="option" type="hidden" value="com_myjspace" />
			<input name="task" type="hidden" value="adm_ren_folder" />
		</fieldset>
		<br />
	</form>
</div>