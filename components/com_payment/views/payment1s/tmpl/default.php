<?php
ini_set('display_errors', 0);
error_reporting(E_ERROR);
/**
 * @version     1.0.0
 * @package     com_payment
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Dai Ngo <superqd89@gmail.com> - http://
 */
// no direct access
defined('_JEXEC') or die;
jimport('joomla.html.html.image');
$config = JFactory::getConfig();
?>
<script type="text/javascript">
    $(document).ready(function () {

        $("#pay_later").click(function () {
            if ($("#pay_later").prop("checked")) {
                $('#payment').hide();
                $('#payment :input').removeClass("text required error");
            } else {
                $('#payment').show();
                $('#payment :input:not(#info)').addClass("text required");
            }
        });


        $('input').blur(function () {
            var value = $.trim($(this).val());
            $(this).val(value);
        });


        $("#checkout_form").submit(function (event) {
            $('input').each(function () {
                var value = $.trim($(this).val());
                $(this).val(value);
            })
            $('#x_card_num').trigger("keyup", function () {
            });
        });
    });

</script>
<div class="col-group main-page">
    <article>
        <div class="moduletable">
            <section id="contact">

            <!--    <img src="images/logo.png" alt="Logo Pepmobile" style="display: block;margin-left: auto; margin-right: auto"/>-->
                <h2 align="center">
                    <abbr title="HyperText Markup Language">PEP Membership <?php echo $this->breakfast->value; ?> Breakfast</abbr><br>
                    <abbr title="HyperText Markup Language">
                        <?php
                        $date = strtotime($this->date->value);
                        echo $date = date('M d, Y', $date);
                        ?></abbr><br>
                    <abbr title="HyperText Markup Language">Registration Form</abbr>
                </h2>

                <mark id="message"></mark>

                <form method="post" action=""  name="form1" id="checkout_form">            
                    <input type="hidden" name ="category" value="<?php echo $this->breakfast->value; ?> Breakfast"/>
                    <fieldset>

                        <legend>Contact Details</legend>

                        <div>
                            <label for="firstname1" accesskey="U">First Name</label>
                            <input name="firstname1" type="text" id="firstname1" class="text required"/>
                        </div> 

                        <div>
                            <label for="lastname1" accesskey="U">Last Name</label>
                            <input name="lastname1" type="text" id="lastname1" class="text required"/>
                        </div>                    

                        <div>
                            <label for="company">Company</label>
                            <input name="company" type="text" id="company" size="30" class="text required"/>
                        </div>

                        <div>
                            <label for="phone1">Phone number</label>
                            <input name="phone1" type="text" id="phone1" size="30" class="text required"/>
                        </div>

                        <div>
                            <label for="address1">Address</label>
                            <input name="address1" type="text" id="address1" size="30" class="text required"/>
                        </div>

                        <div>
                            <label for="city1">City</label>
                            <input name="city1" type="text" id="city1" size="30" class="text required"/>
                        </div>

                        <div>
                            <label for="state1">State</label>
                            <input name="state1" type="text" id="state1" size="30" class="text required"/>
                        </div>

                        <div>
                            <label for="zip1">Zip Code</label>
                            <input name="zip1" type="text" id="zip1" size="30" class="text required"/>
                        </div>

                        <div>
                            <label for="email1">Email</label>
                            <input name="email1" type="text" id="email1" size="30" class="text required email" />
                        </div>
                        <div>
                            <label for="special_instructions">Special Instructions</label>
                            <textarea name="special_instructions" id ="special_instructions" style="width:600px"></textarea>
                        </div>
                    </fieldset>

                    <fieldset>

                        <legend>Purchase Tickets</legend>

                        <div>

                            <div id="sele">
                                <label># of People:</label>
                                <input name="breakfast-price" id="breakfast-price" type="hidden" value="<?php echo $config->get("breakfast_price"); ?>"/>
                                <select name="options" id="persons">	
                                    <?php
                                    $num = 1;
                                    for ($num; $num <= 10; $num++) {
                                        $nums[] = $num;
                                    }
                                    foreach ($nums as $number) :
                                        ?>
                                        <option data-value='<?php echo $number; ?>' value='<?php echo $number; ?>' name='mem' <?php
                                        if ($number == 1) {
                                            echo "select=selected";
                                        }
                                        ?>><?php echo $number; ?></option>

