<div id="dvContainer">
    <fieldset id="order">

        <legend><h3>Detail</h3></legend>
        <p><strong>Order Information </strong></p>
        <br/>
        <p>Customer</p>
        <hr/>
        <table width="100%">
            <tr>
                <td width="60%">First Name:</td>
                <td>{$data->first_name }</td>
            </tr>
            <tr>
                <td>Last Name:</td>
                <td>{$data->last_name }</td>
            </tr>
            <tr>
                <td>Company:</td>
                <td>{$data->company }</td>
            </tr>
            <tr>
                <td>Address:</td>
                <td>{$data->address }</td>
            </tr>
            <tr>
                <td>Phone:</td>
                <td>{$data->phone }</td>
            </tr>
            <tr>
                <td>City:</td>
                <td>{$data->city }</td>
            </tr>
            <tr>
                <td>Zip:</td>
                <td>{$data->zip }</td>
            </tr>
            <tr>
                <td>Email:</td>
                <td>{$data->email }</td>
            </tr>
        </table>
        <br/>
        <p>Order</p>
        <hr/>
        <table width="100%">
            <tr>
                <td width="60%">Order Number:</td>
                <td>{$data->id }</td>
            </tr>
            <tr>
                <td width="60%">Order Date:</td>
                <td>{$data->order_date|date_format:"%D" }</td>
            </tr>
          {if $data->transaction_id }


            <tr>
                <td width="60%">Transaction Number:</td>
                <td>{$data->transaction_id }</td>
            </tr>

            <tr>
                <td width="60%">Transaction Date:</td>
                <td>{$data->transaction_date|date_format:"%D"}</td>
            </tr>
             {/if}
            <tr>
                <td width="60%">Category:</td>
                <td>{$data->category }</td>
            </tr>
            <tr>
                <td>Number Of Member:</td>
                <td>{$members|@count }</td>
            </tr>

            <tr>
                <td>Total:</td>
                <td>${$data->total|number_format:2:".":","}</td>
            </tr>
        </table>
        <br/>
        Payment
        <hr/>
        <table width="100%">
            <tr>
                <td width="60%">Payment Status:</td>
                <td>{$data->payment_status }</td>
            </tr>
            {if $data->transaction_id }


            <tr>
                <td width="60%">CC Number:</td>
                <td>{$data->cc_number }</td>
            </tr>
            <tr>
                <td width="60%">CC Type:</td>
                <td>{$data->cc_card_type }</td>
            </tr>
            {/if}
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
            {foreach $members as $member} {assign var=item value=":"|explode:$member}
                <tr> 
                    <td>{$item[0] }</td>
                    <td>{$item[1] }</td>
                </tr>
            {/foreach}

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
            {foreach  $non_members as $member}{assign var=item value=":"|explode:$member}
                <tr> 
                    <td>{$item[0] }</td>
                    <td>{$item[1] }</td>
                </tr>
            {/foreach}
        </table>
    </fieldset>
</div>