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
?>
<script type="text/javascript">
    function deleteItem(item_id) {
        if (confirm("<?php echo JText::_('COM_PAYMENT_DELETE_MESSAGE'); ?>")) {
            document.getElementById('form-customer-delete-' + item_id).submit();
        }
    }
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $.validator.addMethod("check_reference", function (value, element) {
            var checked = $(".reference:checked").length > 0;
            if (checked || $("#reference_other").val().length > 0) {
                return true;
            } else {
                return false;
            }
        }, "Please select the folowing options for specify a new one!");

        $("#checkout_form").validate({
            //  errorElement: "span",
            errorPlacement: function (error, element) {
                error.insertAfter(element);
            }
        }
        );
        $("#x_card_num").creditCardTypeDetector({"credit_card_logos": ".card_logos"});

        $("#pay_later").click(function () {
            if ($("#pay_later").prop("checked")) {
                $('#payment').hide();
                $('#payment :input').removeClass("text required error");
            } else {
                $('#payment').show();
                $('#payment :input:not(#info,#x_card_type)').addClass("text required");
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
        $('.reference').each(function (item, value) {
            $(this).rules("add", {
                // minlength: 2
                check_reference: true


            });
        });
    });

</script>
<style type="text/css">
    #choose1{
        display: none;
    }
</style>
<head>
    <title>Reverse Trade Show</title>
