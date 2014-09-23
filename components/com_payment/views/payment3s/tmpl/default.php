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
jimport( 'joomla.html.html.image' );
?>

<div class="col-group main-page">
<article>
<div class="moduletable">
        <section id="contact">

            <!--    <img src="images/logo.png" alt="Logo Pepmobile" style="display: block;margin-left: auto; margin-right: auto"/>-->
                <h2 align="center">
                    <abbr title="HyperText Markup Language">Golf Tournament</abbr><br>
                </h2>

            <mark id="message"></mark>
				
            <form method="post" action="" id="checkout_form">            

                <fieldset>
                    
                    <legend>Contact Details</legend>

                    <div>
                        <label for="name" accesskey="U">Name</label>
                        <input name="name" type="text" id="name" />
                    </div>
                    <div>
                        <label for="address" accesskey="">Address</label>
                        <input class="text required" name="address" type="text" id="address" />
                    </div>

                    <div>
                        <label for="city" accesskey="">City</label>
                        <input class="text required" name="city" type="text" />
                    </div>

                    <div>
                        <label for="state" accesskey="">State</label>
                        <input class="text required" name="state" type="text" id="state" />
                    </div>

                    <div>
                        <label for="zip" accesskey="">Zip</label>
                        <input class="text required" name="zip" type="text" id="zip" />
                    </div>

                    <div>
                        <label for="country" accesskey="">Country</label>
                        <input class="text required" name="country" type="text" id="country" />
                    </div>

                    <div>
                        <label for="email" accesskey="E">Email</label>
                        <input  name="x_email" type="email" id="email" pattern="^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})$" required="required"/>
                    </div>

                    <div>
                        <label for="phone" accesskey="P">Phone</label>
                        <input  name="phone" type="tel" id="phone" size="30" />
                    </div>

                    <div>
                        <label for="company">Company <small>(optional)</small></label>
                        <input name="company" type="text" id="company" size="30" />
                    </div>

                    <div>
                        <label for="website" accesskey="W">Website <small>(optional)</small></label>
                        <input name="website" type="url" id="website" />
                    </div>

                </fieldset>

                <fieldset>

                    <legend>Purchase Tickets</legend>

                    <div>
                    
						<div id="sele">
							<label># of People:</label>
								<select name="options" id="persons">	
									 <?php 
									 $num = 1;
									 for ($num;$num<=10;$num++){
											 $nums[] = $num;
										 }				
									 foreach ($nums as $number) :
									 ?>
										<option data-value='<?php echo $number; ?>' value='person' <?php if($number ==1){ echo "select=selected"; } ?>><?php echo $number; ?></option>		 
										 
									<?php endforeach; ?>
								</select>
						</div>
						<!--<div>
                            <label for="person2price">Person:</label>
                            <input class="text required" name="person2price" type="text" id="person2price" />
                        </div>-->
                        <div>
                            <label for="costs">Total</label>
                            <input class="text required" name="x_amount" type="text" id="costs" disabled />
                        </div>
						

						<div id="addinput">
							
                        </div>

                        <div class="p1">
                            <p class="subp1">
                                If paying by <b>CHECK</b>, mail invoice and check to the PEP office.<br><br>
                                If paying with a <b>CREDIT CARD</b>, email, mail or fax invoice with your credit card information filled in<br><br>
                            </p>
                            <p class="zoom"><b>Cancellations after 2 p.m. the day prior to the breakfast will be billed.</b></p>
                        </div>
                        <p>
                            Partners for Environmental Progress (PEP)<br>
                            754 Downtowner Loop West<br>
                            Mobile, AL  36609<br>
                            Phone: 345-7269    Fax:  342-5575<br>
                            sguntharp@pepmobile.org
                        </p>
                        <p>
                            Partners for Environmental Progress, Inc. is designated by the IRS as a 501(c)(6) organization. Taxpayer ID Number:  63-1250537
                        </p>

                    </div>

                </fieldset>

               <!-- <fieldset>

                    <legend>Biiling</legend>

                    <p>Credit card billing address the same as above?</p>
                    <input type="radio" name="bill" id="asb" value="asb">:As Billing above<br>
                    <input type="radio" name="bill" id="dfb" value="dfb" checked>:Different Billing

                </fieldset> -->
                <fieldset>

                    <legend>Credit/Debit Card</legend>                    

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
                        <input class="text required" name="x-city" type="text" />
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
                        <input type="text" class="text required creditcard" size="16" name="x_card_num" ></input>
                    </div>

                    <div>
                        <label for="exp" accesskey="">Expiration Date</label>
                        <input class="text required" name="x_exp_date" type="text" id="dmy" maxlength="5"/>
                    </div>

                    <div>
                        <label for="security" accesskey="">Security Code (3-4 digits)</label>
                        <input class="text required" name="x_card_code" type="text" id="security" maxlength="4"/>
                    </div>                   
					<img class="logocredit" src="<?php echo JRoute::_($this->baseurl.'components/com_payment/assets/creditcardlogos.jpg' );?>" alt="logo card" height="40" width="120" />
					<?php// echo $_image   = JHTML::_('image.site', 'creditcardlogos.jpg',DS.'components'.DS.'com_payment'.DS.'assets'.DS,NULL,NULL,'share','width="64" height="18" border="0"'); ?>
                </fieldset>


				 <?php     
                 jimport('joomla.plugin.helper');
            		JPluginHelper::importPlugin('content');
            		$app = JFactory::getApplication();
            		$jResponse = $app->triggerEvent('activeGolfPayment');
                   // var_dump($jResponse[0]);
                      if($jResponse[0] == "true") {
                        echo '	<input type="submit" class="submit buy" value="Purchase">';
                      }
                      else{
                         echo '	<input type="button" readonly="readonly" class="submit_lock buy" value="Purchase">';
                      }
                    ?>
                    <?php echo JHtml::_('form.token'); ?>
				<input type="hidden" name="option" value="payment" />
                <input type="hidden" name="task" value="payment1s.submit" />
			 <p>
				*Note: <i>Cancellations after 2p.m. the day prior to the breakfast will be billed.</i>
			</p>
            </form>

        </section>
</div>
</article>
</div>    


