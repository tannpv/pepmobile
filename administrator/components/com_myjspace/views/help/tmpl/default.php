<?php
/**
* @version $Id: default.php $
* @version		1.8.0 27/04/2012
* @package		com_myjspace
* @author       Bernard Saulmé
* @copyright	Copyright (C) 2010-2011-2012 Bernard Saulmé
* @license      GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

// Pas d'accès direct
defined('_JEXEC') or die('Restricted access');

require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'util.php';

$document = &JFactory::getDocument();
$document->addScriptDeclaration($this->report_js);
?>
<div class="myjspace  width-70">
<fieldset class="adminform">
<legend><?php echo JText::_('COM_MYJSPACE_ADMIN_SOME_HELP'); ?></legend>
<br />
<div><strong><?php echo JText::_('COM_MYJSPACE_ADMIN_INFO_0'); ?></strong></div>
<ul>
<?php
	$span_fin_ko = 'style="color:red">';
	
	$span_fin = '>';
	if (ini_get('file_uploads') != 1)
		$span_fin = $span_fin_ko;
	echo '<li>PHP file_uploads = <span '.$span_fin.ini_get('file_uploads')."</span></li>\n";
	
	echo '<li>PHP upload_tmp_dir = '.ini_get('upload_tmp_dir')."</li>\n";
	
	$span_fin = '>';
	if (convertBytes(ini_get('upload_max_filesize')) < $this->file_max_size)
		$span_fin = $span_fin_ko;
	echo '<li>PHP upload_max_filesize = <span '.$span_fin.convertBytes(ini_get('upload_max_filesize')).'</span> ('.JText::_('COM_MYJSPACE_ADMIN_SUPERIOR').'mod_myjspace = '.$this->file_max_size.")</li>\n";
	
	$span_fin = '>';
	if (convertBytes(ini_get('post_max_size')) < $this->file_max_size)
		$span_fin = $span_fin_ko;
	echo '<li>PHP post_max_size = <span '.$span_fin.convertBytes(ini_get('post_max_size')).'</span> ('.JText::_('COM_MYJSPACE_ADMIN_SUPERIOR').'mod_myjspace = '.$this->file_max_size.")</li>\n";

	$span_fin = '>';
	if ($this->iswritable == 0)
		$span_fin = $span_fin_ko;
	echo '<li>'.JText::_('COM_MYJSPACE_ADMIN_ISWRITABLE').'<span '.$span_fin.$this->iswritable."</span></li>\n";
			
	/*
   	file_uploads= On/Off permet d'autoriser ou non l'envoi de fichiers.
	upload_tmp_dir = répertoire permet de définir le répertoire temporaire permettant d'accueillir le fichier uploadé.
	upload_max_filesize = 2M permet de définir la taille maximale autorisée pour le fichier. 
		Si cette limite est dépassée, le serveur enverra un code d'erreur.
	post_max_size indique la taille maximale des données envoyées par un formulaire. 
		Cette directive prime sur upload_max_filesize, il faut donc s'assurer d'avoir post_max_size supérieure à upload_max_filesize 
*/
?>
</ul>
<div><strong><?php echo JText::_('COM_MYJSPACE_ADMIN_INFO_OTHER'); ?></strong></div>
<ul>
<?php
	// Editor
	echo '<li>';
	$check_editor = check_editor_selection($this->editor_selection);
	$span_fin = '> ';
	if ($check_editor == false)
		$span_fin = $span_fin_ko;
	echo JText::_('COM_MYJSPACE_ADMIN_EDITOR'). ' <span '.$span_fin.$this->editor_selection.'</span>';		
	if ($check_editor == false) // Use the Joomla default editor
		echo JText::_('COM_MYJSPACE_ADMIN_EDITOR_SELECTION');
	echo '</li>';
	
	// Index
	if ($this->nb_index_ko >= 0) {
		echo '<li>';
		if ($this->nb_index_ko == 0)
			echo JText::_('COM_MYJSPACE_ADMIN_INDEX_FORMAT_OK');
		else
			echo JText::sprintf('COM_MYJSPACE_ADMIN_INDEX_FORMAT_KO', '<span '.$span_fin_ko.$this->nb_index_ko.'</span>');
		echo '</li>';
	}
?>
</ul>
</fieldset>

<fieldset class="adminform">
<legend><?php echo JText::_('COM_MYJSPACE_ADMIN_REPORT'); ?></legend>
	<div><a href="#" id="link_sel_all" ><?php echo JText::_('COM_MYJSPACE_ADMIN_REPORT_SELECT'); ?></a></div>
	<textarea id="report" name="report" cols="" rows="" style="width:100%; height:120px;"><?php echo htmlspecialchars($this->report, ENT_COMPAT, 'UTF-8'); ?></textarea>
</fieldset>

<br />
</div>
