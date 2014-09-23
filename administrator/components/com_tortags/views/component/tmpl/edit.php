<?php
/**
* TorTags component for Joomla 1.6, Joomla 1.7
* @package TorTags
* @author Tormix Team
* @Copyright Copyright (C) Tormix, www.tormix.com
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/

// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>
<table class="admin" width="100%">
	<tbody>
			<td valign="top" width="100%" >
				<form action="<?php echo JRoute::_('index.php?option=com_tortags&view=component&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="item-form" class="form-validate" enctype="multipart/form-data" >
					<?php
						echo JHtml::_('tabs.start','item-tabs');
						foreach ($this->form->getFieldsets() as $fieldset) {
						$fields = $this->form->getFieldset($fieldset->name);
						if (count($fields) > 0) {
						echo JHtml::_('tabs.panel',JText::_($fieldset->label), 'item-'.$fieldset->name);
					?>
						<fieldset class="adminform" >
							<ul class="adminformlist">
							<?php
								foreach($this->form->getFieldset($fieldset->name) as $field) {
							?>
								<li><?php echo $field->label; echo $field->input; ?></li>
							<?php } ?>
							</ul>
							<br class="clr" />
							</fieldset>
					<?php }} ?>
					<?php echo JHtml::_('tabs.end'); ?>
					<div>
						<input type="hidden" name="task" value="item.edit" />
						<?php echo JHtml::_('form.token'); ?>
					</div>
				</form>
			</td>
		</tr>
	</tbody>
</table>

