<?php 
/**
 * Simple PopUp - Joomla Plugin
 * 
 * @package    Joomla
 * @subpackage Plugin
 * @author Anders Wasén
 * @link http://wasen.net/
 * @license		GNU/GPL, see LICENSE.php
 * plg_simplefilegallery is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

defined('_JEXEC') or die('Restricted access'); // no direct access 

// If Joomla 3 then load jQuery through Joomla
if ($this->popupjqueryJ3) JHtml::_('jquery.framework');

JHtml::stylesheet( 'plugins/content/simplepopup/simplepopup/spustyle.css' );
JHtml::stylesheet( 'plugins/content/simplepopup/simplepopup/fancybox/jquery.fancybox-1.3.4.css');

if (strlen($this->popuptextalign) > 0) {
	$spu_aligntext = $this->popuptextalign;
} else {
	$spu_aligntext = $this->params->get( 'spu_aligntext', 'center' );
}
if (strlen($this->popupwidth) > 0) {
	$spu_boxwidth = $this->popupwidth;
} else {
	$spu_boxwidth = $this->params->get( 'spu_boxwidth', '400' );
}
if (strlen($this->popupheight) > 0) {
	$spu_boxheight = $this->popupheight;
} else {
	$spu_boxheight = $this->params->get( 'spu_boxheight', 'auto' );
}
if (strlen($this->popupautodimensions) > 0) {
	$spu_autodimensions = $this->popupautodimensions;
} else {
	$spu_autodimensions = $this->params->get( 'spu_autodimensions', 'false' );
}

// Override cookie setting from backend. Zero means no cookie, negative will erase cookie
if (is_numeric($this->popupcookie) && $this->popupcookie != 0) {
	$spu_cookie = '1';
	$spu_cookiepersistence = $this->popupcookie;
} else {
	if ($this->popupcookie == 0) {
		$spu_cookie = '0';
	} else {
		$spu_cookie = $this->params->get( 'spu_cookie', '0' );
		$spu_cookiepersistence = $this->params->get( 'spu_cookiepersistence', '365' );
	}
}
$spu_jquery = $this->params->get( 'spu_jquery', '0' );
$spu_jqueryinclude = $this->params->get( 'spu_jqueryinclude', '0' );
$spu_jquerync = $this->params->get( 'spu_jquerync', '0' );
$spu_style = $this->params->get( 'spu_style', 'fancybox' );
if ($spu_style === 'lightbox') $this->popupboxstyle = $spu_style;

if (strlen($this->popupjqueryloading) > 0) {
	if ($this->popupjqueryloading === 'none') $spu_jquery = 2;
	if ($this->popupjqueryloading === 'fancybox') {
		$spu_jquery = 1;
		$spu_jqueryinclude = 1;
	}
	if ($this->popupjqueryloading === 'all') {
		$spu_jquery = 0;
		$spu_jqueryinclude = 1;
	}
}

if ($spu_jquery == 0 && !$this->popupjqueryJ3) {
	if ($spu_jqueryinclude == 0)
		JHtml::script( 'plugins/content/simplepopup/simplepopup/jquery-1.7.2.min.js' );
	else
		echo '<script type="text/javascript" src="plugins/content/simplepopup/simplepopup/jquery-1.7.2.min.js"></script>';
}
if ($spu_jquery < 2) {
	if ($spu_jqueryinclude == 0) {
		JHtml::script( 'plugins/content/simplepopup/simplepopup/fancybox/jquery.mousewheel-3.0.4.pack.js' );
		JHtml::script( 'plugins/content/simplepopup/simplepopup/fancybox/jquery.fancybox-1.3.4.pack.js' );
	} else {
		echo '<script type="text/javascript" src="plugins/content/simplepopup/simplepopup/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>';
		echo '<script type="text/javascript" src="plugins/content/simplepopup/simplepopup/fancybox/jquery.fancybox-1.3.4.pack.js"></script>';
	}
}
?>
<!-- SPU HTML GOES BELOW -->

<script language="javascript" type="text/javascript">
<!--
<?php if ($this->popup === 'false') { ?>
	var fshowMsg = false;
<?php } else { ?>
	var fshowMsg = true;
<?php } ?>

<?php if ($spu_cookie === '1')  { ?>
function spu_createCookie(name, value, days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

function spu_readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) {
			if (c.substring(nameEQ.length,c.length).length == 0) return "noname";
			return c.substring(nameEQ.length,c.length);
		}
		if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
	}
	return null;
}

<?php } ?>

jQuery(document).ready(function() {
	
	<?php if ($spu_cookie === '1')  { ?>
		
		var cookieRet = spu_readCookie('spu_cookie<?php echo $this->popupname; ?>');
		
		if(!cookieRet) {
			// Cookie not found, set cookie expiration and show message
			var persistance = <?php echo $spu_cookiepersistence; ?>;
			
			spu_createCookie('spu_cookie<?php echo $this->popupname; ?>', '<?php echo $this->popupname; ?>', persistance);
		} else {
			// Cookie exists, skip message
			fshowMsg = false;
		}
	<?php } ?>
	
	<?php if ($this->popupvideo === 'true') {
	echo 'var spuvideo'.$this->popupname.' = \''.$this->popupurl.'\';';
	} ?>
	
	
	jQuery('.<?php echo $this->popupname; ?>').fancybox({
		'titleShow'			: true,
		'scrolling'			: '<?php echo $this->popupscrolling; ?>',
		'transitionIn'		: '<?php echo $this->popuptransitionin; ?>',
		'transitionOut'		: '<?php echo $this->popuptransitionout; ?>',
		'speedIn'			: '<?php echo $this->popupspeedin; ?>',
		'speedOut'			: '<?php echo $this->popupspeedout; ?>',
		'hideOnOverlayClick': <?php echo $this->popuphideonoverlayclick; ?>,
		'hideOnContentClick': <?php echo $this->popuphideoncontentclick; ?>,
		<?php if ($this->popupboxstyle === 'lightbox') { ?>
		'showCloseButton'	: false,
		'titlePosition' 	: 'inside',
		'titleFormat'		: formatTitle,
		<?php } else { ?>
		'showCloseButton'	: <?php echo $this->popupclosebutton; ?>,
		'titlePosition'		: '<?php echo $this->popuptitleposition; ?>',
		<?php }	?>
		'title'				: '<?php echo $this->popuptitle; ?>',
		<?php if ($spu_autodimensions === 'false') { ?>
		'autoDimensions'	: false,
		'width'				: <?php echo $spu_boxwidth; ?>,
		'height'			: <?php echo $spu_boxheight; ?>,
		<?php } else { ?>
		'autoDimensions'	: true,
		<?php }	?>
		<?php if ($this->popupvideo === 'true') { ?>
		'href'			: spuvideo<?php echo $this->popupname; ?>.replace(new RegExp("watch\\?v=", "i"), 'v/'),
		'type'			: 'swf',
		'swf'			: {
			'wmode'		: 'transparent',
			'allowfullscreen'	: 'true'
		},
		<?php } ?>
		'resizeOnWindowResize'	: <?php echo $this->resizeOnWindowResize; ?>,
		'centerOnScroll'	: <?php echo $this->resizeOnWindowResize; ?>,
		'overlayShow'		: <?php echo $this->popupoverlayshow; ?>,
		'overlayOpacity'	: <?php echo $this->popupoverlayopacity; ?>,
		'overlayColor'		: '<?php echo $this->popupoverlaycolor; ?>'
		}
	);
	
	jQuery(document).on('click', '#<?php echo $this->popupname; ?>', function(event){
		jQuery('.<?php echo $this->popupname; ?>').trigger('click');
	});
	<?php //} ?>
	
});

function formatTitle(title, currentArray, currentIndex, currentOpts) {
    return '<div style="text-align: left;"><span style="float: right;"><a href="javascript:;" onclick="jQuery.fancybox.close();"><img src="plugins/content/simplepopup/simplepopup/fancybox/closelabel.gif" /></a></span>' + (title && title.length ? '<b style="display: block; margin-right: 80px;">' + title + '</b>' : '' ) + 'Image ' + (currentIndex + 1) + ' of ' + currentArray.length + '</div>';
}
	
-->
</script>

<?php
// This is to get "live" function if user wants both auto-pop and link for the same popup. Option would be to duplicate fancybox{}
echo '<a class="'.$this->popupname.'" style="display:none;"'.$rel.$title.$url.'>SPUPOPUPNO1</a>', chr(10);
?>

<!-- FancyBox -->
<?php if ($this->popupvideo !== 'true') { ?>
<div id="spuSimplePoPup" style="display: none;">
	<div id="spucontent<?php echo $this->popupname; ?>" class="<?php echo $this->popupcssclass; ?>" style="text-align: <?php echo $spu_aligntext; ?>;">
		<?php 
		if(strlen($this->popupurl) > 0 &&  $this->popupvideo !== 'true') {
			$pagecontent = file_get_contents($this->popupurl, FILE_TEXT);
			$pagecontent = mb_convert_encoding($pagecontent, 'UTF-8', mb_detect_encoding($pagecontent, 'UTF-8, ISO-8859-1', true));

			if ($pagecontent === false) $pagecontent = 'URL ('.$this->popupurl.') failed to load. Please inform the site administrator!';
			$this->popupmsg = $pagecontent;
		}
		echo $this->popupmsg;
		?>
	</div>
	<?php if ($this->popupmulti === 'true') { ?>
	<div style="position: relative; width: 100%; text-align: right;">Next >></div>
	<?php } ?>
</div>
<?php } ?>

<script language="javascript" type="text/javascript">
<!--
jQuery(document).ready(function() {
	// If pop on load then trigger click on link
	if (fshowMsg) jQuery('#<?php echo $this->popupname; ?>').trigger('click');
});
-->
</script>

<!-- END SPU HTML -->