<?php
/**
* @version $Id: default.php $
* @version		1.8.0 04/04/2012
* @package		com_myjspace
* @author       Bernard Saulmé
* @copyright	Copyright (C) 2010-2011-2012 Bernard Saulmé
* @license      GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

// Pas d'accès direct
defined('_JEXEC') or die('Restricted access');

require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'edit_plus.php';
$document = &JFactory::getDocument();

$document->addStyleSheet(JURI::root() . 'components/com_myjspace/assets/myjspace.css');

if ($this->editor_button == true)
	$document->addScriptDeclaration(_my_button_js());
	
if ($this->publish_mode == 2)
	JHTML::_('behavior.calendar'); 
	
if ($this->pagebreak == 1 && $this->editor_button == false) {
	$document->addScript(JURI::root() . 'components/com_myjspace/assets/util.js');
// Below do not use addScript() in variable due to use of html tags and want to be W3C compliant !	
?>
<script type="text/javascript">
//<![CDATA[
function insert_pagebreak(inputid) {
	var ajout = prompt("<?php echo JText::_('COM_MYJSPACE_PAGEPREAK_TITLE'); ?>");
	ajout = '<hr class="system-pagebreak" title="'+ajout+'" alt="'+ajout+'" />';
	jInsertEditorText(ajout, inputid);
}
//]]>
</script>
<?php
	}
?>
<script type="text/javascript">
//<![CDATA[
function Resetsubmitbutton(form_tmp, pressbutton, valeur)
{
	form_tmp.resethits.value = 'yes';
	return true;
}
//]]>
</script>
<div class="myjspace-admin">
	<form action="<?php echo JRoute::_('index.php'); ?>" method="post" name="adminForm">
	<div class="col width-45 fltlft">

		<fieldset class="adminform">
		<legend><?php echo JText::_( 'COM_MYJSPACE_LABELUSERDETAILS' ); ?></legend>
			<table class="admintable" cellspacing="1">
				<tr>
					<td class="key">
						<label><?php echo  JText::_('COM_MYJSPACE_PAGELINK'); ?></label>
					</td>
					<td>
						<a href="<?php echo $this->link ?>"><?php echo $this->link ?></a>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label><?php echo JText::_('COM_MYJSPACE_TITLENAME'); ?></label>
					</td>
					<td>
						<input type="text" name="mjs_pagename" id="mjs_pagename" class="inputbox" size="40" value="<?php echo $this->pagename; ?>" />
					</td>
				</tr>
				<tr>
					<td class="key">
						<label><?php echo JText::_('ID'); ?></label>
					</td>
					<td>
						<?php echo $this->userid; ?>
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
				<tr>
					<td class="key">
						<label><?php echo JText::_('COM_MYJSPACE_LABELIPACCESS'); ?></label>
					</td>
					<td>
						<?php echo $this->last_access_ip; ?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label><?php echo JText::_('COM_MYJSPACE_LABELHITS'); ?></label>
					</td>
					<td>
						<?php echo $this->hits;
							if ($this->hits > 0) { ?>
						&nbsp;<input name="reset_hits" type="submit" class="button" value="<?php echo JText::_('COM_MYJSPACE_LABELHITSRESET'); ?>" onclick="Resetsubmitbutton(this.form, 'resethits', 'yes');" />
						<input name="resethits" type="hidden" value="no" />
						<?php } ?>
					</td>
				</tr>
<?php				
	if ($this->publish_mode != 0) {
?>
				<tr>
					<td class="key">
						<label><?php echo JText::_('COM_MYJSPACE_LABELPUBLISHUP'); ?></label>
					</td>
					<td>
						<?php echo JHTML::_('calendar', $this->publish_up, "publish_up", "publish_up", $this->date_fmt_pub, array('size'=>'10')) .' '. $this->img_publish_up;; ?>
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
?>
				<tr>
					<td class="key">
						<label>
							<?php echo JText::_( 'COM_MYJSPACE_TITLEMODEEDIT' ); ?>
						</label>
					</td>
					<td>
						<select name="mjs_mode_edit" id="mjs_mode_edit">
							<option value="0" <?php if ($this->blockedit == 0) echo " selected='selected'"; ?> ><?php echo JText::_('COM_MYJSPACE_TITLEMODEEDIT0') ?></option>
							<option value="1" <?php if ($this->blockedit == 1) echo " selected='selected'"; ?> ><?php echo JText::_('COM_MYJSPACE_TITLEMODEEDIT1') ?></option>
						</select>
					</td>
				</tr>
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
//	if ($this->uploadimg > 0) {
	if ($this->link_folder == 1) {
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
			
			<input type="hidden" name="id" value="<?php echo $this->userid; ?>" />
			<input name="option" type="hidden" value="com_myjspace" />
			<input name="task" type="hidden" value="adm_save_page" /><br />

		</fieldset>
	</div>
	
	<div class="col width-55 fltlft">
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'COM_MYJSPACE_PAGE' ); ?></legend>
<?php
	$editor =& JFactory::getEditor($this->editor_selection);
	echo $editor->display('mjs_content', $this->content, $this->edit_x, $this->edit_y, null, null, false);
	echo _my_aff_buttons('mjs_content', $this->editor_button, $this->editor_selection);
?>
	<br />
<?php if ($this->pagebreak == 1 && $this->editor_button == false) { ?> 
	<input type="submit" class="button mjp-config" onclick="insert_pagebreak('mjs_content');return false;"  value="<?php echo JText::_('COM_MYJSPACE_PAGEPREAK'); ?>" />
<?php }  ?>
		</fieldset>
	</div>

	</form>

<?php
	if ($this->uploadadmin && ($this->uploadimg > 0 || $this->uploadmedia > 0)) {
?>
	<div class="col width-45 fltlft">
	<fieldset class="adminform ">
		<legend><?php echo JText::_('COM_MYJSPACE_UPLOADTITLE') ?></legend>
		<table style="width: 100%;" class="noborder">
		<tr>
			<td>
			<form method="post" action="<?php echo JRoute::_('index.php'); ?>" enctype="multipart/form-data" >
				<input name="option" type="hidden" value="com_myjspace" />
				<input name="task" type="hidden" value="upload_file" />
				<input type="hidden" name="id" value="<?php echo $this->userid; ?>" />
				<input type="file" name="upload_file" />
				<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $this->file_max_size; ?>" />
				<input type="submit" class="button mjp-config" value="<?php echo JText::_('COM_MYJSPACE_UPLOADUPLOAD') ?>" onclick="document.getElementById('progress_div').style.visibility='visible';" />
				<div id="progress_div" style="visibility: hidden;"><img src="<?php JURI::root(); ?>components/com_myjspace/assets/progress.gif" alt="wait..." style="padding-top: 5px;" /></div>
			</form>
			</td>
		<?php
		if (1) { // No list = not list for deleting ... :-) Can be a separate option in the futur 	?>
			<td>
			<form  method="post" action="<?php echo JRoute::_('index.php'); ?>" >
				<input name="option" type="hidden" value="com_myjspace" />
				<input name="task" type="hidden" value="delete_file" />
				<input type="hidden" name="id" value="<?php echo $this->userid; ?>" />
				<select name="delete_file" id="delete_file">
					<option value="" selected="selected"><?php echo JText::_('COM_MYJSPACE_UPLOADCHOOSE') ?></option>
					<?php
						$nb = count($this->tab_list_file);
						for ($i = 0 ; $i < $nb ; ++$i ) 
							echo '<option value="'.$this->tab_list_file[$i].'">'.$this->tab_list_file[$i]."</option>\n";
					?>
				</select>
				<input type="submit" value="<?php echo JText::_('COM_MYJSPACE_UPLOADDELETE') ?>" class="button mjp-config" />
				<div>&nbsp;</div>			
			</form>
			</td>
		<?php } ?>
		</tr></table>
	</fieldset>
	</div>
<?php
		}
?>	

	<div class="clr"></div>
</div>
