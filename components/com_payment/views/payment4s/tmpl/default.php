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
$config = JFactory::getConfig();
?>
<script type="text/javascript">
    function deleteItem(item_id) {
        if (confirm("<?php echo JText::_('COM_PAYMENT_DELETE_MESSAGE'); ?>")) {
            document.getElementById('form-customer-delete-' + item_id).submit();
        }
    }
</script>
<script type="text/javascript">
    function setPaymentSection() {
        if ($("#pay_later").prop("checked")) {
            $('#payment').hide();
            disableNonMemSelection();
            $('#payment :input').removeClass("text required error");
        } else {
            $('#payment').show();
            enableNonMemSelection();
            $("#costs2").removeClass("text required error");
            $('#payment :input:not(#pay_later,#info,#x_card_type)').addClass("text required");
        }

    }
    $(document).ready(function() {
        $('input').blur(function() {
           
            var value = $.trim($(this).val());
            $(this).val(value);
        });


        $("#checkout_form").submit(function(event) {
            $('input').each(function() {
                var value = $.trim($(this).val());
                $(this).val(value);
            })
            $('#x_card_num').trigger("keyup", function() {
            });
        });

        setPaymentSection();
        $("#pay_later").click(function() {
            setPaymentSection();
        });

        $("input[name=info]").change(function() {
            if (this.checked) {
                $("input[name=x_first_name]").val($("input[name=firstname1]").val());
                $("input[name=x_last_name]").val($("input[name=lastname1]").val());
                $("input[name=x_address]").val($("input[name=address1]").val());
                $("input[name=x_city]").val($("input[name=city1]").val());
                $("input[name=x_state]").val($("input[name=state1]").val());
                $("input[name=x_zip]").val($("input[name=zip1]").val());
                $("#email").val($("#email1").val());
            } else {
                $("input[name=x_first_name]").val("");
                $("input[name=x_last_name]").val("");
                $("input[name=x_address]").val("");
                $("input[name=x_city]").val("");
                $("input[name=x_state]").val("");
                $("input[name=x_zip]").val("");
                $("#email").val("");
            }
        });
        $("#name").change(function() {
            //  upateCompanyName();
            updateTotal1();
            updateTotal2();
        });
        $("#company").change(function() {
            updateTotal1();
            updateTotal2();
        });
        $("select[name=options1]").change(function() {
            $("#addinput1").empty();
            updateTotal1();
            //sum total
            calTotal();
        });
        $("select[name=options2]").change(function() {
            $("#addinput2").empty();
            updateTotal2();
            calTotal();
        });
        updateTotal1();
        updateTotal2();
        $.validator.addMethod("checkSelected",
                function(value, element) {
                    if ($("#persons1  option:selected").val() == 0 && $("#persons2  option:selected").val() == 0) {
                        return false;
                    }
                    else {
                        return true;
                    }
                }, "* You have to select a member or a non member!");
        $("#checkout_form").validate({
            rules: {
                options1: {checkSelected: true},
                options2: {checkSelected: true}

            }
        });

        calTotal();
    });
    function calTotal() {
        var cost1 = parseInt($('#costs1').val());
        var cost2 = parseInt($('#costs2').val());
        var result = cost1 + cost2;
        $("#total").val(result);
    }
    function disableNonMemSelection() {
        $("#persons2").val(0);
        $("#persons2").trigger("change");
        calTotal();
        $("#costs2").prop('disabled', true);
        $("#persons2").prop('disabled', true);
    }
    function enableNonMemSelection() {
        $("#persons2").prop('disabled', false);
        $("#costs2").prop('disabled', false);
    }
    //for member
    function updateTotal1() {
        var newTotal4add_field = 0;
        var newTotal1 = 0;
        var price = $('#member-price').val();
        $("select[name=options1] option:selected").each(function() {
            newTotal4add_field = parseFloat($(this).data("value"));
            newTotal1 = parseFloat($(this).data("value")) * price;
        });
        $("#costs1").val(newTotal1);
        var startingNo = newTotal4add_field;
        var $node = "";
        for (varCount = 1; varCount <= startingNo; varCount++) {
            var displayCount = varCount;
            $node += '<p><label for="pers' + displayCount + '">' + displayCount + ' : Name : </label><input type="text" class ="text required" name="member[' + displayCount + '][name]" id="num' + displayCount + '"><label for="pers_company' + displayCount + '">Company: </label><input type="text" class ="text required" name="member[' + displayCount + '][company]" id="mem_company' + displayCount + '"></p>';
            //remove a textfield
            $('#addinput1').on('click', '.removeVar', function() {
                $(this).parent().remove();
            });
        }
        // add them to the DOM
        $('#addinput1').append($node);
    }
