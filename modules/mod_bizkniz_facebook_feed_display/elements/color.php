<?php
/**
* @package   FaceBook Slider
* @copyright Copyright (C) 2009 - 2010 Open Source Matters. All rights reserved.
* @license   http://www.gnu.org/licenses/lgpl.html GNU/LGPL, see LICENSE.php
* Contact to : info@autson.com, autson.com
**/

defined('JPATH_BASE') or die();


class JElementColor extends JElement {

	var	$_name = 'Color';
	function fetchElement($name, $value, &$node, $control_name) {
		ob_start();
		$img=JUri::root()."modules/mod_bizkniz_facebook_feed_display/images/rainbow.png";
		$imgx=JUri::root()."modules/mod_bizkniz_facebook_feed_display/images/";
		static $embedded;
		if(!$embedded) {
			$css2=JUri::root()."modules/mod_bizkniz_facebook_feed_display/css/mooRainbow.css";
			$jspath=JUri::root()."modules/mod_bizkniz_facebook_feed_display/js/mooRainbow.js";
?>
			<link href="<?php echo $css2;?>" type="text/css" rel="stylesheet" />
			<script src="<?php echo $jspath;?>"></script>
			<?php $embedded=true; ?>
			<script>
				window.addEvent('domready',function(){
					Element.extend({
						getSiblings: function() {
							return this.getParent().getChildren().remove(this);
						}
					});
					$$('.rainbowbtn').each(function(item){
					 	item.color=new MooRainbow(item.id, {
							startColor: [58, 142, 246],
							wheel: true,		
							id:item.id+'x',			
							onChange: function(color) {
								item.getSiblings()[0].value = color.hex;
							},
							onComplete: function(color) {
								alert('b');
								item.getSiblings()[0].value = color.hex;
							},
							imgPath: '<?php echo $imgx;?>'
						});
					});
				});
			</script>
		<?php
		}
		?>
	<label>
		<input name="<?php echo $control_name;?>[<?php echo $name;?>]" type="text" class="inputbox" id="<?php echo  $control_name.$name ?>" value="<?php echo $value;?>" size="10" />
		<img src="<?php echo $img;?>" id="img<?php echo $name; ?>" alt="[r]" class="rainbowbtn" width="16" height="16" />
	</label>
	<?php 
		$content=ob_get_contents();
		ob_end_clean();
		return $content;
	}
}
?>