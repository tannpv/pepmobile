<?php
/**
* @version $Id: view.html.php $
* @version		1.8.0 24/04/2012
* @package		com_myjspace
* @author       Bernard Saulmé
* @copyright	Copyright (C) 2010-2011-2012 Bernard Saulmé
* @license      GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

// Pas d'accès direct
defined('_JEXEC') or die('Restricted access');
$document = &JFactory::getDocument();
$document->addStyleSheet(JURI::root().'components/com_myjspace/assets/myjspace.css');

if ($this->publish_mode == 2)
	JHTML::_('behavior.calendar');  
?>
<script type="text/javascript">
function submitbutton(form_tmp, pressbutton, valeur)
{
	form_tmp.resethits.value = 'yes';
	return true;
}
</script>
<h2><?php echo JText::_('COM_MYJSPACE_TITLECONFIG'); ?></h2>
<div class="myjspace">
	<br />
<?php if ($this->blockedit != 1 && $this->alert_root_page == 0) {

		if ($this->pagename != '') {
			$page_tmp = $this->pagename;
			$msg_tmp = '';
		} else { 
			$page_tmp = $this->username;
			$msg_tmp = JText::_('COM_MYJSPACE_NEWPAGEINFO');
		}
?> 
		<form action="<?php echo JRoute::_('index.php'); ?>" method="post">
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'COM_MYJSPACE_LABELUSERDETAILS' ); ?></legend>
			<table class="admintable">
				<tr>
					<td class="key">
						<label><?php echo  JText::_('COM_MYJSPACE_PAGELINK'); ?></label>
					</td>
					<td>
						<a href="<?php echo $this->link.'?Itemid='.$this->Itemid; ?>"><?php echo $this->link; ?></a>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label><?php echo  JText::_('COM_MYJSPACE_PAGEBBCODE'); ?></label>
					</td>
					<td>
						[url]<?php echo $this->link ?>[/url]
					</td>
				</tr>
				<tr>
					<td class="key">
						<label><?php echo JText::_('COM_MYJSPACE_TITLENAME'); ?></label>
					</td>
					<td>
					<?php if ($this->pagename_username == 1) { ?>
						<?php echo $page_tmp; ?>
						<input type="hidden" name="mjs_pagename" id="mjs_pagename"  value="<?php echo $page_tmp; ?>" /> <?php echo $msg_tmp; ?>
					<?php } else { ?>
						<input type="text" name="mjs_pagename" id="mjs_pagename" class="inputbox" size="40" value="<?php echo $page_tmp; ?>" /> <?php echo $msg_tmp; ?>
					<?php } ?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label><?php echo JText::_('COM_MYJSPACE_LABELUSERNAME'); ?></label>
					</td>
					<td>
						<?php echo $this->username; ?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label><?php echo JText::_('COM_MYJSPACE_LABELMETAKEY'); ?></label>
					</td>
					<td>
						<input type="text" name="mjs_metakey" id="mjs_metakey" class="inputbox" size="40" value="<?php echo $this->metakey; ?>" />
					</td>
				</tr>
<?php
				$model_page_list_count = count($this->model_page_list);
				if ($this->pagename == '' && $model_page_list_count >= 2) { // If several (2 pages + text_to_choixe) model page list
?>
				<tr>
					<td class="key">
						<?php echo JText::_( 'COM_MYJSPACE_TITLEMODEL' ); ?>
					</td>
					<td>
						<select name="mjs_model_page" id="mjs_model_page">
<?php
							for ($i = 0; $i < $model_page_list_count; $i++) {
								if ($this->model_page_list[$i])
									echo '<option value="'.$i.'">'.$this->model_page_list[$i]."</option>\n";
							}
?>							
						</select>
					</td>
				</tr>
<?php				
				}
?>			
				<tr>
					<td class="key">
						<label><?php echo JText::_('COM_MYJSPACE_LABELCREATIONDATE'); ?></label>
					</td>
					<td>
						<?php echo $this->create_date; ?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label><?php echo JText::_('COM_MYJSPACE_LABELLASTUPDATEDATE'); ?></label>
					</td>
					<td>
						<?php echo $this->last_update_date; ?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label><?php echo JText::_('COM_MYJSPACE_LABELLASTACCESSDATE'); ?></label>
					</td>
					<td>
						<?php echo $this->last_access_date; ?>
					</td>
				</tr>
<?php				
	if ($this->page_increment == 1) {
?>
				<tr>
					<td class="key">
						<label><?php echo JText::_('COM_MYJSPACE_LABELHITS'); ?></label>
					</td>
					<td>
						<?php echo $this->hits;
							if ($this->hits > 0) { ?>
						&nbsp;<input name="reset_hits" type="submit" class="button" value="<?php echo JText::_('COM_MYJSPACE_LABELHITSRESET'); ?>" onclick="submitbutton(this.form, 'resethits', 'yes');" />
						<input name="resethits" type="hidden" value="no" />
						<?php } ?>
					</td>
				</tr>
<?php
	}
	if ($this->publish_mode == 2) {
?>
				<tr>
					<td class="key">
						<label><?php echo JText::_('COM_MYJSPACE_LABELPUBLISHUP'); ?></label>
					</td>
					<td>
						<?php echo JHTML::_('calendar', $this->publish_up, "publish_up", "publish_up", $this->date_fmt_pub, array('size'=>'10')) .' '. $this->img_publish_up; ?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label><?php echo JText::_('COM_MYJSPACE_LABELPUBLISHDOWN'); ?></label>
					</td>
					<td>
						<?php echo JHTML::_('calendar', $this->publish_down, "publish_down", "publish_down", $this->date_fmt_pub, array('size'=>'10')) .' '. $this->img_publish_down; ?>
					</td>
				</tr>						
<?php
	}
	if ($this->tab_template != null) {
?>
				<tr>
					<td class="key">
						<?php echo JText::_( 'COM_MYJSPACE_TEMPLATE' ); ?>
					</td>
					<td>
						<select name="mjs_template" id="mjs_template">
						<option value="">-</option>
						<?php
						foreach ($this->tab_template as $i => $value) {
							if ($value == $this->template)
								echo '<option value="'.$value.'" selected="selected">'.$value."</option>\n";
							else
								echo '<option value="'.$value.'">'.$value."</option>\n";
						}
						?>
						</select>
					</td>
				</tr>
<?php
	}
	if ($this->user_mode_view == 1) {
?>
				<tr>
					<td class="key">
						<?php echo JText::_( 'COM_MYJSPACE_TITLEMODEVIEW' ); ?>
					</td>
					<td>
						<select name="mjs_mode_view" id="mjs_mode_view">
							<option value="0" <?php if ($this->blockview == 0) echo " selected='selected'"; ?> ><?php echo JText::_('COM_MYJSPACE_TITLEMODEVIEW0') ?></option>
							<option value="2" <?php if ($this->blockview == 2) echo " selected='selected'"; ?> ><?php echo JText::_('COM_MYJSPACE_TITLEMODEVIEW2') ?></option>
							<option value="1" <?php if ($this->blockview == 1) echo " selected='selected'"; ?> ><?php echo JText::_('COM_MYJSPACE_TITLEMODEVIEW1') ?></option>
						</select>
					</td>
				</tr>
<?php
	}
	if ($this->uploadimg > 0) {
?>
				<tr>
					<td class="key">
						<label><?php echo JText::_('COM_MYJSPACE_LABELUSAGE0'); ?></label>
					</td>
					<td>
						<?php echo JText::sprintf('COM_MYJSPACE_LABELUSAGE1',$this->page_size,$this->dir_max_size,$this->page_number); ?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label><?php echo JText::_('COM_MYJSPACE_LABELUSAGE2'); ?></label>
					</td>
					<td>
						<?php echo $this->file_img_size; ?>
					</td>
				</tr>
<?php
	}	
?>
			</table>
			<input name="Itemid" type="hidden" value="<?php echo $this->Itemid; ?>" />
			<input name="option" type="hidden" value="com_myjspace" />
			<input name="task" type="hidden" value="save_config" />
			<input type="submit" class="button mjp-config" value="<?php echo JText::_('COM_MYJSPACE_SAVE'); ?>" />
		</fieldset>
		</form>
<?php
	if ($this->pagename != '') {
?>
	<fieldset class="adminform">
		<legend><?php echo JText::_('COM_MYJSPACE_TITLEACTION') ?></legend>
		<table style="width: 100%;" class="noborder" ><tr>
		<td style="width: 10%;"></td>
		<td style="width: 30%;">
<?php
		if ( version_compare(JVERSION,'1.6.0','lt') || (version_compare(JVERSION,'1.6.0','ge') && JFactory::getUser()->authorise('user.edit', 'com_myjspace')) ) {
?>
		<form method="post" action="?option=com_myjspace&amp;view=edit&amp;Itemid=<?php echo $this->Itemid; ?>">
			<input type="submit" class="button mjp-config" value="<?php echo JText::_('COM_MYJSPACE_TITLEEDIT1'); ?>" />
		</form>
<?php	} ?>
		</td>
		<td>
<?php
		if ( version_compare(JVERSION,'1.6.0','lt') || (version_compare(JVERSION,'1.6.0','ge') && JFactory::getUser()->authorise('user.see', 'com_myjspace')) ) {
?>
		<form method="post" action="?option=com_myjspace&amp;view=see&amp;Itemid=<?php echo $this->Itemid; ?>">
			<input type="submit" class="button mjp-config" value="<?php echo JText::_('COM_MYJSPACE_TITLESEE1'); ?>" />
		</form>
<?php	} ?>
		</td>
		<td style="width: 30%;">
<?php
		if ( version_compare(JVERSION,'1.6.0','lt') || (version_compare(JVERSION,'1.6.0','ge') && JFactory::getUser()->authorise('user.delete', 'com_myjspace')) ) {
?>
		<form method="post" action="?option=com_myjspace&amp;view=delete&amp;Itemid=<?php echo $this->Itemid; ?>">
			<input type="submit" class="button mjp-config" value="<?php echo JText::_('COM_MYJSPACE_DELETE'); ?>" />
		</form>
<?php	} ?>
		</td>
		</tr></table>
	</fieldset>
<?php
		}
		if ($this->uploadadmin && ($this->uploadimg > 0 || $this->uploadmedia > 0)) {
?>
	<fieldset class="adminform ">
		<legend><?php echo JText::_('COM_MYJSPACE_UPLOADTITLE') ?></legend>
		<table style="width: 100%;" class="noborder"><tr>
			<td style="width: 10%;"></td>
			<td>
			<form method="post" action="<?php echo JRoute::_('index.php'); ?>" enctype="multipart/form-data" >
				<input name="Itemid" type="hidden" value="<?php echo $this->Itemid; ?>" />
				<input name="option" type="hidden" value="com_myjspace" />
				<input name="task" type="hidden" value="upload_file" />
				<input type="file" name="upload_file" />
				<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $this->file_max_size; ?>" />
				<br />
				<input type="submit" class="button mjp-config" value="<?php echo JText::_('COM_MYJSPACE_UPLOADUPLOAD') ?>" onclick="document.getElementById('progress_div').style.visibility='visible';" />
				<div id="progress_div" style="visibility: hidden;"><img src="<?php JURI::root(); ?>components/com_myjspace/assets/progress.gif" alt="wait..." style="padding-top: 5px;" /></div>
			</form>
			</td>
		<?php
		if (1) { // No list = not list for deleting ... :-) Can be a separate option in the futur 	?>
			<td>
			<form  method="post" action="<?php echo JRoute::_('index.php'); ?>" >
				<input name="Itemid" type="hidden" value="<?php echo $this->Itemid; ?>" />
				<input name="option" type="hidden" value="com_myjspace" />
				<input name="task" type="hidden" value="delete_file" />
				<select name="delete_file" id="delete_file">
					<option value="" selected="selected"><?php echo JText::_('COM_MYJSPACE_UPLOADCHOOSE') ?></option>
					<?php
						$nb = count($this->tab_list_file);
						for ($i = 0 ; $i < $nb ; ++$i ) 
							echo '<option value="'.$this->tab_list_file[$i].'">'.$this->tab_list_file[$i]."</option>\n";
					?>
				</select>
				<br />
				<input type="submit" value="<?php echo JText::_('COM_MYJSPACE_UPLOADDELETE') ?>" class="button mjp-config" />
				<div>&nbsp;</div>			
			</form>
			</td>
		<?php } ?>
			<td style="width: 10%;"></td>
		</tr></table>
	</fieldset>
<?php
		}
   } else if ($this->alert_root_page == 1)
 		echo JText::_('COM_MYJSPACE_ALERTYOURADMIN');  
   else
		echo JText::_('COM_MYJSPACE_EDITBLOCKED');
 ?>
	<div class="bsfooter">
		<a href="<?php echo Jroute::_('index.php?option=com_myjspace&amp;view=myjspace&amp;Itemid='.$this->Itemid); ?>">BS MyJspace</a>
	</div>
 
</div>