//for non-member
    function updateTotal2() {
        var newTotal4add_field = 0;
        var newTotal2 = 0;
        var price = $('#non-member-price').val();
        $("select[name=options2] option:selected").each(function() {
            newTotal4add_field = parseFloat($(this).data("value"));
            newTotal2 = parseFloat($(this).data("value")) * price;
        });
        $("#costs2").val(newTotal2);
        var startingNo = newTotal4add_field;
        var $node = "";
        for (varCount = 1; varCount <= startingNo; varCount++) {
            var displayCount = varCount;
            $node += '<p><label for="pers' + displayCount + '">' + displayCount + ' : Name : </label><input type="text" class = "text required" class ="text required"name="non_mem[' + displayCount + '][name]" id="non_mem' + displayCount + '"><label for="pers_company' + displayCount + '">Company: </label><input type="text" class = "text required" name="non_mem[' + displayCount + '][company]" id="pers_company' + displayCount + '"></p>';
            //remove a textfield
            $('#addinput2').on('click', '.removeVar', function() {
                $(this).parent().remove();
            });
        }
        // add them to the DOM
        $('#addinput2').append($node);
    }
    function setTotalMember() {
        var total_member = parseInt($("#persons1  option:selected").val()) + parseInt($("#persons2  option:selected").val());
        $("#total_member").val(total_member);
    }
</script>
<style type="text/css">

