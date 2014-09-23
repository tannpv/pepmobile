<?php
// no direct access
defined('_JEXEC') or die('Restricted access');


$Falink = $params->get('Falink');
$Lilink = $params->get('Lilink');
$Address = $params->get('Address');
$Tel = $params->get('Tel');
$Email = $params->get('Mail');

?>
<script>
function newPopup(url) {
	popupWindow = window.open(
		url,'popUpWindow','height=600,width=600,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes')
}
</script>

<dl>
<dd class="fb"><a href="JavaScript:newPopup(<?php echo "'http://".$Falink."'"; ?>)"></a></dd>
<dd class="tw"><a href="JavaScript:newPopup(<?php echo "'https://twitter.com/PEPMobile'"; ?>)"></a></dd>
<dd class="lin"><a href="JavaScript:newPopup(<?php echo "'http://".$Lilink."'"; ?>)"></a></dd>
<dd><?php echo $Address; ?></dd>
<dd><?php echo $Tel; ?></dd>
<dd><div id="mail"><a href="mailto:<?php echo $Email; ?>?subject=Contact&body=Hello"><?php echo $Email; ?></a></div></dd>
</dl>