</head>
<div class="col-group main-page">
    <article>
        <div class="moduletable">	
            <section id="contact">

             <!--   <img src="images/logo.png" alt="Logo Pepmobile" style="display: block;margin-left: auto; margin-right: auto"/>-->
                <h2 align="center">
                    <abbr title="HyperText Markup Language">14th Annual Industrial Reverse Trade Show</abbr><br>
                    <abbr title="HyperText Markup Language">Thursday, October 16, 2014</abbr><br>
                    <abbr title="HyperText Markup Language">VIP Early Admission 12:00 – 1:00</abbr><br>
                    <abbr title="HyperText Markup Language">General Admission 1:00 – 4:30</abbr><br>
                    <abbr title="HyperText Markup Language">Fort Whiting Armory - Mobile, Alabama</abbr><br>
                    <abbr title="HyperText Markup Language">1630 S. Broad Street 36605</abbr>					

                </h2>

                <mark id="message"></mark>
                <div id="login-popup">
                    <i><?php echo JHTML::_('content.prepare', '{loadposition reventpay}'); ?></i>
                    <br/>
                </div>
                <div style="text-align:center">
                    Fill out the form below to purchase non-member tickets
                </div>
                <form method="post" action="" name="form2" id="checkout_form">            
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
                            <input name="company" type="text" id="company" size="30"class="text required" />
                        </div>
                        <div>
                            <label for="address1">Address</label>
                            <input name="address1" type="text" id="address1" size="30" class="text required"/>
                        </div>
                        <div>
                            <label for="phone1">Phone</label>
                            <input name="phone1" type="text" id="phone1" size="30" class="text required"/>
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
                    </fieldset>				

                   <?php if(count($this->bussniess_categories)):?>
                    <fieldset>

                        <legend>Business Category</legend>
                        <div>
                            By selecting one of the following categories, your name, company name and phone number will be listed under selected category in our Trade Show publication in the Product & Service Provider Directory.

                        </div>
                        <div class="bc">
                            <ul>
                                <?php foreach ($this->bussniess_categories as $business): ?>
                                    <li><label ><?php echo $business->name ?></label><input type="radio" value="<?php echo $business->name ?>" name="pay" class="required" ></li>
                                <?php endforeach; ?>

                                <li><label>I do not wish to appear in the Directory</label><input type="radio" value="Others" name="pay"/>	</li>

                            </ul>
                        </div>

                    </fieldset>
                    <?php endif;?>
                    <fieldset>
                        <div>
                            Let us know how you heard about the show
                        </div>
                        <div class="bc">
                            <ul>
                                <li><label>Billboard</label><input type="checkbox" value="Billboard" name="reference[billboard]" class="reference" />	</li>
                                <li><label>Radio</label><input type="checkbox" value="Radio" name="reference[radio]" class="reference" />	</li>
                                <li><label>Email</label><input type="checkbox" value="Email" name="reference[email]" class="reference" />	</li>
                                <li><label>Postal Mailing</label><input type="checkbox" value="Postal Mailing" name="reference[postal_mailing]" class="reference" />	</li>
                                <li><label>Friend/Colleague</label><input type="checkbox" value="Friend/Colleague" name="reference[friend_or_colleague]" class="reference" />	</li>
                                <li><label>PEP Member referral</label><input type="checkbox" value="PEP Member" name="reference[pep_member]" class="reference" />	</li>
                                <li><label>Other</label><input type="text" name="reference[other]" class="reference" id="reference_other"/>	</li>
                            </ul>
                        </div>
                    </fieldset>

                    <fieldset>

                        <legend>Purchase Tickets</legend>
                        <?php
                        $num = 1;
                        for ($num; $num <= 10; $num++) {
                            $nums[] = $num;
                        }
                        $config = JFactory::getConfig();
                        ?>
                        <input name="non-member-price" id="non-member-price" type="hidden" value="<?php echo $config->get("non_member_price"); ?>"/>
                        <div id="choose2">
                            <div id="sele2">
                                <label># of Non-Member<span class="icon-user"></span>:</label>
                                <select name="options2" id="persons2" >	
                                    <?php
                                    foreach ($nums as $number) :
                                        ?>
                                        <option data-value='<?php echo $number; ?>' value='<?php echo $number; ?>' name='non-mem' <?php
                                        if ($number == 1) {
                                            echo "select=selected";
                                        }
                                        ?>><?php echo $number; ?></option>		 

                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div>
                                <label for="costs2">Price</label>							
                                <input  name="amount2" type="text" id="costs2" readonly="readonly" value="" />
                            </div>

                            <div id="addinput2">

                            </div>
                            <div>
                                <label for="costs2">Total:</label>							
                                <input name="x_amount" type="text" id="total" readonly="readonly" value="" />
                            </div>
                        </div>
                    </fieldset> 
                    <!--                    <fieldset>
                                            <div>
                                                <label for="pay_later" accesskey="">Pay later</label>
                                                <input  name="pay_later" type="checkbox" id="pay_later" value="1"/>
                                            </div>
                                        </fieldset>-->
                    <fieldset>
                        <div id ="payment">
                            <legend>Credit/Debit Card</legend>
                            <div>
                                <label for="info">Billing information is same as registration information</label>
                                <input  name="info" type="checkbox" id="info" />
                            </div>
                            <div>
                                <label for="name" accesskey="U">First Name</label>
                                <input class="text required" name="x_first_name" type="text" id="x_first_name" />
                            </div>

                            <div>
                                <label for="name" accesskey="U">Last Name</label>
                                <input type="text" class="text required" name="x_last_name"></input>
                            </div>

                            <div>
                                <label for="email" accesskey="E">Email</label>
                                <input  name="x_email" type="text" id="email"  class="text required email"/>
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
                                <label for="zip" accesskey="">Zip</label>
                                <input class="text required" name="x_zip" type="text" id="zip" />
                            </div>

                            <div>
                                <label for="cardnumber" accesskey="">Card Number</label>
                                <input type="text" class="text required creditcard" size="16" name="x_card_num" id="x_card_num" autocomplete="off"></input>
                            </div>
                            <div style="text-align: center">
                                <ul class="card_logos">
                                    <li class="card_visa">Visa</li>
                                    <li class="card_mastercard">Mastercard</li>
                                    <li class="card_amex">American Express</li>
                                    <li class="card_discover">Discover</li>
                                    <!-- <li class="card_jcb">JCB</li>
                                     <li class="card_diners">Diners Club</li>-->
                                </ul>
                                <input type="hidden" name="x_card_type" id="x_card_type"/>
                            </div>
                            <div>
                                <label for="exp" accesskey="">Expiration Date</label>
                                <input class="text required" name="x_exp_date" type="text" id="dmy" maxlength="5"  /><i> Format (MM/YY)</i>
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
                    $jResponse = $app->triggerEvent('activeReversePayment');
                    if ($jResponse[0] == "true") {
                        echo '	<input type="submit" class="submit buy" value="Purchase">';
                    } else {
                        echo '	<input type="button" readonly="readonly" class="submit_lock buy" value="Purchase">';
                    }
                    ?>
                    <?php echo JHtml::_('form.token'); ?>
                    <input type="hidden"  name="nameofpayment" value="Reverse Trade" />	
                    <input type="hidden" name="option" value="com_payment" />
                    <input type="hidden" name="task" value="payment2s.submit" />
                </form>			
            </section>
        </div>
    </article>
</div>


