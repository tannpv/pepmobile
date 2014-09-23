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
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_payment/assets/css/payment.css');
?>
<form action="<?php echo JRoute::_('index.php?option=com_payment&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="customer-form" class="form-validate">
    <div class="width-60 fltlft">
        <fieldset class="adminform">
            <legend>Detail</legend>
            <table class="adminlist">

                <tbody>
                    <tr>
                        <td>
                            Date				
                        </td>
                        <td>
                            <?php echo   JHTML::_('date', $item->order_date,"m-d-Y"); ?>				
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Category				</td>
                        <td>
                            <?php echo $this->item->category; ?>				
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Numbers of Members</td>
                        <td>
                            <?php echo $this->item->num_mem; ?>	</td>
                    </tr>
                    <tr>
                        <td>
                            Payment Status</td>
                        <td>
                            <?php echo $this->item->payment_status; ?>	</td>
                    </tr>
                    <tr>
                        <td>
                            Total</td>
                        <td>
                            <?php
                            echo "$ " . number_format($this->item->total, 2);
                            ?>                           	
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Special Instructions</td>
                        <td>
                            <?php
                            echo $this->item->special_instructions;
                            ?>                           	</td>
                    </tr>


                </tbody>
            </table>
        </fieldset>
    </div>

    <div class="width-40 fltlft">
        <?php echo JHtml::_('sliders.start', 'banner-sliders-' . $this->item->id, array('useCookie' => 1)); ?>

        <?php echo JHtml::_('sliders.panel', JText::_('Customer'), 'publishing-details'); ?>
        <fieldset class="panelform">
            <table class="adminlist">

                <tbody>
                    <tr>
                        <td>
                            Name
                        </td>
                        <td>
                            <?php echo $this->item->first_name . " " . $this->item->last_name; ?>				</td>
                    </tr>

                    <tr>
                        <td>
                            Company	
                        </td>
                        <td>
                            <?php echo $this->item->company; ?>	</td>
                    </tr>
                    <tr>
                        <td>
                            Address	
                        </td>
                        <td>
                            <?php echo $this->item->address; ?>	</td>
                    </tr>
                    <tr>
                        <td>
                            Phone	
                        </td>
                        <td>
                            <?php echo $this->item->phone; ?>	</td>
                    </tr>
                    <tr>
                        <td>
                            City	
                        </td>
                        <td>
                            <?php echo $this->item->city; ?>	</td>
                    </tr>
                    <tr>
                        <td>
                            State	
                        </td>
                        <td>
                            <?php echo $this->item->state; ?>	</td>
                    </tr>
                    <tr>
                        <td>
                            Zip	
                        </td>
                        <td>
                            <?php echo $this->item->zip; ?>	</td>
                    </tr>
                    <tr>
                        <td>
                            Email	
                        </td>
                        <td>
                            <?php echo $this->item->email; ?>	</td>
                    </tr>

                </tbody>
            </table>

        </fieldset>

        <?php echo JHtml::_('sliders.panel', JText::_('Members'), 'metadata'); ?>
        <fieldset class="panelform">
            <table class="adminlist">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Company</th>

                    </tr>
                </thead>
                <tfoot>
                    <tr><td colspan="2"></td></tr>
                </tfoot>
                <tbody>
                    <?php
                    $members = array();
                    if ($this->item->mem_name_ticket) {
                        $members = explode(",", $this->item->mem_name_ticket);
                    }
                    ?>
                    <?php
                    foreach ($members as $m):
                        $company = explode(":", $m);
                        ?>
                        <tr>
                            <td>
                                <?php echo $company[0]; ?>				</td>
                            <td>
                                <?php echo $company[1]; ?>				</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </fieldset>

        <?php echo JHtml::_('sliders.end'); ?>

    </div>

    <input type="hidden" name="task" value="" />
    <?php echo JHtml::_('form.token'); ?>
    <div class="clr"></div>

    <style type="text/css">
        /* Temporary fix for drifting editor fields */
        .adminformlist li {
            clear: both;
        }
    </style>
</form>