<?php
/*
 * @package		Joomla.Framework
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 *
 * @component Phoca Component
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2 or later;
 */

defined('_JEXEC') or die;
JHtml::_('behavior.tooltip');
$user = JFactory::getUser();
$userId = $user->get('id');
$db = JFactory::getDbo();
$query = "SELECT * From jos_phocagallery_speed Where id = 1 ";
$db->setQuery($query);
$items = $db->loadObject();

?>

<form action="<?php echo JRoute::_('index.php?option=com_phocagallery&view=phocagalleryraimg&task=phocagalleryimg.submispeed'); ?>" method="post" name="adminForm" id="adminForm">

    <div class="width-60 fltlft">

        <fieldset class="adminform">
            <legend>Speed Slide Show</legend>


            <div style="float:right;margin:5px;"></div>			
            <ul class="adminformlist">
                <li>
                    <label title="" for="jform_speed" >Transition - seconds</label>
                    <select name ="jform[speed]" >
                        <option value ="1000" <?php echo ($items->speed == 1000) ? "selected" : "" ?> >1</option>
                        <option value ="2000" <?php echo ($items->speed == 2000) ? "selected" : "" ?> >2</option>
                        <option value ="3000" <?php echo ($items->speed == 3000) ? "selected" : "" ?>>3</option>
                        <option value ="4000" <?php echo ($items->speed == 4000) ? "selected" : "" ?>>4</option>
                        <option value ="5000" <?php echo ($items->speed == 5000) ? "selected" : "" ?>>5</option>
                        <option value ="6000" <?php echo ($items->speed == 6000) ? "selected" : "" ?>>6</option>
                        <option value ="7000" <?php echo ($items->speed == 7000) ? "selected" : "" ?>>7</option>
                        <option value ="8000" <?php echo ($items->speed == 8000) ? "selected" : "" ?>>8</option>
                        <option value ="9000" <?php echo ($items->speed == 9000) ? "selected" : "" ?>>9</option>
                        <option value ="10000" <?php echo ($items->speed == 10000) ? "selected" : "" ?>>10</option>
                    </select>
                </li>
                <li>
                    <label title="" for="jform_timeout" >Display - seconds</label>
                    <select name ="jform[timeout]" >
                        <option value ="1000" <?php echo ($items->timeout == 1000) ? "selected" : "" ?> >1</option>
                        <option value ="2000" <?php echo ($items->timeout == 2000) ? "selected" : "" ?> >2</option>
                        <option value ="3000" <?php echo ($items->timeout == 3000) ? "selected" : "" ?>>3</option>
                        <option value ="4000" <?php echo ($items->timeout == 4000) ? "selected" : "" ?>>4</option>
                        <option value ="5000" <?php echo ($items->timeout == 5000) ? "selected" : "" ?>>5</option>
                        <option value ="6000" <?php echo ($items->timeout == 6000) ? "selected" : "" ?>>6</option>
                        <option value ="7000" <?php echo ($items->timeout == 7000) ? "selected" : "" ?>>7</option>
                        <option value ="8000" <?php echo ($items->timeout == 8000) ? "selected" : "" ?>>8</option>
                        <option value ="9000" <?php echo ($items->timeout == 9000) ? "selected" : "" ?>>9</option>
                        <option value ="10000" <?php echo ($items->timeout == 10000) ? "selected" : "" ?>>10</option>
                    </select>
                </li>
            </ul>
            <div class="clr"></div>
        </fieldset>
    </div>
<!--    <input type="hidden" name="option" value="com_phocagallery" />-->
    <input type="hidden" name="task" value="" />
    <?php echo JHtml::_('form.token'); ?>
</form>