<head>
<title>Charleston Lighting Catalog Request</title>
</head>
<b>Charleston Lighting Catalog Request</b>
<p>Please send me a Charleston Lighting Catalog.</p>
<p style="color: #999999"><b>*</b> = required field</p>

<form method="post" action="send_request.php">
  <INPUT TYPE="HIDDEN" NAME="recipient" VALUE="swoods@charlestonlighting.com">
  <INPUT TYPE="HIDDEN" NAME="subject" VALUE="Charleston Lighting Catalog Request">
  <INPUT TYPE="HIDDEN" NAME="required" VALUE="email,address1,city,state,zip">

<span class="secondary2">
<table border="0" cellpadding="4" cellspacing="4" width="500">
<tr>
<td align="right" valign="top"><font color="#999999"><b>*</b></font>
Name:
</td>
<td valign="top"><input type="text" size="28" name="name"></td>
</tr>
<tr>
<td align="right" valign="top">Title:</td>
<td valign="top"><input type="text" size="28" name="title"></td>
</tr>
<tr>
<td align="right" valign="top">Company:</td>
<td valign="top"><input type="text" size="28" name="company"></td>
</tr>
<tr> 
<td align="right" valign="top"><font color="#999999"><b>*</b></font>
Address:</td> 
<td valign="top"><input type="text" size="28" name="address1">
<br>
<input type="text" size="28" name="address2"></td> 
</tr> 
<tr> 
<td align="right" valign="top"><font color="#999999"><b>*</b></font>
City:</td>
<td valign=top><input type="text" size="28" name="city"></td>
</tr>
<tr>
<td align="right" valign="top"><font color="#999999"><b>*</b></font>
State/Province:</td>
<td valign=top><input type="text" size="28" name="state"></td>
</tr>
<tr>
<td align="right" valign="top"><font color="#999999"><b>*</b></font>
Zip/Postal Code:</td>
<td valign="top"><input type="text" size="28" name="zip"></td>
</tr>
<tr>
<td align="right" valign="top">Country:</td>
<td valign="top"><input type="text" size="28" name="country"></td>
</tr>
<tr>
<td align="right" valign="top"><font color="#999999"><b>*</b></font>Email:</td>
<td valign="top"><input type="text" size="28" name="email"></td>
</tr>
<tr>
<td align="center" valign="top" colspan=2><img id="captcha" src="/securimage/securimage_show.php" alt="CAPTCHA Image" />
<a href="#" onclick="document.getElementById('captcha').src = '/securimage/securimage_show.php?' + Math.random(); return false">Reload Image</a>
</td>
<tr>
<td align="right" valign="top"><font color="#999999"><b>*</b></font>Enter Code Above:</td>
<td valign="top"><input type="text" name="captcha_code" size="10" maxlength="6" /></td>
</tr>
<td>&nbsp;</td>
<td valign="top">
<center>
<input type="submit" value="Submit Request">
</center>
</td>
</tr>
</table>
</span>
</form>
