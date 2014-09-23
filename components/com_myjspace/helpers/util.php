<?php
/**
* @version $Id: util.php $
* @version		1.8.0 28/04/2012
* @package		com_myjspace
* @author       Bernard Saulmé
* @copyright	Copyright (C) 2010-2011-2012 Bernard Saulmé
* @license      GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

// Pas d'accès direct
defined( '_JEXEC' ) or die( 'Restricted access' );

// Dir size or number of files (0 size, 1 = number)
function dir_size($folder, $allowed_types = array('*'), $forbiden_files = array('.','..','index.html','index.htm','index.php'))
{
	$oldfolder = getcwd();
	if (!@chdir($folder))
		return array(0, 0);

	$size = 0;
	$nb = 0;

	$dir = @opendir('.');
	while (false !== ($File = @readdir($dir))) {
		$path_parts = strtolower(pathinfo($File, PATHINFO_EXTENSION));
		if (!is_dir($File) && !in_array(strtolower($File), $forbiden_files) && ($allowed_types[0] == '*' || in_array($path_parts, $allowed_types))) {
			$size += filesize($File);
			$nb += 1;
		}
	}
	@closedir($dir);
	@chdir($oldfolder);
	
	return array($nb, $size);
}


// Resize image to size max $ResizeSizeX * ResizeSizeY
function resize_image($uploadedfile, $ResizeSizeX = 0, $ResizeSizeY = 0, $ActualFileName)
{
	if ($ResizeSizeX <= 0 && $ResizeSizeY <= 0) // Nothing to do !
		return false;

	$bigint = 1000000;
	try
	{
		list($Originalwidth, $Originalheight, $image_type) = getimagesize($uploadedfile); // get current image size
		switch ($image_type) {
			case 1: $src = imagecreatefromgif($uploadedfile); break;
			case 2: $src = imagecreatefromjpeg($uploadedfile); break;
			case 3: $src = imagecreatefrompng($uploadedfile); break;
			default: return false; break;
		}

		// Overwrite 0 = unlimited !
		if ($ResizeSizeX == 0)
			$ResizeSizeX = $bigint;
		if ($ResizeSizeY == 0)
			$ResizeSizeY = $bigint;

		if  ($Originalwidth <= $ResizeSizeX && $Originalheight <= $ResizeSizeY)
			return false; // Too small, dont resize !
			
		if ($Originalwidth > $ResizeSizeX)
			$ratioX = $ResizeSizeX/$Originalwidth;
		else
			$ratioX = $bigint;
		if ($Originalheight > $ResizeSizeY)
			$ratioY = $ResizeSizeY/$Originalheight;
		else
			$ratioY = $bigint;
		$ratio = min($ratioX, $ratioY);

		$ResizeSizeX = intval($ratio * $Originalwidth);
		$ResizeSizeY = intval($ratio * $Originalheight);
		
		$tmp = imagecreatetruecolor($ResizeSizeX, $ResizeSizeY);													// create new image with calculated dimensions	
		imagecopyresampled($tmp, $src, 0, 0, 0, 0, $ResizeSizeX, $ResizeSizeY, $Originalwidth, $Originalheight);	// resize the image and copy it into $tmp image	
		switch ($image_type) {
			case 1: imagegif($tmp, $ActualFileName); break;
			case 2: imagejpeg($tmp, $ActualFileName, 85); break;
			case 3: imagepng($tmp, $ActualFileName, 3); break;
			default: return false; break;
		}
		
		imagedestroy($src);
		imagedestroy($tmp); // NOTE: PHP will clean up the temp file it created when the request has completed.				
	}
	catch(Exception $e) 
	{
		echo $e;
		return false;
	}
	return true;
}


// Directory list of files
// $rep folder, $allowed_types : $allowed tab of file types (* all), $forbiden_files : tab forbiden file 
function list_file_dir($rep = '', $allowed_types = null, $forbiden_files = null, $sort = 0) {
	
	$tab_retour = array();

	if ($rep == '')
		return $tab_retour;
		
	$oldfolder = getcwd();
	if (!@chdir($rep))
		return $tab_retour;
	
	if ($dir = @opendir('.')) {
		while (false !== ($File = @readdir($dir))) {
			$path_parts = strtolower(pathinfo($File, PATHINFO_EXTENSION));
			if (!is_dir($File) && ( $allowed_types[0] == '*' || in_array($path_parts, $allowed_types)) && (!in_array(strtolower($File), $forbiden_files))) {
				$tab_retour[] = $File;
			}
		}
		@closedir($dir);
	}
	
	@chdir($oldfolder);
	
	if ($sort == 1)
		sort($tab_retour);
		
	return $tab_retour;
}


// Remplace quelques codes BBcode en équivalent html
function bs_bbcode(&$text=null, $width=null, $height=null)
{
  if ($text == null)
	return null;
	
  // Workaround Test due to php bug : #45488 'preg_replace failed when the $subject parameter length exceeds 100009'
  // Test to 92160 (90 ko) to keep margin to all replace due to several call to preg_replace
  if (strlen($text) > 92160)
	return $text;

 // [img]
 $taille_tmp = '';
 if ($width != null)
	$taille_tmp .= ' width="'.$width.'" ';
 if ($height != null)
	$taille_tmp .= ' height="'.$height.'" ';
 $text = preg_replace('!\[img\](.+)\[/img\]!isU', '<a href="$1" rel="lightbox[group]"><img src="$1" '.$taille_tmp.' alt="" /></a>', $text);
 $text = preg_replace('!\[img=(.+)x(.+)\](.+)\[/img\]!isU', '<a href="$3" rel="lightbox[group]"><img width="$1" height="$2" src="$3" alt="" /></a>', $text);
 $text = preg_replace('!\[img size=(.+)x(.+)\](.+)\[/img\]!isU', '<a href="$3" rel="lightbox[group]"><img width="$1" height="$2" src="$3" alt="" /></a>', $text);
 $text = preg_replace('!\[img width=(.+) height=(.+)\](.+)\[/img\]!isU', '<a href="$3" rel="lightbox[group]"><img width="$1" height="$2" src="$3" alt="" /></a>', $text);

 // [url]
 $text = preg_replace('!\[url\](.+)\[/url\]!isU', '<a href="$1" target="_blank">$1</a>', $text);
 $text = preg_replace('!\[url=([^\]]+)\](.+)\[/url\]!isU', '<a href="$1" target="_blank">$2</a>', $text);
  
 return($text);
}


// Envoi un mail
function send_mail($from='', $to='', $subject='', $body='') {

	$mailer =& JFactory::getMailer();
	
	$config =& JFactory::getConfig();
	if ($from == '') { // Default as server configuration
		$sender = array( 
		$config->getValue( 'config.mailfrom' ),
		$config->getValue( 'config.fromname' ) );
	} else {
		$sender = explode(',', $from);
	}
	$mailer->setSender($sender);

	if ($to == '') { // Default as server configuration
		$recipient = array( $config->getValue( 'config.mailfrom' ) );
	} else {
		$recipient = explode(',', $to);
	}		
	$mailer->addRecipient($recipient);

	if ($subject == '')
		$subject = JURI::base().' - '.$config->getValue( 'config.sitename' );
	$mailer->setSubject($subject);
	
	$mailer->setBody($body);
	
	$send =& $mailer->Send();

	return $send;
}


// Convertion de format en Kilo, Mega, Gyga en octets
function convertBytes( $value ) {
    if ( is_numeric( $value ) ) {
        return $value;
    } else {
        $value_length = strlen( $value );
        $qty = substr( $value, 0, $value_length - 1 );
        $unit = strtolower( substr( $value, $value_length - 1 ) );
        switch ( $unit ) {
            case 'k':
                $qty *= 1024;
                break;
            case 'm':
                $qty *= 1048576;
                break;
            case 'g':
                $qty *= 1073741824;
                break;
        }
        return $qty;
    }
}


// Conversion octets en O, Ko, Mo, Go, To
function convertSize( $bytes )
{
    $types = array( JText::_('COM_MYJSPACE_UNIT_B'), JText::_('COM_MYJSPACE_UNIT_KB'), JText::_('COM_MYJSPACE_UNIT_MB'), JText::_('COM_MYJSPACE_UNIT_GB'), JText::_('COM_MYJSPACE_UNIT_TB') ); // ( 'B', 'KB', 'MB', 'GB', 'TB' );

    for( $i = 0; $bytes >= 1024 && $i < ( count( $types ) -1 ); $bytes /= 1024, $i++ );

    return( round( $bytes, 1 ) . " " . $types[$i] );
}


// Test si date valide au forat donnet et retourne au format 'Y-m-d' pour sauvagarede Mysql par exemple
// Si ko retourne 'maintenant' sauf si date = ''
function valid_date($date_tmp, $date_fmt = 'Y-m-d') {
	if ($date_tmp == '')
		return '';

	if (version_compare(PHP_VERSION, '5.3.0') >= 0) { // J'ai au moins la version 5.3.0 de PHP
		if ($date = DateTime::createFromFormat($date_fmt, $date_tmp))
			$madata = $date->format('Y-m-d');
		else
			$madata = date('Y-m-d H:i:s'); // Maintenant
	} else { // Faute de mieux :-)
		$date_tmp = str_replace('/', '-', $date_tmp);
		$madata = date('Y-m-d', strtotime($date_tmp));
	}
	
	// Sinon date-heure actuelle par défaut
	if ( $madata == '1970-01-01' || $madata == '0000-00-00')
		$madata = date('Y-m-d'); // Maintenant
	
	return $madata;
}

// Test si une image existe, si oui retour le code HTML pour l'afficher, sinon null
// $mode = 0 => affiche l'image
// $mode = 1 => affiche un lien sur limage pour previsualisation avec Lytebox
function exist_image_html($img_dir, $img_dir_prefix = JPATH_SITE, $mode = 0, $title = '', $img_name = 'preview.jpg') {

	$retour = null;
	$filename = $img_dir_prefix.DS.$img_dir.DS.$img_name;
	
	if (file_exists($filename)) {
		if ($mode == 0)
			$retour = '<img src="'.$img_dir.'/'.$img_name.'" class="img_preview" title="'.$title.'" alt="'.$title.'" />';
		else
			$retour = '<a href="'.$img_dir.'/'.$img_name.'" rel="lytebox"><img src="'.$img_dir.'/'.$img_name.'" class="img_preview" title="'.$title.'" alt="'.$title.'" /></a>';
	}
	
	return $retour;
}

// Check if an editor exists and is enabled
function check_editor_selection($editor_selection = 'myjsp') {

	if ($editor_selection == '-') // 'default' editor
		return true;

	$plugin =& JPluginHelper::getPlugin('editors', $editor_selection);
	if (!$plugin)
		return false;
	
	return true;
}

// Gererate configuration report
function configuration_report()
{
	require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'version.php';
	
	// Some ideas from kunena to post on BS MyJspace forum
	
	if(ini_get('safe_mode')) {
		$safe_mode = '[u]safe_mode:[/u] [color=#FF0000]On[/color]';
	} else {
		$safe_mode = '[u]safe_mode:[/u] Off';
	}
	
	$db	=& JFactory::getDBO();
	$query = "SELECT version() AS ver";
	$db->setQuery($query);
	$db->query();
	$mysqlsersion = $db->loadResult();

	$app =& JFactory::getApplication();
	
	if($app->getCfg('sef' )) {
		$jconfig_sef = 'Enabled';
	} else {
		$jconfig_sef = 'Disabled';
	}
	if($app->getCfg('sef_rewrite' )) {
		$jconfig_sef_rewrite = 'Enabled';
	} else {
		$jconfig_sef_rewrite = 'Disabled';
	}

	if (file_exists(JPATH_ROOT. '/.htaccess')) {
		$htaccess = 'Exists';
	} else {
		$htaccess = 'None';
	}

	if ( version_compare(JVERSION,'1.6.0','ge') ) {
		$db	=& JFactory::getDBO();
		$query = "SELECT `element` FROM `#__extensions` WHERE `element` IN ('pkg_BSMyJspace','com_myjspace','mod_myjspace','mod_viewmyjspace','myjsp','tagsmyjspace','myjspacesearch','pagebreakmyjspace')";
		$db->setQuery($query);
		$db->query();
		$myelement_tab = $db->loadResultArray();
		$myelement = implode(' | ',	$myelement_tab);
	}
	
	$template = $app->getTemplate();

	
	$retour = '[confidential][b]Joomla! version:[/b] '.JVERSION.' [b]Platform:[/b] '.$_SERVER['SERVER_SOFTWARE'].' ('.$_SERVER['SERVER_NAME'].') [b]PHP version:[/b] '.phpversion().' | '.$safe_mode
			.' | [b]MySQL version:[/b] '.$mysqlsersion.' | [b]Base URL:[/b] ' .JURI::root(). '[/confidential]';

	$retour .= ' [quote][b]Joomla! SEF:[/b] '.$jconfig_sef.' | [b]Joomla! SEF rewrite:[/b] '.$jconfig_sef_rewrite.' | [b]htaccess:[/b] '.$htaccess
			.' | [b]PHP environment:[/b] [u]Max execution time:[/u] '.ini_get('max_execution_time').' seconds | [u]Max execution memory:[/u] '
			.ini_get('memory_limit').' | [u]Max file upload:[/u] '.ini_get('upload_max_filesize').' [/quote] [quote][b]Joomla default template:[/b] '.$template.' [/quote]';
	
//	$retour .= '[confidential][b]BS MyJSpace version:[/b] ' .str_replace('<br />',' ',BS_Helper_version::get_version('com_myjspace.manage')). '[/confidential]';

	$retour .= '[confidential][b]BS MyJSpace version:[/b] ' . BS_Helper_version::get_xml_item('com_myjspace','creationDate').' | '.BS_Helper_version::get_xml_item('com_myjspace','author').' | '.BS_Helper_version::get_xml_item('com_myjspace','version').' | '.BS_Helper_version::get_xml_item('com_myjspace','build').'[/confidential]';

	if ( version_compare(JVERSION,'1.6.0','ge') ) 
		$retour .= ' [quote][b]BS MyJSpace elements:[/b] ' .$myelement. '[/quote]';
	
	return $retour;
}

?>
