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
JHTML::_('script', 'system/multiselect.js', false, true);
// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_membership_directory/assets/css/membership_directory.css');
?>

<form action="" name="passchangeForm" method="post" enctype="multipart/form-data">
    <fieldset id="passchangeForm">
        <legend>Password Change</legend>
        <fieldset id="upload-noflash" class="actions">
            <label for="pass-change"><?php echo JText::_('New Password:'); ?> &nbsp;</label>
            <input type="text" id="pass-change" name="jform[pass]" value ="<?php echo $this->item->value;?>"/>

            <input type="submit" id="pass-submit" value="<?php echo JText::_('Submit Change'); ?>" />
<?php echo JHtml::_('form.token'); ?>
            <input type="hidden" name="option" value="com_membership_directory" />
            <input type="hidden" name="task" value="pass_change.apply.submit" />
        </fieldset>

    </fieldset>
</form>
