<?php
/**
* TorTags component for Joomla 1.6, Joomla 1.7
* @package TorTags
* @author Tormix Team
* @Copyright Copyright (C) Tormix, www.tormix.com
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/

defined('_JEXEC') or die('Restricted Access');

$imgpath = JURI::root().'/administrator/components/com_tortags/assets/images/';
JHtml::_('behavior.tooltip');
JHtml::_('behavior.modal');

?>
<table width="80%" border="0">
		<tbody><tr>
			<td width="15%">
				<img src="<?php echo $imgpath; ?>development.png">
			</td>
			<td>
				<h1>TorTags for Joomla 1.6 & Joomla 1.7</h1>
				<span class="copyright">(Component for the implementation of the tags in your components)</span>
			</td>
		</tr>
		<tr>
			<td><?php echo JText::_('COM_TORTAGS_VERSION');?>:</td>
			<td>
				<div class="button2-left">
					<div class="blank">
						&nbsp;<?php echo TorTagsHelper::getVersion();?>&nbsp;
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td><?php echo JText::_('COM_TORTAGS_SITE');?>:</td>
			<td>
				<div class="button2-left">
					<div class="blank">
						<a target="_blank" href="http://tormix.com">http://tormix.com</a>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td><?php echo JText::_('COM_TORTAGS_SUPPORT');?>:</td>
			<td>
				<div class="button2-left">
					<div class="blank">
						<a href="mailto:support@tormix.com">support@tormix.com</a>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td><?php echo JText::_('COM_TORTAGS_CHANGELOG');?>:</td>
			<td>
				<div class="button2-left">
					<div class="blank">
						<a class="modal" rel="{handler: 'iframe'}" href="index.php?option=com_tortags&amp;task=history&amp;tmpl=component">
							 TorTags version history
						</a>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td>Say thank you :)</td>
			<td>
				<div id="id">
			<div>
				<img border="0" title="" alt="" src="http://www.webmoney.ru/img/wmkeeper_32x32.png">
				<b>Z173064091186</b>
				</div>
		</div>
		Or just click on a sponsored link below ;)
	<div style="color:#C3C3C3!important;">
		<script type="text/javascript"><!--
			google_ad_client = "ca-pub-3257957540906508";
			/* Second block */
			google_ad_slot = "0991017382";
			google_ad_width = 450;
			google_ad_height = 80;
			//-->
			</script>
			<script type="text/javascript"
			src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
		</script>
		</div>
	</div>
			</td>
		</tr>
	</tbody>
</table>