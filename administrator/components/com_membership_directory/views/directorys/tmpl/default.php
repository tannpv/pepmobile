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

JHtml::_('behavior.tooltip');
JHTML::_('script', 'system/multiselect.js', false, true);
// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_membership_directory/assets/css/membership_directory.css');

$user = JFactory::getUser();
$userId = $user->get('id');
$listOrder = $this->state->get('list.ordering');
$listDirn = $this->state->get('list.direction');
$canOrder = $user->authorise('core.edit.state', 'com_membership_directory');
$saveOrder = $listOrder == 'a.ordering';
?>

<form action="<?php echo JRoute::_('index.php?option=com_membership_directory&view=directorys'); ?>" method="post" name="adminForm" id="adminForm">
    <fieldset id="filter-bar">
        <div class="filter-search fltlft">
            <label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
            <input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('Search'); ?>" />
            <button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
            <button type="button" onclick="document.id('filter_search').value = '';
                    this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
        </div>



    </fieldset>
    <div class="clr"> </div>

    <table class="adminlist">
        <thead>
            <tr>
                <th width="1%">
                    <input type="checkbox" name="checkall-toggle" value="" onclick="checkAll(this)" />
                </th>
                <?php if (isset($this->items[0]->id)) { ?>
                    <th width="1%" class="nowrap">
                        <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
                    </th>
                <?php } ?>
                <th class='left'>
                    <?php echo JHtml::_('grid.sort', 'COM_MEMBERSHIP_DIRECTORY_DIRECTORYS_COMPANY', 'a.company', $listDirn, $listOrder); ?>
                </th>
                <th class='left'>
                    <?php echo JHtml::_('grid.sort', 'COM_MEMBERSHIP_DIRECTORY_DIRECTORYS_DESINGATED_REP', 'a.desingated_rep', $listDirn, $listOrder); ?>
                </th>
              
                <th class='left'>
                    <?php echo JHtml::_('grid.sort', 'COM_MEMBERSHIP_DIRECTORY_DIRECTORYS_BUSINESS_CATEGORY', 'a.business_category', $listDirn, $listOrder); ?>
                </th>

                <th class='left'>
                    <?php echo JHtml::_('grid.sort', 'COM_MEMBERSHIP_DIRECTORY_DIRECTORYS_ADDRESS', 'a.address', $listDirn, $listOrder); ?>
                </th>
                <th class='left'>
                    <?php echo JHtml::_('grid.sort', 'COM_MEMBERSHIP_DIRECTORY_DIRECTORYS_CITY_STATE_ZIP', 'a.city_state_zip', $listDirn, $listOrder); ?>
                </th>
                <th class='left'>
                    <?php echo JHtml::_('grid.sort', 'COM_MEMBERSHIP_DIRECTORY_DIRECTORYS_FIRST_NAME', 'a.first_name', $listDirn, $listOrder); ?>
                </th>
                <th class='left'>
                    <?php echo JHtml::_('grid.sort', 'COM_MEMBERSHIP_DIRECTORY_DIRECTORYS_LAST_NAME', 'a.last_name', $listDirn, $listOrder); ?>
                </th>
                <th class='left'>
                    <?php echo JHtml::_('grid.sort', 'COM_MEMBERSHIP_DIRECTORY_DIRECTORYS_JOB_TITLE', 'a.job_title', $listDirn, $listOrder); ?>
                </th>
                <th class='left'>
                    <?php echo JHtml::_('grid.sort', 'COM_MEMBERSHIP_DIRECTORY_DIRECTORYS_EMAIL', 'a.email', $listDirn, $listOrder); ?>
                </th>
                <th class='left'>
                    <?php echo JHtml::_('grid.sort', 'COM_MEMBERSHIP_DIRECTORY_DIRECTORYS_WEBSITE', 'a.website', $listDirn, $listOrder); ?>
                </th>
                <th class='left'>
                    <?php echo JHtml::_('grid.sort', 'COM_MEMBERSHIP_DIRECTORY_DIRECTORYS_PHONE', 'a.phone', $listDirn, $listOrder); ?>
                </th>
                <th class='left'>
                    <?php echo JHtml::_('grid.sort', 'COM_MEMBERSHIP_DIRECTORY_DIRECTORYS_FAX', 'a.fax', $listDirn, $listOrder); ?>
                </th>
          
                <th class='left'>
                    <?php echo JHtml::_('grid.sort', 'COM_MEMBERSHIP_DIRECTORY_DIRECTORYS_DESCRIPTION', 'a.description', $listDirn, $listOrder); ?>
                </th>
         


                <?php if (isset($this->items[0]->state)) { ?>
                    <th width="5%">
                        <?php echo JHtml::_('grid.sort', 'JPUBLISHED', 'a.state', $listDirn, $listOrder); ?>
                    </th>
                <?php } ?>
                <?php if (isset($this->items[0]->ordering)) { ?>
                    <th width="10%">
                        <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ORDERING', 'a.ordering', $listDirn, $listOrder); ?>
                        <?php if ($canOrder && $saveOrder) : ?>
                            <?php echo JHtml::_('grid.order', $this->items, 'filesave.png', 'directorys.saveorder'); ?>
                        <?php endif; ?>
                    </th>
                <?php } ?>

            </tr>
        </thead>
        <tfoot>
            <?php
            if (isset($this->items[0])) {
                $colspan = count(get_object_vars($this->items[0]));
            } else {
                $colspan = 10;
            }
            ?>
            <tr>
                <td colspan="<?php echo $colspan ?>">
                    <?php echo $this->pagination->getListFooter(); ?>
                </td>
            </tr>
        </tfoot>
        <tbody>
            <?php
            foreach ($this->items as $i => $item) :
                $ordering = ($listOrder == 'a.ordering');
                $canCreate = $user->authorise('core.create', 'com_membership_directory');
                $canEdit = $user->authorise('core.edit', 'com_membership_directory');
                $canCheckin = $user->authorise('core.manage', 'com_membership_directory');
                $canChange = $user->authorise('core.edit.state', 'com_membership_directory');
                ?>
                <tr class="row<?php echo $i % 2; ?>" style="cursor:pointer">
                    <td class="center">
                        <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                    </td>

                    <?php if (isset($this->items[0]->id)) { ?>
                        <td class="center">
                            <?php echo (int) $item->id; ?>
                        </td>
                    <?php } ?>
                    <td onclick="location.href = '<?php echo JRoute::_('index.php?option=com_membership_directory&task=directory.edit&id=' . (int) $item->id); ?>'">
                        <?php echo $item->company; ?>
                    </td>
                    <td onclick="location.href = '<?php echo JRoute::_('index.php?option=com_membership_directory&task=directory.edit&id=' . (int) $item->id); ?>'">
                        <?php echo $item->desingated_rep; ?>
                    </td>
           
                
                    <td onclick="location.href = '<?php echo JRoute::_('index.php?option=com_membership_directory&task=directory.edit&id=' . (int) $item->id); ?>'">
                        <?php echo $item->business_category; ?>
                    </td>
              

                    <td onclick="location.href = '<?php echo JRoute::_('index.php?option=com_membership_directory&task=directory.edit&id=' . (int) $item->id); ?>'">
                        <?php echo $item->address; ?>
                    </td>
                    <td onclick="location.href = '<?php echo JRoute::_('index.php?option=com_membership_directory&task=directory.edit&id=' . (int) $item->id); ?>'">
                        <?php echo $item->city_state_zip; ?>
                    </td>
                    <td onclick="location.href = '<?php echo JRoute::_('index.php?option=com_membership_directory&task=directory.edit&id=' . (int) $item->id); ?>'">
                        <?php echo $item->first_name; ?>
                    </td>
                    <td onclick="location.href = '<?php echo JRoute::_('index.php?option=com_membership_directory&task=directory.edit&id=' . (int) $item->id); ?>'">
                        <?php echo $item->last_name; ?>
                    </td>
                    <td onclick="location.href = '<?php echo JRoute::_('index.php?option=com_membership_directory&task=directory.edit&id=' . (int) $item->id); ?>'">
                        <?php echo $item->job_title; ?>
                    </td>
                    <td onclick="location.href = '<?php echo JRoute::_('index.php?option=com_membership_directory&task=directory.edit&id=' . (int) $item->id); ?>'">
                        <?php echo $item->email; ?>
                    </td>
                    <td onclick="location.href = '<?php echo JRoute::_('index.php?option=com_membership_directory&task=directory.edit&id=' . (int) $item->id); ?>'">
                        <?php echo $item->website; ?>
                    </td>
                    <td onclick="location.href = '<?php echo JRoute::_('index.php?option=com_membership_directory&task=directory.edit&id=' . (int) $item->id); ?>'">
                        <?php echo $item->phone; ?>
                    </td>
               
                    <td onclick="location.href = '<?php echo JRoute::_('index.php?option=com_membership_directory&task=directory.edit&id=' . (int) $item->id); ?>'">
                        <?php echo $item->fax; ?>
                    </td>
             
                    <td class="descript" onclick="location.href = '<?php echo JRoute::_('index.php?option=com_membership_directory&task=directory.edit&id=' . (int) $item->id); ?>'">
                        <?php echo $item->description; ?>
                    </td>
                   

                    <?php if (isset($this->items[0]->state)) { ?>
                        <td class="center">
                            <?php echo JHtml::_('jgrid.published', $item->state, $i, 'directorys.', $canChange, 'cb'); ?>
                        </td>
                    <?php } ?>
                    <?php if (isset($this->items[0]->ordering)) { ?>
                        <td class="order">
                            <?php if ($canChange) : ?>
                                <?php if ($saveOrder) : ?>
                                    <?php if ($listDirn == 'asc') : ?>
                                        <span><?php echo $this->pagination->orderUpIcon($i, true, 'directorys.orderup', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
                                        <span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, true, 'directorys.orderdown', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
                                    <?php elseif ($listDirn == 'desc') : ?>
                                        <span><?php echo $this->pagination->orderUpIcon($i, true, 'directorys.orderdown', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
                                        <span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, true, 'directorys.orderup', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php $disabled = $saveOrder ? '' : 'disabled="disabled"'; ?>
                                <input type="text" name="order[]" size="5" value="<?php echo $item->ordering; ?>" <?php echo $disabled ?> class="text-area-order" />
                            <?php else : ?>
                                <?php echo $item->ordering; ?>
                            <?php endif; ?>
                        </td>
                    <?php } ?>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div>
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="0" />
        <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
        <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>