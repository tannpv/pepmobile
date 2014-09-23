<?php
/**
* @version $Id: default.php $
* @version		1.7.7 01/03/2011
* @package		com_myjspace
* @author       Bernard Saulmé
* @copyright	Copyright (C) 2010-2011 Bernard Saulmé
* @license      GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

// Pas d'accès direct
defined('_JEXEC') or die('Restricted access');
$document = &JFactory::getDocument();
$document->addStyleSheet(JURI::root() . 'components/com_myjspace/assets/myjspace.css');
if ($this->add_lightbox == 1) {
	$document->addStyleSheet(JURI::root() . 'components/com_myjspace/assets/lytebox/lytebox.css');
	$document->addScript(JURI::root() . 'components/com_myjspace/assets/lytebox/lytebox.js');
}
?>
<div class="myjspace-see" <?php if ($this->css_background) echo 'style="'.$this->css_background.'"'; ?>>
<?php 
	if ($this->allow_plugin > 1)
		echo $this->contenu->event->afterDisplayTitle . $this->contenu->event->beforeDisplayContent;
	echo $this->contenu->toc . $this->contenu->text;
	if ($this->allow_plugin > 1)
		echo $this->contenu->event->afterDisplayContent;
?>
</div>
<?php
// Integration Jcomment
	$comments = JPATH_ROOT.DS.'components'.DS.'com_jcomments'.DS.'jcomments.php';
	if ($this->jcomment == 1 && file_exists($comments)) {
		require_once($comments);
		echo JComments::showComments($this->pageid, 'com_myjspace', $this->pagename);
	}
?>