<?php endforeach; ?>
                                </select>
                            </div>

                            <div id="currency">
                                <label for="costs">Total</label>
                                <input class="text required" name="x_amount" type="text" id="costs" readonly="readonly" />
                            </div>


                            <div id="addinput">

                            </div>

                            <div class="p1">
                                <p class="subp1">
                                <p>If paying by <b>CHECK</b>, mail invoice and check to the PEP office.<br><br>
                                    If paying with a <b>CREDIT CARD</b> complete the information below.<br>A receipt will be emailed to you.</p>
                                <b>To cancel before 2 p.m. the day prior to the breakfast contact Sara Guntharp.</b><br>
                                </p>                            
                            </div>
                            <p>
                                Partners for Environmental Progress (PEP)<br>
                                754 Downtowner Loop West<br>
                                Mobile, AL  36609<br>
                                Phone: 345-7269    Fax:  342-5575<br>
                                sguntharp@pepmobile.org
                            </p>
                            <p>
                                Partners for Environmental Progress, Inc. is designated by the IRS as a 501(c)(6) organization.
                            </p>

                        </div>

                    </fieldset>
                    <fieldset>
                        <div>
                            <label for="pay_later" accesskey="">Pay later</label>
                            <input  name="pay_later" type="checkbox" id="pay_later" value="1"/>
                        </div>
                    </fieldset>

                    <fieldset>

                        <div id ="payment">
                            <legend>Credit/Debit Card</legend>                    
                            <div>
                                <label for="info" accesskey="">Billing information is same as registration information</label>
                                <input  name="info" type="checkbox" id="info"/>
                            </div>
                            <div>
                                <label for="name" accesskey="U">First Name</label>
                                <input class="text required" name="x_first_name" type="text" id="name" />
                            </div>

                            <div>
                                <label for="name" accesskey="U">Last Name</label>
                                <input type="text" class="text required" name="x_last_name"></input>
                            </div>
                            <div>
                                <label for="address" accesskey="">Billing Address</label>
                                <input class="text required" name="x_address" type="text" id="address" />
                            </div>
                            <div>
                                <label for="city" accesskey="">City</label>
                                <input class="text required" name="x_city" type="text" />
                            </div>

                            <div>
                                <label for="state" accesskey="">State</label>
                                <input class="text required" name="x_state" type="text" id="state" />
                            </div>

                            <div>
                                <label for="zip" accesskey="">Zip Code</label>
                                <input class="text required" name="x_zip" type="text" id="zip" />
                            </div>

                            <div>
                                <label for="cardnumber" accesskey="">Card Number</label>
                                <input type="text" class="text required creditcard stripe_card_number" size="16" name="x_card_num" id= "x_card_num"/>

                            </div>
                            <div style="text-align: center">
                                <ul class="card_logos">
                                    <li class="card_visa">Visa</li>
                                    <li class="card_mastercard">Mastercard</li>
                                    <li class="card_amex">American Express</li>
                                    <!--                                    <li class="card_discover">Discover</li>
                                                                        <li class="card_jcb">JCB</li>
                                                                        <li class="card_diners">Diners Club</li>-->
                                </ul>
                                <input type="hidden" name="x_card_type" id="x_card_type"/>
                            </div>

                            <div>
                                <label for="exp" accesskey="">Expiration Date</label>
                                <input class="text required" name="x_exp_date" type="text" id="dmy" maxlength="5"/><i> Format (MM/YY)</i>
                            </div>

                            <div>
                                <label for="security" accesskey="">Security Code (3-4 digits)</label>
                                <input class="text required" name="x_card_code" type="text" id="security" maxlength="4"/>
                            </div>  


                            <!--<img class="logocredit" src="<?php echo JRoute::_($this->baseurl . 'components/com_payment/assets/creditcardlogos.jpg'); ?>" alt="logo card" height="40" width="120" />-->
                        </div>
                    </fieldset>


                    <?php
                    jimport('joomla.plugin.helper');
                    JPluginHelper::importPlugin('content');
                    $app = JFactory::getApplication();
                    $jResponse = $app->triggerEvent('activeBreakfastPayment');
                    if ($jResponse[0] == "true") {
                        echo '	<input type="submit" class="submit buy" value="Purchase" id="confirm">';
                    } else {
                        echo '	<input type="button" readonly="readonly" class="submit_lock buy" value="Purchase">';
                    }
                    ?>
<?php echo JHtml::_('form.token'); ?>			
                    <input type="hidden"  name="nameofpayment" value="Breakfast" />					
                    <input type="hidden" name="option" value="com_payment" />
                    <input type="hidden" name="task" value="payment1s.submit" />
<!--                    <p>
                        *Note: <i>Cancellations prior to 2 p.m. of the prior day will be credited to your PEP account.</i>
                    </p>-->
                </form>

            </section>
        </div>
    </article>
</div> 


