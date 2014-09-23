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
// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_payment/assets/css/payment.css');

$user = JFactory::getUser();
$userId = $user->get('id');
$listOrder = $this->state->get('list.ordering');
$listDirn = $this->state->get('list.direction');
$canOrder = $user->authorise('core.edit.state', 'com_payment');
$saveOrder = $listOrder == 'a.ordering';
?>

<form action="<?php echo JRoute::_('index.php?option=com_payment&view=customers'); ?>" method="post" name="adminForm" id="adminForm">
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
                <th class='left'>
                    <?php echo JHtml::_('grid.sort', 'Date', 'a.order_date', $listDirn, $listOrder); ?>
                </th>
                <th class='left'>
                    <?php echo JHtml::_('grid.sort', 'Customer', 'a.first_name', $listDirn, $listOrder); ?>
                </th>
                <th class='left'>
                    <?php echo JHtml::_('grid.sort', 'Address', 'a.address', $listDirn, $listOrder); ?>
                </th>


                <?php // if (isset($this->items[0]->state)) {  ?>
                <th width="5%">Purchase_Amount
                    <?php //echo JHtml::_('grid.sort',  'JPUBLISHED', 'a.state', $listDirn, $listOrder);  ?>
                </th>
                <th width="5%">Payment Status
                    <?php //echo JHtml::_('grid.sort',  'JPUBLISHED', 'a.state', $listDirn, $listOrder);  ?>
                </th>
                <?php // }  ?>
                <?php if (isset($this->items[0]->ordering)) { ?>
                    <th width="10%">
                        <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ORDERING', 'a.ordering', $listDirn, $listOrder); ?>
                        <?php if ($canOrder && $saveOrder) : ?>
                            <?php echo JHtml::_('grid.order', $this->items, 'filesave.png', 'customers.saveorder'); ?>
                        <?php endif; ?>
                    </th>
                <?php } ?>
                <?php if (isset($this->items[0]->id)) { ?>
                    <th width="1%" class="nowrap">
                        <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
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
                $canCreate = $user->authorise('core.create', 'com_payment');
                $canEdit = $user->authorise('core.edit', 'com_payment');
                $canCheckin = $user->authorise('core.manage', 'com_payment');
                $canChange = $user->authorise('core.edit.state', 'com_payment');
                ?>
                <tr class="row<?php echo $i % 2; ?>">
                    <td class="center">
                        <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                    </td>
                    <td><?php
                        echo JHTML::_('date', $item->order_date,"m-d-Y");
                        ?></td>
                    <td>
                        <?php if (isset($item->checked_out) && $item->checked_out) : ?>
                            <?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'customers.', $canCheckin); ?>
                        <?php endif; ?>
                        <?php if ($canEdit) : ?>
                            <a href="<?php echo JRoute::_('index.php?option=com_payment&task=customer.edit&layout=preview&id=' . (int) $item->id); ?>">
                                <?php echo $this->escape($item->first_name) . " " . $this->escape($item->last_name); ?></a>
                        <?php else : ?>
                            <?php echo $this->escape($item->first_name) . " " . $this->escape($item->last_name); ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php echo $item->address; ?>
                    </td>


                    <td class="center"><?php echo "$ " . number_format($item->total, 2); ?>
                        <?php // echo JHtml::_('jgrid.published', $item->state, $i, 'customers.', $canChange, 'cb');  ?>
                    </td>
                    <?php if (isset($this->items[0]->ordering)) { ?>
                        <td class="order">
                            <?php if ($canChange) : ?>
                                <?php if ($saveOrder) : ?>
                                    <?php if ($listDirn == 'asc') : ?>
                                        <span><?php echo $this->pagination->orderUpIcon($i, true, 'customers.orderup', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
                                        <span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, true, 'customers.orderdown', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
                                    <?php elseif ($listDirn == 'desc') : ?>
                                        <span><?php echo $this->pagination->orderUpIcon($i, true, 'customers.orderdown', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
                                        <span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, true, 'customers.orderup', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php $disabled = $saveOrder ? '' : 'disabled="disabled"'; ?>
                                <input type="text" name="order[]" size="5" value="<?php echo $item->ordering; ?>" <?php echo $disabled ?> class="text-area-order" />
                            <?php else : ?>
                                <?php echo $item->ordering; ?>
                            <?php endif; ?>
                        </td>
                    <?php } ?>
                    <td class="center">
                        <?php echo $item->payment_status; ?>
                    </td>
                    <?php if (isset($this->items[0]->id)) { ?>
                        <td class="center">
                            <?php echo (int) $item->id; ?>
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
