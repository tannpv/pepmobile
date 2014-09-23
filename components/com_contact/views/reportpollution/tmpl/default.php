<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

if($_REQUEST['t']){
    echo "<h2><p style ='color:blue;text-align:center;'>Thank you for your email.</p></h2>";
}
?>
<style type="text/css">
    label.error { float: none; color: red; padding-left: .5em; vertical-align: top; }
    em { font-weight: bold; padding-right: 1em; vertical-align: top; color: red; }
</style>
<script>
    $(document).ready(function(){
        $("#contact-form").validate();
    });
</script>
<h2>
    Report Pollution
</h2>
<br />
<form name="contact-form" id="contact-form" method="POST" action="<?php echo JRoute::_('index.php'); ?>" enctype="multipart/form-data">
    <table cellspacing="0" cellpadding="1" border="0" width="566">
        <tbody> 
            <tr> 
                <td> 
                    <div align="right"><b class="bodyblue"><label for="content">Describe your pollution concern</label></b></div>
                </td>
                <td><textarea  rows="10" cols="50" id="content" name="jform[content]" aria-required="true" ></textarea></td>
            </tr>
            <tr> 
                <td><div align="right"><b class="bodyblue"><span class="bodyblue">Add a Photo</span></b></div></td>
                <td><input type="file" name="attachFile" id="attachFile" class="inputbox" value="" /></td>
            </tr>
            <tr> 
                <td><div align="right"><b class="bodyblue">City : </b></div></td>
                <td> 
                    <input type="text" size="50" value="" name="jform[city]"></td>
            </tr>
            <tr> 
                <td><div align="right"><b class="bodyblue"><label for="name">Your Name :</label></b></div></td>
                <td> 
                    <input class="required"  type="text" size="30" value="" name="jform[name]" id ="name" /><em>*</em> 
                </td>
            </tr>
            <tr> 
                <td><div align="right"><b class="bodyblue"><label for="email">Your Email :</label></b></div></td>
                <td>
                    <input class="required email" type="text" size="30" value="" name="jform[email]" id="email" /><em>*</em> 
                </td>
            </tr>
            <tr>
                <td><div align="right"><b class="bodyblue">Send me a copy</b></div></td>
                <td>
                    <input type="checkbox" value="1" id="email_copy" name="jform[email_copy]" class="" aria-invalid="false" />
                </td>
            </tr>
            <tr>
                <td align="center" colspan="2">
                    <button class="button validate" type="submit"><?php echo JText::_('Submit'); ?></button>
                    <input class="button validate" type="reset" value="Reset"> 
                    <input type="hidden" name="option" value="com_contact" />
                    <input type="hidden" name="task" value="contact.submitreport" />
                    <?php echo JHtml::_('form.token'); ?>
                </td>
            </tr>
        </tbody> 
    </table>
</form>
