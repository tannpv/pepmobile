<?php
/**
 * @version     1.0.0
 * @package     com_payment
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Dai Ngo <superqd89@gmail.com> - http://
 */
// no direct access
defined('_JEXEC') or die;

JHtml::_('behavior.tooltip');
JHTML::_('script', 'system/multiselect.js', false, true);
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_payment/assets/css/payment.css');
?>
<script type="text/javascript">
    function getScript(url, success) {
        var script = document.createElement('script');
        script.src = url;
        var head = document.getElementsByTagName('head')[0],
                done = false;
        // Attach handlers for all browsers
        script.onload = script.onreadystatechange = function () {
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
    getScript('//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js', function () {
        js = jQuery.noConflict();
        js(document).ready(function () {


            Joomla.submitbutton = function (task)
            {
                if (task == 'breakfast.cancel') {
                    Joomla.submitform(task, document.getElementById('breakfast-form'));
                }
                else {

                    if (task != 'breakfast.cancel' && document.formvalidator.isValid(document.id('breakfast-form'))) {

                        Joomla.submitform(task, document.getElementById('breakfast-form'));
                    }
                    else {
                        alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
                    }
                }
            }
        });
    });
</script>

<form action="<?php echo JRoute::_('index.php?option=com_payment&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="breakfast-form" class="form-validate">
    <div class="width-60 fltlft">
        <fieldset class="adminform">

            <ul class="adminformlist">
                <li><label>Month</label>
                    <select name ="month">
                        <?php for ($m = 1; $m <= 12; $m++): ?>
                            <?php $month = date('F', mktime(0, 0, 0, $m, 1, date('Y'))); ?>
                            <?php if ($month == $this->item->value): ?>
                                <option value ="<?php echo $month; ?>" selected="selected"><?php echo $month; ?></option>
                            <?php else: ?>
                                <option value ="<?php echo $month; ?>"><?php echo $month; ?></option>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </select>

                </li>
                <li><label>Date</label>
                    <?php
                    if (!$date=$this->date->value)
                        $date = date("Y-m-d");
                    ?>
                    <?php echo JHTML::calendar($date, 'date', 'date', '%Y-%m-%d'); ?>
                </li>
            </ul>

        </fieldset>
    </div>
    <input type="hidden" name="task" value="" />
    <?php echo JHtml::_('form.token'); ?>
</form>