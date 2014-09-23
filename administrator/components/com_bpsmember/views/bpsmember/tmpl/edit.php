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
 $id =JRequest::getVar('id', null, 'GET');
//var_dump($id);
?>
<form action="<?php echo JRoute::_('index.php?option=com_bpsmember&layout=edit&id='.(int) $this->item->id); ?>" 
	method="post" name="adminForm" id="bpsmember-form" class="form-validate">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'BPS MEMBER DETAIL' ); ?></legend>
		<ul class="adminformlist">
		<?php //foreach($this->form->getFieldset() as $field): ?>
		<?php //endforeach; ?>
        
        	<li><?php echo $this->form->getLabel('id'); ?>
             <?php echo $this->form->getInput('id'); ?></li>
             <li class="clss_user"><?php echo $this->form->getLabel('user'); ?>
             <?php if($id>0){?>
             <input id="jform_user" class="inputbox required " readonly="readonly" type="text" size="80" value="  <?php echo $this->member; ?>" name="jform[user]" aria-required="true" required="required" aria-invalid="true">
             <?php }else
             {
                 echo $this->form->getInput('user'); 
             }
              ?>
             <span class="inputbox_mess" >User name is used </span></li>
             <li><?php echo $this->form->getLabel('password'); ?>
             <?php echo $this->form->getInput('password'); ?><span class="inputbox_mess" >user khong hop le</span></li>
        	<li><?php echo $this->form->getLabel('first_name'); ?>
             <?php echo $this->form->getInput('first_name'); ?></li>
             <li><?php echo $this->form->getLabel('last_name'); ?>
             <?php echo $this->form->getInput('last_name'); ?></li>
               <li><?php echo $this->form->getLabel('company_name'); ?>
             <?php echo $this->form->getInput('company_name'); ?></li>
             <li><?php echo $this->form->getLabel('email'); ?>
             <?php echo $this->form->getInput('email'); ?><span class="inputbox_mess" >user khong hop le</span></li>
		</ul>
	</fieldset>
	<div>
		<input type="hidden" name="task" value="bpsmember.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
