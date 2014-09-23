<?php
/**
* @package   FaceBook Slider
* @license   http://www.gnu.org/licenses/lgpl.html GNU/LGPL, see LICENSE.php
* Contact to : info@autson.com, autson.com
**/
defined('_JEXEC') or die('Restricted access'); 
$doc =& JFactory::getDocument();

$width=$params->get('width',350);
$height=$params->get('height',400);
//$position=$params->get('position','left');
$click=$params->get('click');
$button=$params->get('button');
$buttont=$params->get('buttont');
$cont_background=$params->get('cont_background');
$border_color=$params->get('border_color');
$show_jquery=$params->get('show_jquery');
$moduleclass_sfx = $params->get('moduleclass_sfx');
$channel_id= $params->get('channel_id');
$stream = $params->get('stream');
$connections = $params->get('connections');
$apikey = $params->get('apikey',118979788166438);
$baseurl = $params->get('baseurl','null');

if($show_jquery=="yes")
{
echo'
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>';
}
/*
if($button=="button1_purple" || $button=="button1_blue" || $button=="button1_black" || $button=="button1_green")
{
$bwidth="30";
$bheight="115";
}
else if ($button=="button2_purple" || $button=="button2_blue" || $button=="button2_black" || $button=="button2_green")
{
$bwidth="30";
$bheight="156";
}
else if ($button=="button3_purple" || $button=="button3_blue" || $button=="button3_black" || $button=="button3_green")
{
$bwidth="50";
$bheight="156";
}
else if ($button=="button4_blue" || $button=="button4_yellow" || $button=="button4_green")
{
$bwidth="83";
$bheight="225";
}
else if ($button=="button5_black" || $button=="button5_blue" || $button=="button5_yellow" || $button=="button5_red")
{
$bwidth="52";
$bheight="140";
}
else if ($button=="button6_64" || $button=="button7_64" || $button=="button8_64" || $button=="button9_64")
{
$bwidth="64";
$bheight="64";
}
else if ($button=="button6_128" || $button=="button7_128" || $button=="button8_128" || $button=="button9_128")
{
$bwidth="128";
$bheight="128";
}
else
{
$bwidth="46";
$bheight="108";
}
*/
/*
$bwidth="45";
$bheight="150";
$button="button";*/
JHTML::stylesheet('fbslider.css','modules/mod_bizkniz_facebook_feed_display/css/');
?>

<style type="text/css">
#fbtbTab .fbtbTabContent {
background: <?php echo $cont_background;?>;
border: 1px solid <?php echo $border_color;?>;
border-left: 0;
-moz-border-radius-bottomright: 6px;
-webkit-border-bottom-right-radius: 6px;
float: left;
padding-right: 0px;
padding-left: 10px;
-webkit-box-shadow: 1px 1px 5px #272727;
-moz-box-shadow: 1px 1px 5px #272727;
box-shadow: 1px 1px 5px #272727;
width: <?php echo $width+10;?>px;
}
#fbtbTab .fbtbTabHandle {
float: left;
width: <?php echo $bwidth;?>px;
height: <?php echo $bheight;?>px;
margin-right: 0px;
padding-top: 15px;
padding-right: 5px;
margin-top: <?php echo $buttont;?>px;
}
#fbtbTab .fbtbTabContent {
border-bottom-right-radius: 6px;
border-top-right-radius: 6px;
}
#fbtbTab .fbtbTabContent {
background: <?php echo $cont_background;?>;
border: 1px solid <?php echo $border_color;?>;
border-right: 0;
-moz-border-radius-bottomright: 6px;
-webkit-border-bottom-right-radius: 6px;
float: right;
padding-right: 0px;
padding-left: 10px;
-webkit-box-shadow: 1px 1px 5px #272727;
-moz-box-shadow: 1px 1px 5px #272727;
box-shadow: 1px 1px 5px #272727;
width: <?php echo $width+10;?>px;
}
#fbtbTab .fbtbTabHandle {
float: right;
width: <?php echo $bwidth;?>px;
height: <?php echo $bheight;?>px;
margin-right: 0px;
padding-top: 15px;
padding-left: 5px;
margin-top: <?php echo $buttont;?>px;
background: url("<?php echo JUri::root();?>modules/mod_bizkniz_facebook_feed_display/images/<?php echo $button;?>_<?php echo $position;?>.png") no-repeat scroll 0 0 transparent;
}
#fbtbTab .fbtbTabContent {
border-bottom-left-radius: 6px;
border-top-left-radius: 6px;
}
.fan_box.full_widget.page_stream{
height: 300px !important;
} 
</style>

<div class="joomla_sharethis<?php echo $moduleclass_sfx?>">
<?php /*
<iframe scrolling="no" frameborder="0" class="FB_SERVER_IFRAME" src="http://www.facebook.com/connect/connect.php?api_key=<?php echo $apikey;?>&amp;channel_url=<?php echo $baseurl;?>/?fbc_channel=1&amp;id=<?php echo $channel_id;?>&amp;name=&amp;width=<?php echo $width;?>&amp;locale=en_GB&amp;connections=<?php echo $connections;?>&amp;stream=<?php echo $stream;?>&amp;logobar=0&amp;css=" allowtransparency="true" name="fbfanIFrame_0" style="width: <?php echo $width;?>px; height: <?php echo $height;?>px; border: medium none;"></iframe>
*/ ?>

<iframe src="//www.facebook.com/plugins/likebox.php?href=<?php echo $baseurl;?>&amp;width=<?php echo $width;?>&amp;height=<?php echo $height;?>&amp;show_faces=true&amp;colorscheme=light&amp;connections=<?php echo $connections;?>&amp;stream=<?php echo $stream;?>&amp;border_color=%23aabbcc&amp;header=true&amp;appId=<?php echo $apikey;?>&amp;" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:<?php echo $width;?>px; height:<?php echo $height;?>px; border: medium none;" allowTransparency="true"></iframe>

</div>