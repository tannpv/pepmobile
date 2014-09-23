<?php
/**
* @version $Id: uploader.php $ 
* @version		06/04/2012
* @package		pluging : BS ccSimpleUploader for Tiny Mce plg editor myjsp
* @author       Bernard Saulm�
* @copyright	Copyright (C) 2010-2011-2012 Bernard Saulm�
* @license      GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

// Safety test for joomla : I'm am a Joomla user connected
require_once 'session_joomla.php';
iam_connected() or die('Restricted access');

// ---------------------------------------------------------------------------

	$Action			= isset($_REQUEST['q']) ? $_REQUEST['q'] : 'none';					// no action by default
	$upload_dir		= isset($_REQUEST['d']) ? $_REQUEST['d'] : './';					// same directory by default
	$substitute_dir = isset($_REQUEST['subs']) ? $_REQUEST['subs'] : './';				// same substitution directory by default
	$ResultTargetID = isset($_REQUEST['id']) ? $_REQUEST['id'] : 'src';					// (obsolete) - target ID now is provided by the tinyMCE framework
	$ResizeSizeX	= isset($_REQUEST['re_x']) ? $_REQUEST['re_x'] : 0;					// don't resize the width by default
	$ResizeSizeY	= isset($_REQUEST['re_y']) ? $_REQUEST['re_y'] : 0;					// don't resize the height by default
//	$ReplaceFile	= isset($_REQUEST['replace_file']) ? $_GET['replace_file'] : 'yes';	// replace the file by default
	$ReplaceFile    = 'yes';
	$type           = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';                // when called from tinyMCE advimg/advlink this will be set and can be used for filtering ... (image, media, file)
	$language_file  = isset($_REQUEST['lf']) ? $_REQUEST['lf'] : 'en-GB';               // language prefix for Language file	
	$DeleteFile	    = isset($_REQUEST['select_file']) ? $_REQUEST['select_file'] : '';	// file to delete
	$ChooseFile	    = isset($_REQUEST['choose_file']) ? $_REQUEST['choose_file'] : '';	// file to choose
	$UserId	    	= isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;						// user id
	
	// Load Language file in a tab, pour appel via MyText()
	$TabLANG = parse_ini_file(JPATH_BASE.DS.'language'.DS.$language_file.DS.$language_file.'.com_myjspace.ini'); // MAJ AFAIRE

	$pparams = &JComponentHelper::getParams('com_myjspace');	
	// For more control
	if ($type == 'media' && $pparams->get('uploadmedia',1) == 1) { // Use the files configured: 'flv','avi','mp4','mov','wmv' ...
		$uploadfile = strtolower(str_replace(' ','',$pparams->get('uploadfile','*'))); // Files suffixes	
		$uploadfile = str_replace(array('|',' '),array(',',''),$uploadfile); // Compatibility with MyJspace < 1.7.7 and cleanup
		$allowed_types = explode(',',$uploadfile);
	} else if ($type == 'image' && $pparams->get('downloadimg',1) == 1)
		$allowed_types = array('jpg','png','gif');
	else if ($type == 'file' && $pparams->get('uploadmedia',1) == 1)
		$allowed_types = array('*');
	else
		die(MyText('COM_MYJSPACE_UPLOADNOALLOWED').' - 0');
		
	$forbiden_files = array('','.','..','index.html','index.htm','index.php','configuration.php','.htaccess',basename(__FILE__));
	
	// Param from Joomla config
	$File_max_size  = $pparams->get('file_max_size',204800); // One file max 200 ko
	$Dir_max_size  = $pparams->get('dir_max_size',2097152); // Dir file max 2 Mo
	
	// User: Alowed to upload for other user ?
	$user_id = JFactory::getuser()->id;
	$upload_admin_var = upload_isAdmin(JFactory::getuser());
	if ($upload_admin_var)
		$user_id = $UserId;

	// Safety controls
	$uploadimg = $pparams->get('uploadimg',1);
	$uploadmedia = $pparams->get('uploadmedia',0);
	$link_folder = $pparams->get('link_folder',1);
	if ( $uploadimg == 0 && $uploadmedia == 0 )
		die(MyText('COM_MYJSPACE_UPLOADNOALLOWED').' - 2');
	if ( $type == 'image' && $uploadimg == 0 )
		die(MyText('COM_MYJSPACE_UPLOADNOALLOWED').' - 3');
	if ( $type == 'media' && $uploadmedia == 0 )
		die(MyText('COM_MYJSPACE_UPLOADNOALLOWED').' - 4');
	if ( $link_folder == 0 )
		die(MyText('COM_MYJSPACE_UPLOADNOALLOWED').' - 5');
	if (!my_rep($user_id))
		die(MyText('COM_MYJSPACE_UPLOADNOALLOWED').' - 6');
	if ( $type != 'image' &&  $type != 'media' && $type != 'file')
		die(MyText('COM_MYJSPACE_UPLOADNOALLOWED').' - 7');
	if ( $Action == 'delete' && $DeleteFile == '')
		die(MyText('COM_MYJSPACE_UPLOADNOALLOWED').' - 8');

	// Securite ++	
	// N'utilise pas $upload_dir, $substitute_dir en variables par securit�
	$upload_dir = JPATH_BASE.DS.my_rep($user_id);
	$tab_url = explode('/plugins/editors/',$_SERVER['SCRIPT_NAME']);
	$substitute_dir = $tab_url[0].'/'.my_rep($user_id);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $language_file; ?>" lang="<?php echo $language_file; ?>" >
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php echo MyText('COM_MYJSPACE_UPLOADTITLE') ?></title>	
	<script type="text/javascript" src="../../tiny_mce_popup.js" ></script>
	<script type="text/javascript" src="editor_plugin.js" ></script>	
	<base target="_self" />
</head>	
<body>
<?php
	if ($Action == 'none')	
		display_upload_form($File_max_size, $type, $user_id, $upload_admin_var);	
	else if ($Action == 'upload')	
		upload_content_file($upload_dir, $substitute_dir, $ResultTargetID, $ResizeSizeX, $ResizeSizeY, $ReplaceFile, $allowed_types, $forbiden_files, $File_max_size, $Dir_max_size, $type);
	else if ($Action == 'delete')
		delete_file($upload_dir, $ResultTargetID, $DeleteFile);
	else if ($Action == 'choose')
		choose_file($upload_dir, $ResultTargetID, $ChooseFile);
?>
</body>
</html>

<?php
// Displays the upload form
function display_upload_form($File_max_size, $type, $user_id, $upload_admin_var)
{
	if ($upload_admin_var)
		$upload_admin_var = 'page';
	else
		$upload_admin_var = '';
	
	?>
	<script type="text/javascript" src="file_list_js.php?fmt=1&amp;type=<?php echo $type; ?>&amp;id=<?php echo $user_id; ?>&amp;view=<?php echo $upload_admin_var; ?>"></script>
	<fieldset>
		<legend><?php echo MyText('COM_MYJSPACE_UPLOADUPLOAD') ?></legend>
		<form action="uploader.php?<?php echo 'q=upload&'.$_SERVER['QUERY_STRING']; ?>" method="post" enctype="multipart/form-data" >
			<input type="file" size="20" name="upload_file" />
			<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $File_max_size; ?>" />
			<br />
			<input type="submit" value="<?php echo MyText('COM_MYJSPACE_UPLOADUPLOAD') ?>" style="width: 150px;" onclick="document.getElementById('progress_div').style.visibility='visible';"/>
			<div id="progress_div" style="visibility: hidden;"><img src="progress.gif" alt="wait..." style="padding-top: 5px;" /></div>
		</form>
	</fieldset>
	<?php
		$pparams = &JComponentHelper::getParams('com_myjspace');// No list = not list for deleting ... :-) Can be a separate option in the futur 	
		if ($pparams->get('downloadimg', 1) != 0) {
	?>
	<fieldset>
		<legend><?php echo MyText('COM_MYJSPACE_UPLOADDELETE') ?></legend>
		<form name="monFormulaire" action="uploader.php?<?php echo 'q=delete&'.$_SERVER['QUERY_STRING']; ?>" method="post" >
			<select name="select_file" id="select_file">
				<option value="" selected="selected"><?php echo MyText('COM_MYJSPACE_UPLOADCHOOSE') ?></option>
			</select>
			<br />
			<input type="submit" value="<?php echo MyText('COM_MYJSPACE_UPLOADDELETE') ?>" style="width: 150px;" />
			<div>&nbsp;</div>			
		</form>
	</fieldset>
	<?php
		}
	?>
<script type="text/javascript">
<!--
function remplirListefichier()
{
  if (document.layers) {
    formulaire = document.forms.monFormulaire;
  } else {
    formulaire = document.monFormulaire;
  }
 	
   formulaire.select_file.options.length = maliste.length+1;
  for (i=0; i<maliste.length; i++) {
		formulaire.select_file.options[i+1].value = maliste[i];
		formulaire.select_file.options[i+1].text = maliste[i];
  }
  document.monFormulaire.select_file.options.selectedIndex = 0;
}
remplirListefichier();
-->
</script>
	<?php
}


// Uploads the file to the destination path, and returns a link with link path substituted for destination path
function upload_content_file($DestPath, $DestLinkPath, $ResultTargetID, $ResizeSizeX, $ResizeSizeY, $ReplaceFile, $allowed_types, $forbiden_files, $File_max_size, $Dir_max_size, $type)
{
	$StatusMessage = '';
	$ActualFileName = '';
	$retour = false;
	
	if (isset($allowed_types[0]))
		$uploadfile_tab[0] = $allowed_types[0];
	else
		$uploadfile_tab[0] = '';
	
	list($rien, $dir_size_var) = dir_size($DestPath);
	
	if (isset($_FILES['upload_file'])) {
		$FileObject = $_FILES['upload_file'];
		$FileBasename = basename($FileObject['name']);
		$type_parts = strtolower(pathinfo($FileObject['name'], PATHINFO_EXTENSION));
		if (!isset($FileObject) || $FileObject['size'] <= 0 || !($uploadfile_tab[0] == '*' || in_array($type_parts, $allowed_types)) || in_array(strtolower($FileBasename), $forbiden_files)) {		
			$StatusMessage = MyText('COM_MYJSPACE_UPLOADERROR2');		
		} else if ($FileObject["size"] > $File_max_size && $ResizeSizeX == 0 && $ResizeSizeY == 0) {
			$StatusMessage = MyText('COM_MYJSPACE_UPLOADERROR4').convertSize($FileObject['size']).MyText('COM_MYJSPACE_UPLOADERROR3').convertSize($File_max_size);
		} else if (($dir_size_var + $FileObject["size"]) > $Dir_max_size ) {
			$StatusMessage = MyText('COM_MYJSPACE_UPLOADERROR5').convertSize($FileObject['size']+$dir_size_var).MyText('COM_MYJSPACE_UPLOADERROR3').convertSize($Dir_max_size);
		} else {	
			$ActualFileName = $DestPath.DS.$FileBasename;													// formulate path to file
			if (file_exists($ActualFileName)) {																// check to see if the file already exists
				if ($ReplaceFile == 'yes')
					$StatusMessage .= MyText('COM_MYJSPACE_UPLOADERROR6');									// if so, we'll let the user know
				else
					$StatusMessage .= MyText('COM_MYJSPACE_UPLOADERROR7');
			}
			if ($ReplaceFile == 'yes') { // A coder si plus forc� � 'yes'
				if ($type == 'image' && ($ResizeSizeX != 0 || $ResizeSizeY != 0)) {							// if we need to resize the file
					$uploadedfile = $FileObject['tmp_name'];												// get the handle to the file that was just uploaded
					if (resize_image($uploadedfile, $ResizeSizeX, $ResizeSizeY, $ActualFileName) != true) {
//						$StatusMessage .= MyText('COM_MYJSPACE_UPLOADERROR8');
						if ($FileObject["size"] <= $File_max_size)											// just process without resizing
							$retour = move_uploaded_file($FileObject['tmp_name'], $ActualFileName);
						else {
							$retour = false;
							$StatusMessage .= MyText('COM_MYJSPACE_UPLOADERROR4').convertSize($FileObject['size']).MyText('COM_MYJSPACE_UPLOADERROR3').convertSize($File_max_size);
						}
					} else {
						$StatusMessage .= MyText('COM_MYJSPACE_UPLOADERROR1');							// Image not resized : ok
						$retour = true;
					}
				} else
					$retour = move_uploaded_file($FileObject['tmp_name'], $ActualFileName);

				if ($retour == true) {					
					$StatusMessage .= MyText('COM_MYJSPACE_UPLOADERROR9');								// image uploaded ok to " . $ActualFileName . "!";						
					$ActualFileName = $DestLinkPath . $FileObject['name'];								// now create the link to the specified link path
				} else {
					$StatusMessage .= ' '.MyText('COM_MYJSPACE_UPLOADERROR12');							// Upload error						
					$ActualFileName = '';				
				}
			}
		}	
	} else {
		$StatusMessage .= MyText('COM_MYJSPACE_UPLOADERROR12');											// Upload error						
		$ActualFileName = '';										
	}
	
	ShowPopUp($StatusMessage);																			// show the message to the user	
	CloseWindow($ResultTargetID, $ActualFileName);
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


function delete_file($DestPath, $ResultTargetID, $DeleteFile)
{
	$ActualFileName = $DestPath.$DeleteFile;
	
	if (@unlink($ActualFileName))
		$StatusMessage = MyText('COM_MYJSPACE_UPLOADERROR10').$DeleteFile;
	else
		$StatusMessage = MyText('COM_MYJSPACE_UPLOADERROR11').$DeleteFile;
	
	ShowPopUp($StatusMessage); // show the message to the user	
	CloseWindow($ResultTargetID, '');
}


function choose_file($DestPath, $ResultTargetID, $ChooseFile)
{
	$ActualFileName = $DestPath.$ChooseFile;
	
	CloseWindow($ResultTargetID, '');
}

// Dir size or number of files (0 size, 1 = number)
function dir_size($folder, $allowed_types = array('*'), $forbiden_files = array('.','..','index.html','index.php'))
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


// Conversion octets en O, Ko, Mo, Go, To
function convertSize( $bytes )
{
    $types = array( MyText('COM_MYJSPACE_UNIT_B'), MyText('COM_MYJSPACE_UNIT_KB'), MyText('COM_MYJSPACE_UNIT_MB'), MyText('COM_MYJSPACE_UNIT_GB'), MyText('COM_MYJSPACE_UNIT_TB') ); // ( 'B', 'KB', 'MB', 'GB', 'TB' );

    for( $i = 0; $bytes >= 1024 && $i < ( count( $types ) -1 ); $bytes /= 1024, $i++ );

    return( round( $bytes, 1 ) . " " . $types[$i] );
}


function ShowPopUp($PopupText)
{
	echo "<script type=\"text/javascript\" >alert (\"$PopupText\");</script>";
}


function CloseWindow($FocusItemID, $FocusItemValue)
{
	?>
		<script type="text/javascript">	
			ClosePluginPopup('<?php echo $FocusItemValue; ?>');
		</script>
	<?php
}


// Fct �quivalent to Jtext but for out of Joomla context
function MyText($chaine) {
	global $TabLANG;
	
	if (isset($TabLANG[$chaine]))
		return $TabLANG[$chaine];
	else
		return $chaine;
}

?>
