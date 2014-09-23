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
$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query = "SELECT * FROM jos_payment WHERE" . $db->quoteName('id') . "=" . htmlentities($_GET['id']);
//if ($_GET['nopayment']) {
//    $query = "SELECT * FROM jos_payment WHERE" . $db->quoteName('id') . "=" . htmlentities($_GET['id']);
//} else {
//    $query = "SELECT * FROM jos_payment WHERE" . $db->quoteName('transaction_id') . "=" . htmlentities($_GET['transaction_id']);
//}
$db->setQuery($query);
$datas = $db->loadObjectList();

$data[] = array();
foreach ($datas as $d) {
    $data = $d;
}
//var_dump($data->id);exit;
$non_members = split(",", $data->non_mem_name_ticket);
$members = split(",", $data->mem_name_ticket);
?>

<div class="col-group main-page">
    <article>
        <div class="moduletable">
            <section id="contact">



                <mark id="message"></mark>

                <form method="get" action="index.php"  name="form1" id="checkout_form">            
                    <div id="dvContainer">
                        <fieldset id="order">
                            <?php ?>
                            <legend><h3>Detail</h3></legend>
                            <p><strong>Order Information </strong></p>
                            <br/>
                            <p>Customer</p>
                            <hr/>
                            <table width="100%">
                                <tr>
                                    <td width="60%">First Name:</td>
                                    <td><?php echo $data->first_name ?></td>
                                </tr>
                                <tr>
                                    <td>Last Name:</td>
                                    <td><?php echo $data->last_name ?></td>
                                </tr>
                                <tr>
                                    <td>Company:</td>
                                    <td><?php echo $data->company ?></td>
                                </tr>
                                <tr>
                                    <td>Address:</td>
                                    <td><?php echo $data->address ?></td>
                                </tr>
                                <tr>
                                    <td>Phone:</td>
                                    <td><?php echo $data->phone ?></td>
                                </tr>
                                <tr>
                                    <td>City:</td>
                                    <td><?php echo $data->city ?></td>
                                </tr>
                                <tr>
                                    <td>Zip:</td>
                                    <td><?php echo $data->zip ?></td>
                                </tr>
                                <tr>
                                    <td>Email:</td>
                                    <td><?php echo $data->email ?></td>
                                </tr>
                            </table>
                            <br/>
                            <p>Order</p>
                            <hr/>
                            <table width="100%">
                                <tr>
                                    <td width="60%">Order Number:</td>
                                    <td><?php echo $data->id ?></td>
                                </tr>
                                <tr>
                                    <td width="60%">Order Date:</td>
                                    <td><?php echo date("m-d-Y", strtotime($data->order_date)); ?></td>
                                </tr>
                                <?php if ($data->transaction_id): ?>

                                    <tr>
                                        <td width="60%">Transaction Number:</td>
                                        <td><?php echo $data->transaction_id ?></td>
                                    </tr>

                                    <tr>
                                        <td width="60%">Transaction Date:</td>
                                        <td><?php echo date("m-d-Y", strtotime($data->transaction_date)); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <td width="60%">Category:</td>
                                    <td><?php echo $data->category ?></td>
                                </tr>
<!--                                <tr>
                                    <td>Number Of Member:</td>
                                    <td><?php echo $data->num_mem ?></td>
                                </tr>-->

                                <tr>
                                    <td>Total:</td>
                                    <td>$<?php echo number_format($data->total, 2); ?></td>
                                </tr>
                            </table>
                            <br/>
                            Payment
                            <hr/>
                            <table width="100%">
                                <tr>
                                    <td width="60%">Payment Status:</td>
                                    <td><?php echo $data->payment_status; ?></td>
                                </tr>
                                <?php if ($data->transaction_id): ?>


                                    <tr>
                                        <td width="60%">CC Number:</td>
                                        <td><?php echo $data->cc_number; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="60%">CC Type:</td>
                                        <td><?php echo $data->cc_card_type; ?></td>
                                    </tr>
                                <?php endif; ?>
                            </table>
                            <br/>
                            <br/>
                            <p>Members</p>
                            <hr/>

                            <table width="100%">
                                <tr>
                                    <td width="60%"><strong>Name</strong></td>
                                    <td><strong>Company</strong></td>
                                </tr>
                                <?php
                                foreach ($members as $m) {
                                    $company = explode(":", $m);
                                    ?>
                                    <tr> 
                                        <td><?php echo $company[0] ?></td>
                                        <td><?php echo $company[1] ?></td>
                                    </tr>
                                <?php } ?>

                            </table>
                            <br/>
                            <br/>
                            <p>Non Member</p>
                            <hr/>
                            <table width="100%">
                                <tr>
                                    <td width ="60%"><strong>Name</strong></td>
                                    <td><strong>Company</strong></td>
                                </tr>
                                <?php
                                foreach ($non_members as $m) {
                                    $company = explode(":", $m);
                                    ?>
                                    <tr> 
                                        <td><?php echo $company[0] ?></td>
                                        <td><?php echo $company[1] ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </fieldset>
                    </div>
                    <input type="submit" class="submit" value="Thank You">
                    <input type="button" value="Print Order" id="btnPrint" class="submit" />

                </form>



            </section>
        </div>
    </article>
</div>
