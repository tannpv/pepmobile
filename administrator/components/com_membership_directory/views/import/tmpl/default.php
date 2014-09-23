<?php
/**
 * @version     1.0.0
 * @package     com_membership_directory
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomla Component <Joomla@Joomla.com> - http://www.joomla.org
 */


// no direct access
defined('_JEXEC') or die;
$user = JFactory::getUser();
JHtml::_('behavior.tooltip');
JHTML::_('script','system/multiselect.js',false,true);
// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_membership_directory/assets/css/membership_directory.css');
?>
<form action="" name="uploadForm" method="post" enctype="multipart/form-data">
<fieldset id="uploadform">
					<legend>Upload</legend>
					<fieldset id="upload-noflash" class="actions">
						<label for="upload-file" class="hidelabeltxt"><?php echo JText::_('Upload File'); ?></label>
						<input type="file" id="upload-file" name="Filedata[]" multiple />
						<label for="upload-submit" class="hidelabeltxt"><?php echo JText::_('Upload'); ?></label>
						<input type="submit" id="upload-submit" value="<?php echo JText::_('Upload File'); ?>"/>
						<?php echo JHtml::_('form.token'); ?>
						<input type="hidden" name="option" value="com_membership_directory" />
						<input type="hidden" name="task" value="import.upload.submit" />
					</fieldset>
					
</fieldset>
</form>