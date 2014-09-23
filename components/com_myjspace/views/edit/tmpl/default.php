<?php
/**
* @version $Id: default.php $
* @version		1.8.1 28/05/2012
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

if ($this->pagebreak == 1 && $this->editor_button == false) {
	$document->addScript(JURI::root() . 'components/com_myjspace/assets/util.js');
// Below do not use addScript() in variable due to use of html tags and want to be W3C compliant !
?>

<script type="text/javascript" >
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
<h2><?php echo JText::_('COM_MYJSPACE_TITLEEDIT'); ?></h2>
<div class="myjspace">
<?php
	if (!$this->msg) { 
	// JRoute::_('index.php?Itemid='.$this->Itemid);
?>
	<form method="post" action="<?php echo JRoute::_('index.php?option=com_myjspace&Itemid='); ?>">
		<div class="mjp-form-button">
			<input name="option" type="hidden" value="com_myjspace" />
			<input name="task" type="hidden" value="save" />
			<input type="submit" value="<?php echo JText::_('COM_MYJSPACE_SAVE'); ?>" />
			<input type="reset" value="<?php echo JText::_('COM_MYJSPACE_RESET'); ?>" />
		</div>		
<?php
	$editor =& JFactory::getEditor($this->editor_selection);
	echo $editor->display('mjs_content', $this->content, $this->edit_x, $this->edit_y, null, null, false);
	echo _my_aff_buttons('mjs_content', $this->editor_button, $this->editor_selection);
?>
	</form>
	<br />
<?php	if ($this->pagebreak == 1 && $this->editor_button == false) { ?> 
	<input type="submit" class="button mjp-config" onclick="insert_pagebreak('mjs_content');return false;"  value="<?php echo JText::_('COM_MYJSPACE_PAGEPREAK'); ?>" />
<?php	}
	} else echo $this->msg; ?>
	
</div>
