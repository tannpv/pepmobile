<?php

/**
 * @package		Joomla.Tutorials
 * @subpackage	Component
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		License GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die;

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>
<form  enctype="multipart/form-data" action="<?php echo JRoute::_('index.php?option=com_uploadpdf&layout=edit&id='.(int) $this->item->id); ?>" 
	method="post" name="adminForm" id="uploadpdf-form" class="form-validate">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Upload File DETAILS' ); ?></legend>
		<ul class="adminformlist">
		<?php //foreach($this->form->getFieldset() as $field): ?>
			<li><?php //echo $field->label;echo $field->input;?></li>
		<?php //endforeach; ?>
          <li><?php echo $this->form->getLabel('id'); ?>
             <?php echo $this->form->getInput('id'); ?></li>
        <?php if ($this->item->title!=""):?>
         <li><label id="jform_url-lbl"  title="" for="jform_url" >Link Text </label>
             <input readonly="readonly" size="100" type="text" value="http://dev.pepmobile.org/images/pdf/<?php echo  $this->item->title; ?>" />
            <input name='jform[oldfile]' size="40" type="hidden" value="<?php echo  $this->item->title ?>" />
         </li>
         <?php endif;?>
            <li><label id="jform_url-lbl"  title="" for="jform_url" >Other file</label>
                <?php echo $this->form->getInput('url'); ?>
            </li>
         <li><?php echo $this->form->getLabel('state'); ?>
             <?php echo $this->form->getInput('state'); ?>
         </li>
		</ul>
	</fieldset>
	<div>
		<input type="hidden" name="task" value="uploadpdf.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
