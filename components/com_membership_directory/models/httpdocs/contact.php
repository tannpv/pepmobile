<script src="https://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="jquery.validate.js"></script>

<style type="text/css">
    label.error { float: none; color: red; padding-left: .5em; vertical-align: top; }
    em { font-weight: bold; padding-right: 1em; vertical-align: top; }
</style>
<script>
    $(document).ready(function(){
        $("#commentForm").validate();
    });
</script>
<form class="cmxform" id="commentForm" method="post" action="contact_receive_new.php">
    <table width=768 border=0 cellpadding=0 cellspacing=0>
        <tr valign=top>	
            <td width=40></td>
            <td width=588>
                <br>
                <span class="header">Contact Us - Phone 1-800-661-9224</span><br>
                <br>
                <table border=0 cellpadding=2 cellspacing=0>
                    <tr>
                        <td colspan=2>* - Please fill in these fields</td>
                    </tr>
                    <tr>
                        <td><label for="email">*E-mail Address:</label></td>
                        <td><INPUT  class="required email" TYPE="text" id="email" NAME="email" VALUE="" SIZE=25 MAXLENGTH=50 /></td>
                    </tr>
                    <tr>
                        <td><label for="firstname">*First Name:</label></td>
                        <td><INPUT  class="required"  TYPE="text" id ="firstname" NAME="firstName" VALUE="" SIZE=20 MAXLENGTH=30 /></td>
                    </tr>
                    <tr>
                        <td><label for="lastname">*Last Name:</label></td>
                        <td><INPUT TYPE="text" class="required"  NAME="lastName"  id ="lastname" VALUE="" SIZE=20 MAXLENGTH=30 /></td>
                    </tr>
                    <tr>
                        <td>Company:</td>
                        <td><INPUT TYPE="text" NAME="companyName" VALUE="" SIZE=30 MAXLENGTH=35 ID="Text4"></td>
                    </tr>
                    <tr>
                        <td>Address Line 1:</td>
                        <td><INPUT TYPE="text" NAME="address1" VALUE="" SIZE=30 MAXLENGTH=35 ID="Text5"></td>
                    </tr>
                    <tr>
                        <td>Address Line 2:</td>
                        <td><INPUT TYPE="text" NAME="address2" VALUE="" SIZE=30 MAXLENGTH=35 ID="Text6"></td>
                    </tr>
                    <tr>
                        <td><label for="city">*City:</label></td>
                        <td><INPUT class="required" TYPE="text" NAME="city" VALUE="" SIZE=25 MAXLENGTH=35 ID="city"></td>
                    </tr>
                    <tr>
                        <td><label for="state">*State:</label></td>
                        <td><INPUT class="required"  TYPE="text" NAME="state" VALUE="" SIZE=2 MAXLENGTH=2 ID="state"></td>
                    </tr>
                    <tr>
                        <td><label for ="zip">*Postal Code:</label></td>
                        <td><INPUT class="required" TYPE="text" NAME="zip" VALUE="" SIZE=5 MAXLENGTH=5 ID="zip"></td>
                    </tr>
                    <tr>
                        <td>Country:</td>
                        <td><INPUT TYPE="text" NAME="country" VALUE="U.S." SIZE=20 MAXLENGTH=30 ID="Text10"></td>
                    </tr>
                    <tr>
                        <td><label for="areacode">*Area Code</label>/<label for="telephone">Telephone:</label></td>
                        <td>
                            <INPUT class="required" TYPE="text" NAME="areaCode" VALUE="" SIZE=3 MAXLENGTH=3 ID="areacode">&nbsp;<INPUT class="required" TYPE="text" NAME="telephone" VALUE="" SIZE=8 MAXLENGTH=8 ID="telephone">
                        </td>
                    </tr>
                    <tr>
                        <td>Fax Number:</td>
                        <td>
                            <INPUT TYPE="text" NAME="areaCodeFax" VALUE="" SIZE=3 MAXLENGTH=3 ID="Text13">&nbsp;<INPUT TYPE="text" NAME="fax" VALUE="" SIZE=8 MAXLENGTH=8 ID="Text14">
                        </td>
                    </tr>
                    <tr>
                        <td colspan=2>Comments:<br>
                            <TEXTAREA NAME="comments" ROWS=10 COLS=50 ID="Textarea1"></TEXTAREA>
                        </td>
                    </tr>
                    <tr>
                        <td colspan=2>
                            <INPUT TYPE="reset" ID="Reset1" NAME="Reset1"> &nbsp; <INPUT TYPE="submit" NAME="action" VALUE="submit" ID="Submit1">
                        </td>
                    </tr>
                    <input type="hidden" name="captureIP" value="123.20.139.186">
                </table>					
            </td>
        </tr>
    </table>
</form>