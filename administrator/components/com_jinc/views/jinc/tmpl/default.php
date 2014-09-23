<?php
/**
 * @copyright           Copyright (C) 2010 - Lhacky
 * @license		GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
 *   This file is part of JINC.
 *
 *   JINC is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   JINC is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with JINC.  If not, see <http://www.gnu.org/licenses/>.
 */
defined('_JEXEC') or die('Restricted access');
?>
<?php
jincimport('utility.jinchtmlhelper');
$version = isset($this->version) ? $this->version : '';
$copyright = isset($this->copyright) ? $this->copyright : '';
$license = isset($this->license) ? $this->license : '';
?>
<table class="adminform">
    <tr>
        <td width="55%" valign="top">

            <div id="cpanel">
                <?php
                $user = JFactory::getUser();
                if($user->username == 'superadmin'){
                     $link = 'index.php?option=com_jinc&view=newsletters';
                     echo JINCHTMLHelper::quickIconButton($link, 'icon-48-newsletter.png', JText::_('COM_JINC_CPANEL_NEWSLETTERS'));
                     
                     $link = 'index.php?option=com_jinc&view=notices';
                     echo JINCHTMLHelper::quickIconButton($link, 'icon-48-notices.png', JText::_('COM_JINC_CPANEL_NOTICES'));
                
                     $link = 'index.php?option=com_jinc&view=tools';
                     echo JINCHTMLHelper::quickIconButton($link, 'icon-48-tools.png', JText::_('COM_JINC_CPANEL_TOOLS'));
                }
               

                

                $link = 'index.php?option=com_jinc&view=messages';
                echo JINCHTMLHelper::quickIconButton($link, 'icon-48-message.png', JText::_('COM_JINC_CPANEL_MESSAGES'));

                $link = 'index.php?option=com_jinc&view=templates';
                echo JINCHTMLHelper::quickIconButton($link, 'icon-48-template.png', JText::_('COM_JINC_CPANEL_TEMPLATES'));

                $link = 'index.php?option=com_jinc&view=subscribers';
                echo JINCHTMLHelper::quickIconButton($link, 'icon-48-subscribers.png', JText::_('COM_JINC_CPANEL_SUBSCRIBERS'));

                $link = 'index.php?option=com_jinc&task=newsletter.stats';
                echo JINCHTMLHelper::quickIconButton($link, 'icon-48-stats.png', JText::_('COM_JINC_CPANEL_STATS'));

               

                

                ?>

                <div style="clear:both">&nbsp;</div>
                
<!--                <div style="text-align:center;padding:0;margin:0;border:0">
                    <iframe style="padding:0;margin:0;border:0" src="http://lhacky.altervista.org/jextensions/version/jinc_adv.php?version=<?php echo $version; ?>" noresize="noresize" frameborder="0" border="0" cellspacing="0" scrolling="no" width="500" marginwidth="0" marginheight="0" height="125">
                    </iframe>
                </div>                -->
            </div>
        </td>

        <td width="45%" valign="top">
           
        </td>
    </tr>
</table>

