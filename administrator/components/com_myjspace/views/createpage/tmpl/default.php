﻿<?php
/**
* @version $Id: default.php $ 
* @version		1.8.0 08/04/2011
* @package		com_myjspace
* @author       Bernard Saulmé
* @copyright	Copyright (C) 2011 Bernard Saulmé
* @license      GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

// Pas d'accès direct
defined('_JEXEC') or die('Restricted access');

$document = &JFactory::getDocument();

$document->addStyleSheet(JURI::root() . 'components/com_myjspace/assets/myjspace.css');
?>
<div class="myjspace">
	<div class="col width-45 fltlft">

		<form action="<?php echo JRoute::_('index.php'); ?>" method="post" name="adminForm">
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'COM_MYJSPACE_LABELUSERDETAILS' ); ?></legend>
			<table class="admintable">
				<tr>
					<td class="key">
						<label><?php echo  JText::_('COM_MYJSPACE_LABELUSERNAME'); ?></label>
					</td>
					<td>
						<input type="text" name="mjs_username" id="mjs_username" class="inputbox" size="40" value="" />
					</td>
				</tr>
				<tr>
					<td class="key">
						<label><?php echo JText::_('COM_MYJSPACE_TITLENAME'); ?></label>
					</td>
					<td>
						<input type="text" name="mjs_pagename" id="mjs_pagename" class="inputbox" size="40" value="" />
					</td>
				</tr>
<?php
				$model_page_list_count = count($this->model_page_list);
				if ($model_page_list_count > 2) { // If several (2 pages + text_to_choixe) model page list
?>
				<tr>
					<td class="key">
						<label><?php echo JText::_( 'COM_MYJSPACE_TITLEMODEL' ); ?></label>
					</td>
					<td>
						<select name="mjs_model_page" id="mjs_model_page">
<?php
							for ($i = 0; $i < $model_page_list_count; $i++) {
								echo '<option value="'.$i.'">'.$this->model_page_list[$i]."</option>\n";
							}
?>							
						</select>
					</td>
				</tr>
<?php				
				}
?>					
	
			</table>

			<input name="option" type="hidden" value="com_myjspace" />			
			<input name="task" type="hidden" value="adm_create_page" />
		
		</fieldset>
		</form>
		
	</div>
</div>