</style>
<head>
    <title>Member Reverse Trade Show</title>
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
                    <i> <?php echo JHTML::_('content.prepare', '{loadposition reventpay}'); ?></i>
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
<!--                                <li><label>Communication</label><input type="radio" value="Communication" name="pay" class="required"></li>
                    <li><label>Containment Rental/Storage</label><input type="radio" value="Containment Rental/Storage" name="pay"></li>
                    <li><label>Contractors/Construction</label><input type="radio" value="Contractors/Construction" name="pay"></li>
                    <li><label>Education/Training</label><input type="radio" value="Education/Training" name="pay"></li>
                    <li><label>Electric Contractors/Distributors</label><input type="radio" value="Electric Contractors/Distributors" name="pay"></li>
                    <li><label>Emergency Support/Response</label><input type="radio" value="Emergency Support/Response" name="pay"></li>
                    <li><label>Employment Services</label><input type="radio" value="Employment Services" name="pay"></li>
                    <li><label>Energy</label><input type="radio" value="Energy" name="pay"></li>
                    <li><label>Engineering/Consulting</label><input type="radio" value="Engineering/Consulting" name="pay"></li>
                    <li><label>Financial</label><input type="radio" name="pay" value="Financial"></li>
                    <li><label>Hotel/Corporate Housing</label><input type="radio" value="Hotel/Corporate Housing" name="pay"></li>
                    <li><label>Industrial Equip/Supplies/Svcs</label><input type="radio" value="Industrial Equip/Supplies/Svcs" name="pay"></li>
                    <li><label>Industrial Healthcare</label><input type="radio" value="Industrial Healthcare" name="pay"></li>
                    <li><label>Insurance/Claims Services</label><input type="radio" value="Insurance/Claims Services" name="pay"></li>
                    <li><label>Laboratories/Testing</label><input type="radio" value="Laboratories/Testing" name="pay"></li>
                    <li><label>Legal</label><input type="radio" value="Legal" name="pay"></li>
                    <li><label>Marine Services/Supply</label><input type="radio" value="Marine Services/Supply" name="pay"></li>
                    <li><label>Oil Reclamation/Wastes</label><input type="radio" value="Oil Reclamation/Wastes" name="pay"></li>
                    <li><label>Office Equipment/Supplies</label><input type="radio" value="Office Equipment/Supplies" name="pay"></li>
                    <li><label>Public Relations/Marketing</label><input type="radio" value="Public Relations/Marketing" name="pay"></li>
                    <li><label>Pumps/Valves/Welding</label><input type="radio" value="Pumps/Valves/Welding" name="pay"></li>
                    <li><label>Safety Equip/Supplies/Training</label><input type="radio" value="Safety Equip/Supplies/Training" name="pay"></li>
                    <li><label>Trucking/Hauling/Transportation</label><input type="radio" value="Trucking/Hauling/Transportation" name="pay"> </li>-->
                                <li><label>I do not wish to appear in the Directory</label><input type="radio" value="Others" name="pay"/>		</li>

                            </ul>
                        </div>

                    </fieldset>

                    <fieldset>

                        <legend>Purchase Tickets</legend>
                        <i><strong>*</strong>NOTE: you can select <strong>Member</strong> or <strong>Non-Member</strong> for  Payment</i>
                        <div>
                            Please pay non-member rate for non-member tickets purchased. 
                        </div>
                        <div>
                            <label for="pay_later" accesskey="">Pay later</label>
                            <input  name="pay_later" type="checkbox" id="pay_later" value="1"/>
                        </div>
                        <div id="choose1">
                            <input name="member-price" id="member-price" type="hidden" value="<?php echo $config->get("member_price"); ?>"/>

                            <div id="sele2">
                                <label for ="persons1"># of Member <span class="icon-user"></span>:</label>

                                <select name="options1" id="persons1" class ="member-group"<?php echo $this->specialprices; ?>>
                                    <?php
                                    $num = 0;
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

                            <div>
                                <label for="costs1">Price</label>
                                <input class="text" name="amount1" type="text" id="costs1" readonly="readonly" value="" />
                            </div>

                            <div id="addinput1">

                            </div>
                        </div>

                        <div id="choose2">



                            <div id="sele2">
                                <input name="non-member-price" id="non-member-price" type="hidden" value="<?php echo $config->get("non_member_price"); ?>"/>
                                <label for ="persons2"># of Non-Member<span class="icon-user"></span>:</label>
                                <select name="options2" id="persons2" class ="member-group">
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
                                <input class="text required" name="amount2" type="text" id="costs2" readonly="readonly" value="" />
                            </div>

                            <div id="addinput2">

                            </div>
                            <div>
                                <label for="total">Total:</label>
                                <input type="hidden" name="total_member" id="total_member"/>
                                <input class="text required" name="x_amount" type="text" id="total" readonly="readonly" value="" />
                            </div>
                        </div>
                    </fieldset>

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
                                                                      <!--       <li class="card_jcb">JCB</li>
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
//  var_dump($jResponse);
                    if ($jResponse[0] == "true") {
                        echo '<input type="submit" class="submit buy" value="Purchase">';
                    } else {
                        echo '<input type="button" readonly="readonly" class="submit_lock buy" value="Purchase">';
                    }
                    ?>
<?php echo JHtml::_('form.token'); ?>
                    <input type="hidden"  name="nameofpayment" value="Reverse Trade" />
                    <input type="hidden" name="option" value="com_payment" />
                    <input type="hidden" name="task" value="payment4s.submit" />
                </form>
            </section>
        </div>
    </article>
</div>


