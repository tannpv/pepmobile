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

//Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_membership_directory', JPATH_ADMINISTRATOR);

?>
<?php if ($this->item) : ?>

    <div class="item_fields">

        <ul class="fields_list">

            			<li><?php echo JText::_('COM_MEMBERSHIP_DIRECTORY_FORM_LBL_DIRECTORY_ID'); ?>:
			<?php echo $this->item->id; ?></li>
			<li><?php echo JText::_('COM_MEMBERSHIP_DIRECTORY_FORM_LBL_DIRECTORY_SIZE_OF_COMPANY'); ?>:
			<?php echo $this->item->size_of_company; ?></li>
			<li><?php echo JText::_('COM_MEMBERSHIP_DIRECTORY_FORM_LBL_DIRECTORY_YEAR_JOINED'); ?>:
			<?php echo $this->item->year_joined; ?></li>
			<li><?php echo JText::_('COM_MEMBERSHIP_DIRECTORY_FORM_LBL_DIRECTORY_DUES_2014'); ?>:
			<?php echo $this->item->dues_2012; ?></li>
			<li><?php echo JText::_('COM_MEMBERSHIP_DIRECTORY_FORM_LBL_DIRECTORY_DUES_2013'); ?>:
			<?php echo $this->item->dues_2013; ?></li>
			<li><?php echo JText::_('COM_MEMBERSHIP_DIRECTORY_FORM_LBL_DIRECTORY_DESINGATED_REP'); ?>:
			<?php echo $this->item->desingated_rep; ?></li>
			<li><?php echo JText::_('COM_MEMBERSHIP_DIRECTORY_FORM_LBL_DIRECTORY_NEW_2013'); ?>:
			<?php echo $this->item->new_2013; ?></li>
			<li><?php echo JText::_('COM_MEMBERSHIP_DIRECTORY_FORM_LBL_DIRECTORY_NEW_2014'); ?>:
			<?php echo $this->item->new_2012; ?></li>
			<li><?php echo JText::_('COM_MEMBERSHIP_DIRECTORY_FORM_LBL_DIRECTORY_TERM_EXPIRES'); ?>:
			<?php echo $this->item->term_expires; ?></li>
			<li><?php echo JText::_('COM_MEMBERSHIP_DIRECTORY_FORM_LBL_DIRECTORY_BOARD_POSITION'); ?>:
			<?php echo $this->item->board_position; ?></li>
			<li><?php echo JText::_('COM_MEMBERSHIP_DIRECTORY_FORM_LBL_DIRECTORY_BUSINESS_CATEGORY'); ?>:
			<?php echo $this->item->business_category; ?></li>
			<li><?php echo JText::_('COM_MEMBERSHIP_DIRECTORY_FORM_LBL_DIRECTORY_PAID_2013'); ?>:
			<?php echo $this->item->paid_2013; ?></li>
			<li><?php echo JText::_('COM_MEMBERSHIP_DIRECTORY_FORM_LBL_DIRECTORY_BUSINESS_DIRECTORY'); ?>:
			<?php echo $this->item->business_directory; ?></li>
			<li><?php echo JText::_('COM_MEMBERSHIP_DIRECTORY_FORM_LBL_DIRECTORY_COMPANY'); ?>:
			<?php echo $this->item->company; ?></li>
			<li><?php echo JText::_('COM_MEMBERSHIP_DIRECTORY_FORM_LBL_DIRECTORY_ADDRESS'); ?>:
			<?php echo $this->item->address; ?></li>
			<li><?php echo JText::_('COM_MEMBERSHIP_DIRECTORY_FORM_LBL_DIRECTORY_CITY_STATE_ZIP'); ?>:
			<?php echo $this->item->city_state_zip; ?></li>
			<li><?php echo JText::_('COM_MEMBERSHIP_DIRECTORY_FORM_LBL_DIRECTORY_FIRST_NAME'); ?>:
			<?php echo $this->item->first_name; ?></li>
			<li><?php echo JText::_('COM_MEMBERSHIP_DIRECTORY_FORM_LBL_DIRECTORY_LAST_NAME'); ?>:
			<?php echo $this->item->last_name; ?></li>
			<li><?php echo JText::_('COM_MEMBERSHIP_DIRECTORY_FORM_LBL_DIRECTORY_JOB_TITLE'); ?>:
			<?php echo $this->item->job_title; ?></li>
			<li><?php echo JText::_('COM_MEMBERSHIP_DIRECTORY_FORM_LBL_DIRECTORY_EMAIL'); ?>:
			<?php echo $this->item->email; ?></li>
			<li><?php echo JText::_('COM_MEMBERSHIP_DIRECTORY_FORM_LBL_DIRECTORY_WEBSITE'); ?>:
			<?php echo $this->item->website; ?></li>
			<li><?php echo JText::_('COM_MEMBERSHIP_DIRECTORY_FORM_LBL_DIRECTORY_PHONE'); ?>:
			<?php echo $this->item->phone; ?></li>
			<li><?php echo JText::_('COM_MEMBERSHIP_DIRECTORY_FORM_LBL_DIRECTORY_CELL'); ?>:
			<?php echo $this->item->cell; ?></li>
			<li><?php echo JText::_('COM_MEMBERSHIP_DIRECTORY_FORM_LBL_DIRECTORY_FAX'); ?>:
			<?php echo $this->item->fax; ?></li>
			<li><?php echo JText::_('COM_MEMBERSHIP_DIRECTORY_FORM_LBL_DIRECTORY_CONTACT'); ?>:
			<?php echo $this->item->contact; ?></li>
			<li><?php echo JText::_('COM_MEMBERSHIP_DIRECTORY_FORM_LBL_DIRECTORY_AP_EMAIL'); ?>:
			<?php echo $this->item->ap_email; ?></li>
			<li><?php echo JText::_('COM_MEMBERSHIP_DIRECTORY_FORM_LBL_DIRECTORY_DESCRIPTION'); ?>:
			<?php echo $this->item->description; ?></li>
			<li><?php echo JText::_('COM_MEMBERSHIP_DIRECTORY_FORM_LBL_DIRECTORY_REFERRED_BY'); ?>:
			<?php echo $this->item->referred_by; ?></li>
			<li><?php echo JText::_('COM_MEMBERSHIP_DIRECTORY_FORM_LBL_DIRECTORY_PASS'); ?>:
			<?php echo $this->item->pass; ?></li>


        </ul>

    </div>
    
<?php
else:
    echo JText::_('COM_MEMBERSHIP_DIRECTORY_ITEM_NOT_LOADED');
endif;
?>
