<?php
/**
* @version $Id: tags.php $ 
* @version		1.7.7 17/02/2012
* @package		com_myjspace
* @author       Bernard Saulmé
* @copyright	Copyright (C) 2012 Bernard Saulmé
* @license      GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

// Pas d'accès direct
defined('_JEXEC') or die('Restricted access');
$document = &JFactory::getDocument();
$document->addStyleSheet(JURI::root() . 'components/com_myjspace/assets/myjspace.css');

// Js code
$js = "window.addEvent('load', function() {
			new JCaption('img.caption');
		});

function insertTags(valeur_choix) {
	valeur_choix += ' ';
	window.parent.jInsertEditorText(valeur_choix, '".$this->e_name."');
	window.parent.SqueezeBox.close();
	return false;
}
	";

// Tags list
$tag_list = array('#userid', '#name', '#username', '#pagename', '#lastupdate', '#lastaccess', '#createdate', '#description', '#fileslist');
$tag_label = array(JText::_('COM_MYJSPACE_TAG_USERID'), 
					JText::_('COM_MYJSPACE_TAG_NAME'),
					JText::_('COM_MYJSPACE_TAG_USERNAME'),
					JText::_('COM_MYJSPACE_TAG_PAGENAME'),
					JText::_('COM_MYJSPACE_TAG_LASTUPDATE'),
					JText::_('COM_MYJSPACE_TAG_LASTACCESS'),
					JText::_('COM_MYJSPACE_TAG_CREATEDATE'),
					JText::_('COM_MYJSPACE_TAG_DESCRIPTION'),
					JText::_('COM_MYJSPACE_TAG_FILESLIST'));
		
if (file_exists(JPATH_ROOT.DS.'components'.DS.'com_comprofiler')) { // Add CB
	$tag_list = array_merge($tag_list, array('#cbprofile'));
	$tag_label = array_merge($tag_label, array(JText::_('COM_MYJSPACE_TAG_CBPROFILE')));
}
if (file_exists(JPATH_ROOT.DS.'components'.DS.'com_community')) { // Add Jomsocial
	$tag_list = array_merge($tag_list, array('#jomsocial-profile','#jomsocial-photos'));
	$tag_label = array_merge($tag_label, array(JText::_('COM_MYJSPACE_TAG_JOOMSOCIALPROFILE'), JText::_('COM_MYJSPACE_TAG_JOOMSOCIALPHOTOS')));
}

$document = &JFactory::getDocument();
$document->addScript(JURI::root() . 'media/system/js/mootools-core.js');
$document->addScript(JURI::root() . 'media/system/js/core.js');
$document->addScript(JURI::root() . 'media/system/js/caption.js');
$document->addScriptDeclaration($js);

?>
<div class="myjspace">
	<fieldset class="addtags">
<?php
	for($i=0;$i<sizeof($tag_list);$i++) {
		echo '<div><a href="#" onclick="insertTags(\''.$tag_list[$i].'\');">'.$tag_label[$i]."</a></div>\n"; 
    } 
?>
	</fieldset>

</div>
