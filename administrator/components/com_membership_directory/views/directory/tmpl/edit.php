<?php
/**
 * @version     1.0.0
 * @package     com_membership_directory
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomla Component <Joomla@Joomla.com> - http://www.joomla.org
 */
// no direct access
defined('_JEXEC') or die();

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_membership_directory/assets/css/membership_directory.css');
?>
<script type="text/javascript">
    function getScript(url, success) {
        var script = document.createElement('script');
        script.src = url;
        var head = document.getElementsByTagName('head')[0],
                done = false;
        // Attach handlers for all browsers
        script.onload = script.onreadystatechange = function() {
            if (!done && (!this.readyState
                    || this.readyState == 'loaded'
                    || this.readyState == 'complete')) {
                done = true;
                success();
                script.onload = script.onreadystatechange = null;
                head.removeChild(script);
            }
        };
        head.appendChild(script);
    }
    getScript('//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js', function() {
        js = jQuery.noConflict();
        js(document).ready(function() {


            Joomla.submitbutton = function(task)
            {
                if (task == 'directory.cancel') {
                    Joomla.submitform(task, document.getElementById('directory-form'));
                }
                else {

                    if (task != 'directory.cancel' && document.formvalidator.isValid(document.id('directory-form'))) {

                        Joomla.submitform(task, document.getElementById('directory-form'));
                    }
                    else {
                        alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
                    }
                }
            }
        });
    });


</script>
<form
    action="<?php echo JRoute::_('index.php?option=com_membership_directory&layout=edit&id=' . (int) $this->item->id); ?>"
    method="post" enctype="multipart/form-data" name="adminForm"
    id="directory-form" class="form-validate">
    <div class="width-60 fltlft">
        <fieldset class="adminform">
            <legend><?php echo JText::_('COM_MEMBERSHIP_DIRECTORY_LEGEND_DIRECTORY'); ?></legend>

            <ul class="adminformlist">
                <div>
                    <div>
                        <li><?php echo $this->form->getLabel('id'); ?>
                            <?php echo $this->form->getInput('id'); ?></li>
                        <li><?php echo $this->form->getLabel('desingated_rep'); ?>
                            <?php echo $this->form->getInput('desingated_rep'); ?></li>
                       
                        <li><?php echo $this->form->getLabel('business_category'); ?>
                            <?php echo $this->form->getInput('business_category'); ?></li>
                        <li><?php echo $this->form->getLabel('company'); ?>
                            <?php echo $this->form->getInput('company'); ?></li>
                        <li><?php echo $this->form->getLabel('address'); ?>
                            <?php echo $this->form->getInput('address'); ?></li>
                        <li><?php echo $this->form->getLabel('description'); ?>
                            <?php echo $this->form->getInput('description'); ?></li>

                        <li><?php echo $this->form->getLabel('city_state_zip'); ?>
                            <?php echo $this->form->getInput('city_state_zip'); ?></li>
                        <li><?php echo $this->form->getLabel('first_name'); ?>
                            <?php echo $this->form->getInput('first_name'); ?></li>
                        <li><?php echo $this->form->getLabel('last_name'); ?>
                            <?php echo $this->form->getInput('last_name'); ?></li>
                        <li><?php echo $this->form->getLabel('job_title'); ?>
                            <?php echo $this->form->getInput('job_title'); ?></li>
                        <li><?php echo $this->form->getLabel('email'); ?>
                            <?php echo $this->form->getInput('email'); ?></li>
                        <li><?php echo $this->form->getLabel('website'); ?>
                            <?php echo $this->form->getInput('website'); ?></li>
                        <li><?php echo $this->form->getLabel('phone'); ?>
                            <?php echo $this->form->getInput('phone'); ?></li>
                        <li><?php echo $this->form->getLabel('fax'); ?>
                            <?php echo $this->form->getInput('fax'); ?></li>
     
                        <li><?php echo $this->form->getLabel('pass'); ?>
                            <?php echo $this->form->getInput('pass'); ?></li>
                     
                    </div>
                </div>
            </ul>	

            <?php
            foreach ($this->form->getFieldset('usermem') as $field) {
                if ($this->grouplist) :
                    ?>
                    <fieldset id="user-groups">
                        <legend><?php echo JText::_('COM_USERS_ASSIGNED_GROUPS'); ?></legend>
                        <?php echo $this->loadTemplate('groups'); ?>
                    </fieldset>
                <?php endif;
            } ?>

        </fieldset>


    </div>



    <input type="hidden" name="task" value="" />
<?php echo JHtml::_('form.token'); ?>
    <div class="clr"></div>
</form>