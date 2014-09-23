<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.6
 */
defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>

<script type='text/javascript' src="/dev/templates/mobilebaykeeper1/js/jquery.collapse.js"></script>
<script type='text/javascript' src="/dev/templates/mobilebaykeeper1/js/jquery.collapse_cookie_storage.js"></script>
<script type='text/javascript' src="/dev/templates/mobilebaykeeper1/js/jquery.collapse_storage.js"></script>

<script type='text/javascript' src="/dev/templates/mobilebaykeeper1/js/json2.js"></script>

<div class="registration<?php echo $this->pageclass_sfx ?>">
    <h1>Baykeeper 101</h1>
    <p> Baykeeper 101 is an Open House Introduction where board, staff and volunteers walk you through the work we do and how you can be involved. 
        Whether you are a lifelong member or just looking to volunteer, this hour-long round table will be sure to spark your interest. 
        Please RSVP to <a href="mailto:emarley@mobilebaykeeper.org?subject=re%3A%20%20Baykeeper%20101%20RSVP">emarley@mobilebaykeeper.org </a> for this event.<br />
    <h3>Location</h3>
    450-C Government Street<br />
    Mobile, AL 36602<br />
    United States<br />
</p>
<form id="member-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=registration.signup'); ?>" method="post">
    <div class="col c1">
        <div id="default-example" data-collapse>
            <h3>Sign up for Baykeeper 101</h3>
            <div style =" border: 1px solid;line-height: 35px;padding: 10px;">
                <div id="edit-signup-anon-mail-wrapper" class="form-item" >
                    <label for="edit-signup-anon-mail">Email: <span title="This field is required." class="form-required">*</span></label>
                   <input type="email" size="30" value="" id="jform_email1" class="validate-email required invalid" name="jform[email]" aria-required="true" required="required" aria-invalid="true">
                    <div class="description" style="font-size: 14px;line-height: 20px;text-align: left;">
                        An e-mail address is required for users who are not registered at this site. If you are a registered user at this site, please 
                        <a href="index.php?option=com_users">login</a> to sign up for this <em>Events</em>.</div>
                </div>
                <div id="edit-signup-form-data-Name-wrapper" class="form-item">
                    <label for="edit-signup-form-data-Name">Name: <span title="This field is required." class="form-required">*</span></label>
                    <input type="text" class="form-text required" value="" size="40" id="edit-signup-form-data-Name" name="jform[Name]" maxlength="64" aria-required="true" required="required" aria-invalid="true">
                </div>
                <div id="edit-signup-form-data-Phone-wrapper" class="form-item">
                    <label for="edit-signup-form-data-Phone">Phone: </label>
                    <input type="text" class="form-text" value="" size="40" id="edit-signup-form-data-Phone" name="jform[Phone]" maxlength="64">
                </div>
				<?php
					JFactory::getApplication()->triggerEvent('onShowOSOLCaptcha', array(false));
				?> 
                <button type="submit" class="validate"> Sign up </button>
                <input type="hidden" name="option" value="com_users" />
                <input type="hidden" name="task" value="registration.signup" />
                <?php echo JHtml::_('form.token'); ?>
            </div>
        </div>
    </div>
</form>
</div>
