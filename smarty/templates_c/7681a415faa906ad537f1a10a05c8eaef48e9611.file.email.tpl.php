<?php /* Smarty version Smarty-3.1.19, created on 2014-08-18 05:06:27
         compiled from "E:\xampp\htdocs\pepmobile.local\htdocs\smarty\templates\email.tpl" */ ?>
<?php /*%%SmartyHeaderCode:870853decee37a6049-64200752%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7681a415faa906ad537f1a10a05c8eaef48e9611' => 
    array (
      0 => 'E:\\xampp\\htdocs\\pepmobile.local\\htdocs\\smarty\\templates\\email.tpl',
      1 => 1407379794,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '870853decee37a6049-64200752',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_53decee37c3609_99465062',
  'variables' => 
  array (
    'data' => 0,
    'members' => 0,
    'member' => 0,
    'item' => 0,
    'non_members' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53decee37c3609_99465062')) {function content_53decee37c3609_99465062($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'E:\\xampp\\htdocs\\pepmobile.local\\htdocs\\libraries\\Smarty\\plugins\\modifier.date_format.php';
?><div id="dvContainer">
    <fieldset id="order">

        <legend><h3>Detail</h3></legend>
        <p><strong>Order Information </strong></p>
        <br/>
        <p>Customer</p>
        <hr/>
        <table width="100%">
            <tr>
                <td width="60%">First Name:</td>
                <td><?php echo $_smarty_tpl->tpl_vars['data']->value->first_name;?>
</td>
            </tr>
            <tr>
                <td>Last Name:</td>
                <td><?php echo $_smarty_tpl->tpl_vars['data']->value->last_name;?>
</td>
            </tr>
            <tr>
                <td>Company:</td>
                <td><?php echo $_smarty_tpl->tpl_vars['data']->value->company;?>
</td>
            </tr>
            <tr>
                <td>Address:</td>
                <td><?php echo $_smarty_tpl->tpl_vars['data']->value->address;?>
</td>
            </tr>
            <tr>
                <td>Phone:</td>
                <td><?php echo $_smarty_tpl->tpl_vars['data']->value->phone;?>
</td>
            </tr>
            <tr>
                <td>City:</td>
                <td><?php echo $_smarty_tpl->tpl_vars['data']->value->city;?>
</td>
            </tr>
            <tr>
                <td>Zip:</td>
                <td><?php echo $_smarty_tpl->tpl_vars['data']->value->zip;?>
</td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><?php echo $_smarty_tpl->tpl_vars['data']->value->email;?>
</td>
            </tr>
        </table>
        <br/>
        <p>Order</p>
        <hr/>
        <table width="100%">
            <tr>
                <td width="60%">Order Number:</td>
                <td><?php echo $_smarty_tpl->tpl_vars['data']->value->id;?>
</td>
            </tr>
            <tr>
                <td width="60%">Order Date:</td>
                <td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['data']->value->order_date,"%D");?>
</td>
            </tr>
          <?php if ($_smarty_tpl->tpl_vars['data']->value->transaction_id) {?>


            <tr>
                <td width="60%">Transaction Number:</td>
                <td><?php echo $_smarty_tpl->tpl_vars['data']->value->transaction_id;?>
</td>
            </tr>

            <tr>
                <td width="60%">Transaction Date:</td>
                <td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['data']->value->transaction_date,"%D");?>
</td>
            </tr>
             <?php }?>
            <tr>
                <td width="60%">Category:</td>
                <td><?php echo $_smarty_tpl->tpl_vars['data']->value->category;?>
</td>
            </tr>
            <tr>
                <td>Number Of Member:</td>
                <td><?php echo count($_smarty_tpl->tpl_vars['members']->value);?>
</td>
            </tr>

            <tr>
                <td>Total:</td>
                <td>$<?php echo number_format($_smarty_tpl->tpl_vars['data']->value->total,2,".",",");?>
</td>
            </tr>
        </table>
        <br/>
        Payment
        <hr/>
        <table width="100%">
            <tr>
                <td width="60%">Payment Status:</td>
                <td><?php echo $_smarty_tpl->tpl_vars['data']->value->payment_status;?>
</td>
            </tr>
            <?php if ($_smarty_tpl->tpl_vars['data']->value->transaction_id) {?>


            <tr>
                <td width="60%">CC Number:</td>
                <td><?php echo $_smarty_tpl->tpl_vars['data']->value->cc_number;?>
</td>
            </tr>
            <tr>
                <td width="60%">CC Type:</td>
                <td><?php echo $_smarty_tpl->tpl_vars['data']->value->cc_card_type;?>
</td>
            </tr>
            <?php }?>
        </table>
        <br/>
        <br/>
        <p>Members </p>
        <hr/>

        <table width="100%">
            <tr>
                <td width="60%"><strong>Name</strong></td>
                <td><strong>Company</strong></td>
            </tr>
            <?php  $_smarty_tpl->tpl_vars['member'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['member']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['members']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['member']->key => $_smarty_tpl->tpl_vars['member']->value) {
$_smarty_tpl->tpl_vars['member']->_loop = true;
?> <?php $_smarty_tpl->tpl_vars['item'] = new Smarty_variable(explode(":",$_smarty_tpl->tpl_vars['member']->value), null, 0);?>
                <tr> 
                    <td><?php echo $_smarty_tpl->tpl_vars['item']->value[0];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['item']->value[1];?>
</td>
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
            <?php  $_smarty_tpl->tpl_vars['member'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['member']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['non_members']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['member']->key => $_smarty_tpl->tpl_vars['member']->value) {
$_smarty_tpl->tpl_vars['member']->_loop = true;
?><?php $_smarty_tpl->tpl_vars['item'] = new Smarty_variable(explode(":",$_smarty_tpl->tpl_vars['member']->value), null, 0);?>
                <tr> 
                    <td><?php echo $_smarty_tpl->tpl_vars['item']->value[0];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['item']->value[1];?>
</td>
                </tr>
            <?php } ?>
        </table>
    </fieldset>
</div><?php }} ?>
