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

<div class="col-group main-page">
    <article>
        <div class="moduletable">
            <section id="contact">



                <mark id="message"></mark>

                <form method="get" action="index.php"  name="form1" id="checkout_form">            

                    <fieldset>

                        <legend><h3><font color ="red">Error</font></h3></legend>
                        <b>  Your transaction has an error! Response Code:</b> &nbsp <i><strong><?php echo htmlentities($_GET['response_reason_code']) ?></strong></i>
                        <p>Message: <?php echo htmlentities($_GET['response_reason_text']) ?></p>

                    </fieldset>
                
                </form>



            </section>
        </div>
    </article>
</div>