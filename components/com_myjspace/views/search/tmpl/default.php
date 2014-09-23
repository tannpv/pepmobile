<?php
/**
* @version $Id: default.php $ 
* @version		1.8.1 25/05/2012
* @package		com_myjspace
* @author       Bernard Saulmé
* @copyright	Copyright (C) 2010-2011-2012 Bernard Saulmé
* @license      GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

// Pas d'accès direct
defined('_JEXEC') or die('Restricted access');
$document = &JFactory::getDocument();
$document->addStyleSheet(JURI::root().'components/com_myjspace/assets/myjspace.css');
if ($this->add_lightbox == 1) {
	$document->addStyleSheet(JURI::root() . 'components/com_myjspace/assets/lytebox/lytebox.css');
	$document->addScript(JURI::root() . 'components/com_myjspace/assets/lytebox/lytebox.js');
}
require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'util.php';
?>
<?php
	if ($this->aff_titre)
		echo '<h2>'.JText::_('COM_MYJSPACE_TITLESEARCH').'</h2>';
?>
<div class="myjspace">
<br />
<?php
 if ($this->aff_select) {
 	// Search selector to print
?>
		<fieldset class="adminform">
		<legend><?php echo JText::_('COM_MYJSPACE_TITLESEARCH') ?></legend>
		    <form action="<?php echo JRoute::_('index.php?option=com_myjspace&view=search&Itemid='.$this->Itemid); ?>" method="post">
<?php
		echo '&nbsp;'.JText::_('COM_MYJSPACE_SEARCHSORT').' <select name="sort" >';
		$sort_list = array(JText::_('COM_MYJSPACE_SEARCHSORT0'),JText::_('COM_MYJSPACE_SEARCHSORT1'),JText::_('COM_MYJSPACE_SEARCHSORT2'),JText::_('COM_MYJSPACE_SEARCHSORT3'),JText::_('COM_MYJSPACE_SEARCHSORT4'),JText::_('COM_MYJSPACE_SEARCHSORT5'));
		$nb = count($sort_list);
		for ($i = 0; $i < $nb ; ++$i ) {
			if ($i == $this->aff_sort )
				echo '<option selected="selected" value="'.$i.'">&nbsp;'.$sort_list[$i].'&nbsp;</option>';
			else
				echo '<option value="'.$i.'">&nbsp;'.$sort_list[$i].'&nbsp;</option>';
		}
		echo '</select>';
?>
				<input type="checkbox" name="check_search[]" <?php if ( isset($this->check_search_asso['name'])) echo 'checked="checked"'; ?> value="name" /><?php echo JText::_('COM_MYJSPACE_SEARCHSEARCHPNAME') ?>
				<input type="checkbox" name="check_search[]" <?php if ( isset($this->check_search_asso['content'])) echo 'checked="checked"'; ?> value="content" /><?php echo JText::_('COM_MYJSPACE_SEARCHSEARCHCONTENT') ?>
				<input type="checkbox" name="check_search[]" <?php if ( isset($this->check_search_asso['description'])) echo 'checked="checked"'; ?> value="description" /><?php echo JText::_('COM_MYJSPACE_SEARCHSEARCHDESCRIPTION') ?>
				<input type="text" name="svalue" id="svalue" class="inputbox" size="10" value="<?php echo $this->svalue; ?>" />
				<?php echo JText::_('COM_MYJSPACE_SEARCHLINE') ?><input type="text" name="numb" id="numb" class="inputbox" size="3" value="<?php echo $this->aff_number; ?>" />
				<input type="submit" id="bouton" name="bouton" value="<?php echo JText::_('COM_MYJSPACE_SEARCH'); ?>" class="button" />
			</form>
		</fieldset>
		<br />
<?php } ?>

	<div class="myjspace_result_search">
	<fieldset class="adminform">
<?php
	$nb = count($this->result);

	if ($this->separ == 1) {
		$separ_l = '';
		$separ_l_img = '';
		$separ_r = ' ';
		$separ_end = '&nbsp;-&nbsp;';
	} else if ($this->separ == 2) {
		$separ_l = '';
		$separ_l_img = '';
		$separ_r = ' ';
		$separ_end = '<br />';
	} else { // == 0 (tab)
		$separ_l = '<td>';
		$separ_l_img = '<td class="mjsp_search_img">';
		$separ_r = '</td>';
		$separ_end = '';
	}

	$nb_metakey = 0;
	if ($this->search_aff_add & 4) {
		for ($i = 0; $i < $nb ; ++$i ) {
			if ($this->result[$i]['metakey'] != '' )
				$nb_metakey++;
		}
	}
	
	if ($this->separ == 0)
		echo '<table class="mjsp_search_tab">'."\n";
		
	for ($i = 0; $i < $nb ; ++$i ) {
		if ($this->separ == 0)
			echo '<tr>';
			
		if ($this->search_aff_add & 64) { // Image (64)
			echo $separ_l_img.exist_image_html($this->foldername.'/'.$this->result[$i]['pagename'], JPATH_SITE, $this->add_lightbox, $this->result[$i]['pagename']).$separ_r;
		}			

		if ($this->search_aff_add & 1) { // Pagename (1)
			if ($this->link_folder == 1)
				$url = Jroute::_($this->foldername.'/'.$this->result[$i]['pagename'].'/?Itemid='.$this->Itemid);
			else
				$url = Jroute::_('index.php?option=com_myjspace&view=see&pagename='.$this->result[$i]['pagename'].'&Itemid='.$this->Itemid);
			echo $separ_l.'<a href="'.$url.'">'.$this->result[$i]['pagename'].'</a>'.$separ_r;
		}
			
		if ($this->search_aff_add & 2) { // Username (2)
			$table   = JUser::getTable();
			if($table->load($this->result[$i]['id'])) { // Test if user exists before retreiving info
				$user =& JFactory::getUser($this->result[$i]['id']);
			} else { // User does no exist any more !
				$user = new stdClass();
				$user->username = '';
			}
			echo $separ_l.$user->username.$separ_r;
		}

		if ($this->search_aff_add & 8) { // Date created (8)
			echo $separ_l.date($this->date_fmt, strtotime($this->result[$i]['create_date'])).$separ_r;
		}
		
		if ($this->search_aff_add & 16) { // Date updated (16)
			echo $separ_l.date($this->date_fmt, strtotime($this->result[$i]['last_update_date'])).$separ_r;
		}
		
		if ($this->search_aff_add & 32) { // Hits (32)
			echo $separ_l.$this->result[$i]['hits'].$separ_r;
		}
		
		if ($this->search_aff_add & 4 && $nb_metakey > 0) { // Description (4)
			echo $separ_l.$this->result[$i]['metakey'].$separ_r;
		}
			
		if ($this->separ == 0)
			echo "</tr>\n";
		else if ($i < ($nb-1))
			echo "<br />\n";
	}
	if ($this->separ == 0)
		echo '</table>';
?>
	</fieldset>
	</div>
</div>
