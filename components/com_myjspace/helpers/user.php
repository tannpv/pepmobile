<?php
/**
* @version $Id: user.php $
* @version		1.8.0 12/04/2012
* @package		com_myjspace
* @author       Bernard Saulmé
* @copyright	Copyright (C) 2010-2011-2012 Bernard Saulmé
* @license      GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

// Pas d'accés direct
defined( '_JEXEC' ) or die( 'Restricted access' );

// Component Helper
jimport('joomla.application.component.helper');

// -----------------------------------------------------------------------------

class BSHelperUser
{
	var $userid = 0;
	var $pagename = null;
	var $content = null;
	var $blockEdit = 0;
	var $blockView = 0;
	var $foldername = null;
	var $create_date = null;
	var $last_access_date = null;
	var $last_update_date = null;
	var $last_access_ip = null;
	var $hits = 0;
	var $publish_up = null;
	var $publish_down = null;
	var $metakey = null;
	var $template = null;
	var $index_format_version = 3; // BS MyJspace 1.8.0

// Constructeur bidon :-)
	function bshelperuser() {}

// DB : Page new create 'empty' content
	function createPage($pagename) {
	  	$db	=& JFactory::getDBO();
		$query = "INSERT INTO `#__myjspace` (`id`, `pagename`, `content`, `blockEdit`, `blockView`, `metakey`, `template`) VALUES (".$db->Quote(intval($this->userid)).", ".$db->Quote($pagename).",'', '0', '0', '', '')";
		$db->setQuery($query);
		if( $db->query() )
			return 1;
		
		return 0;
	}

// DB : Set conf parameter : pagename, blockView, blockEdit, publish_up, publish_down ... (for a page id) for a page
	function SetConfPage($choice = 127) {
		$choice = intval($choice);
	  	$db	=& JFactory::getDBO();

		$query = 'UPDATE `#__myjspace` SET ';
		if ($choice & 1)
			$query .= ' `pagename` = '.$db->Quote($this->pagename).',';
		if ($choice & 2)
			$query .= ' `blockView` = '.$db->Quote(intval($this->blockView)).',';
		if ($choice & 4)
			$query .= ' `blockEdit` = '.$db->Quote(intval($this->blockEdit)).',';
		if ($choice & 8)
			$query .= ' `publish_up` = '.$db->Quote($this->publish_up).',';
		if ($choice & 16)
			$query .= ' `publish_down` = '.$db->Quote($this->publish_down).',';
		if ($choice & 32)
			$query .= ' `metakey` = '.$db->Quote($this->metakey).',';
		if ($choice & 64)		
			$query .= ' `template` = '.$db->Quote($this->template).',';
		
		$query = substr($query, 0, -1); // remove the last comma
		$query .= ' WHERE `id` = '.$db->Quote(intval($this->userid));
		
		$db->setQuery($query);
		if( $db->query() )
			return 1;
		return 0;
	}	

// DB & FS : Delete page & folder content
	function deletePage($link_folder = 1) {
		$filedir = JPATH_SITE.DS.$this->foldername.DS.$this->pagename;

		// Important :-)
		if ( $this->pagename == '' || ($this->foldername == '' && $link_folder == 1))
		   return 0;

		if ($link_folder == 1) {
			$oldfolder = getcwd();
			if (!@chdir($filedir))
				return 0;		

			// Delete all files in the folder
			$projectsListIgnore = array ('.','..'); // safety
			$handle = @opendir('.');
			while (false !== ($file = @readdir($handle))) {
				if (!is_dir($file) && !in_array($file,$projectsListIgnore)) {
					if (!@unlink($file)) {
						@chdir($oldfolder);
						return 0;
					}
				}
			}
			@closedir($handle);
			@chdir(JPATH_SITE.DS.$this->foldername);

			if ( !( @rmdir($filedir) || @rename($filedir, JPATH_SITE.DS.$this->foldername.DS.'#garbage') ) ) {
				@chdir($oldfolder);	
				return 0;
			}
		}

		$db	=& JFactory::getDBO();
		$query = "DELETE FROM `#__myjspace` WHERE `id` = ".$db->Quote(intval($this->userid));
		$db->setQuery($query);
		if ( $db->query() ) {
			if ($link_folder == 1)
				@chdir($oldfolder);
			return 1;
		}
		
		if ($link_folder == 1)
			@chdir($oldfolder);		
		return 0;
	}
	
// DB : Load all user info (with content)
  	function loadUserInfo($choix = 0, $getcontent_bs = true) {

		$this->content = null;
		$this->blockEdit = 0;
		$this->blockView = 0;
		$this->foldername = null;
		$this->create_date = null;
		$this->last_access_date = null;
		$this->last_update_date = null;
		$this->last_access_ip = null;
		$this->hits = 0;
		$this->publish_up = null;
		$this->publish_down = null;
		$this->metakey = null;
		$this->template = null;	

		if ( ($this->userid > 0 && $choix == 0) || ($this->pagename != '' && $choix ==1) ) {
		  	$db		=& JFactory::getDBO();
			$result_set	= null;
			
			if ($choix == 1)
				$where = "WHERE `pagename` = ".$db->Quote($this->pagename);
			else
				$where = "WHERE `id` = ".$db->Quote(intval($this->userid));
				
			$query = "SELECT `id`, `pagename`, `blockEdit`, `blockView`";
			if ($getcontent_bs == true)
				$query .= ",`content`";
			$query .= ",`create_date`, `last_update_date`, `last_access_date`, `last_access_ip`, `hits`, `publish_up`, `publish_down`, `metakey`, `template` FROM `#__myjspace` ".$where;
			
			$db->setQuery($query);
			$result_set = $db->loadObjectList();
			// Voir code + simple si une ligne et forcer une ligne ...
			$this->userid = 0;
			$this->pagename = null;
			
			if( $result_set != null ) {
				foreach( $result_set as $result) {
					$this->userid = $result->id;
					$this->pagename = $result->pagename;
					if ($getcontent_bs == true)
						$this->content = $result->content;
					$this->blockEdit = $result->blockEdit;
					$this->blockView = $result->blockView;
					$this->create_date = $result->create_date;
					$this->last_update_date = $result->last_update_date;
					$this->last_access_date = $result->last_access_date;
					$this->last_access_ip = $result->last_access_ip;
					$this->hits = $result->hits;
					$this->publish_up = $result->publish_up;
					$this->publish_down = $result->publish_down;
					$this->metakey = $result->metakey;
					$this->template = $result->template;
				}
				return 1;
			}
		}
		return 0;	
	}
	
// DB : Load user info (without content)
  	function loadUserInfoOnly($choix = 0) {
		$this->loadUserInfo($choix, false);
	}

// DB : Update content (= personal page)
	function updateUserContent() {
		// $this->content = str_replace("'", "&#39;", $this->content); // voir si suffisant

	  	$db	=& JFactory::getDBO();
		$query = "UPDATE `#__myjspace` SET `content` = ".$db->Quote($this->content).", `last_update_date` = CURRENT_TIMESTAMP WHERE `id` = ".$db->Quote(intval($this->userid));
		$db->setQuery($query);
		if( $db->query() )
			return 1;
		return 0;
	}
	
// DB : Update Date and hit for the last acess if not same ip addr compare to the last (too simple mais efficient)
	function updateLastAccess($last_access_ip) {
	  	$db	=& JFactory::getDBO();
		$query = "UPDATE `#__myjspace` SET `last_access_date` = CURRENT_TIMESTAMP, `last_access_ip` = ".$db->Quote($last_access_ip).", `hits` = `hits` + 1 WHERE `id` = ".$db->Quote(intval($this->userid))." AND `last_access_ip` <> ".$db->Quote($last_access_ip);
		$db->setQuery($query);
		if( $db->query() )
			return 1;
		return 0;
	}

// DB : Reset Hits & Update Date
	function ResetLastAccess() {
	  	$db	=& JFactory::getDBO();
		$query = "UPDATE `#__myjspace` SET `last_access_date` = '0000-00-00 00:00:00', `last_access_ip` = '0', `hits` = 0 WHERE `id` = ".$db->Quote(intval($this->userid));
		$db->setQuery($query);
		if( $db->query() )
			return 1;
		return 0;
	}
	
// DB : Check if pagename already exist by name
	function ifExistPageName($pagename) {
	  	$db	=& JFactory::getDBO();
		$query = "SELECT `pagename` FROM `#__myjspace` WHERE `pagename` = ".$db->Quote($pagename);
		$db->setQuery($query);
		return $db->loadResult();
	}

// DB : Check if pagename already exist by id, return user id if exist, else return null
	function ifExistUserId($userid) {
	  	$db	=& JFactory::getDBO();
		$query = "SELECT `id` FROM `#__myjspace` WHERE `id` =  ".$db->Quote($userid);
		$db->setQuery($query);
		return $db->loadResult();
	}

// DB : Select a specific content by Page id
	function GetContentPageId($userid) {
	  	$db	=& JFactory::getDBO();
		$query = "SELECT `content` FROM `#__myjspace` WHERE `id` = ".$db->Quote($userid);
		$db->setQuery($query);
		return $db->loadResult();
	}

// DB : List of all username (if $resultmode = 1 add metakey)
	function loadPagename($triemode = -1, $affmax = 0, $blocked = 0, $publish = 0, $content = 0, $check_search = null, $scontent = '', $resultmode = 0) {
	  	$db	=& JFactory::getDBO();

		// Safety
		$resultmode = intval($resultmode);
		if ($resultmode < 0 || $resultmode > 127)
			$resultmode = 0;
		if ($affmax < 0)
			return null;

		// Columns to 'display'
		$query = "SELECT `id`, `pagename`"; // id(username) = 1, pagename = 2 for display (search)
			
		if ($resultmode & 4)
			$query .= ", `metakey`";
		if ($resultmode & 8)
			$query .= ", `create_date`";
		if ($resultmode & 16)
			$query .= ", `last_update_date`";
		if ($resultmode & 32)
			$query .= ", `hits`";
		// 64 for image (search)
			
		$query .= " FROM `#__myjspace` WHERE 1=1";
		
		// Criterias
		if ($blocked)
			$query .= " AND `blockView` != 1";

		if ($publish)
			$query .= " AND `publish_up` < NOW() AND (`publish_down` >= NOW() OR `publish_down` = '0000-00-00 00:00:00')";

		if ($content)
			$query .= " AND `content` != ''";
		
		if ($check_search != null && count($check_search) > 0 && $scontent != '') {
			$query .= " AND ( 1=0 ";
			
			$pparams = &JComponentHelper::getParams('com_myjspace');
			if ($pparams->get('search_html', 1)) // search into html content
				$scontent = htmlentities($scontent,ENT_QUOTES,'UTF-8');
			
			if (isset($check_search['name']))
				$query .= " OR `pagename` LIKE ".$db->Quote('%'.$db->getEscaped($scontent, true).'%');

			if (isset($check_search['description']))
				$query .= " OR `metakey` LIKE ".$db->Quote('%'.$db->getEscaped($scontent, true).'%');

			if (isset($check_search['content']))
				$query .= " OR `content` LIKE ".$db->Quote('%'.$db->getEscaped($scontent, true).'%');
				
			$query .= " ) ";
		}	
		
		// Sort order
		if ($triemode == 0)
			$query .= " ORDER BY pagename ASC";
		else if ($triemode == 1)
			$query .= " ORDER BY pagename DESC";
		else if ($triemode == 2)
			$query .= " ORDER BY RAND()";
		else if ($triemode == 3)
			$query .= " ORDER BY create_date DESC";
		else if ($triemode == 4)
			$query .= " ORDER BY last_update_date DESC";
		else if ($triemode == 5)
			$query .= " ORDER BY hits DESC";
			
		if ($affmax != 0)
			$query .= " LIMIT ".intval($affmax);	
		
		$db->setQuery($query);
		$row = $db->loadAssocList();
		
		return $row;
	}
	
// FS : Page Create Folder & file to redirect	
	function CreateDirFilePage($pagename, $choix = 0, $id = 0) {
	
		$filedir = JPATH_SITE.DS.$this->foldername.DS.$pagename;
		$link = str_replace('/administrator','',JURI::base()); 
		
		if ($choix == 1)
			$content_id = 'pagename='.$pagename;
		else {
			if ($id != 0)
				$userid = $id;
			else
				$userid = $this->userid;
			$content_id = 'id='.$userid;
		}
	
$content = "<?php
// com_myjspace
// Format:".$this->index_format_version."
// Get Itemid
define( '_JEXEC', 1 );
define( 'DS', DIRECTORY_SEPARATOR);
define( 'JPATH_BASE', '".str_replace('\\','\\\\',JPATH_SITE)."');
require_once (JPATH_BASE.DS.'includes'.DS.'defines.php' );
require_once (JPATH_BASE.DS.'includes'.DS.'framework.php' );

\$mainframe =& JFactory::getApplication('site');
\$mainframe->initialise();
	
\$pparams = &JComponentHelper::getParams('com_myjspace');
\$force_itemid = \$pparams->get('force_itemid','');

if (\$force_itemid == '') { // If not Itemid forced get default menu Itemid
	if (version_compare(JVERSION,'1.6.0','lt'))
		\$menu = &JSite::getMenu();
	else {
		\$app = JFactory::getApplication();
		\$menu = \$app->getMenu();
	}
	
	\$defaultMenu = & \$menu->getDefault();
	\$itemid = \$defaultMenu->id; // Get the default menu value
} else { // use the forced one
	\$itemid = \$force_itemid;
}

// MyJspace user page
if (isset(\$_SERVER[\"QUERY_STRING\"]) && \$_SERVER[\"QUERY_STRING\"] != '')
	\$add = '&'.\$_SERVER[\"QUERY_STRING\"];
else
	\$add = '';

if (\$add == '' && \$itemid != 0)
	\$add = '&Itemid='.\$itemid;

header(\"location: ".$link."index.php?option=com_myjspace&view=see&".$content_id."\$add\");
?>
";
		// Folder (may already exist)
		@mkdir($filedir);
		@chmod($filedir, 0755);

		// File index.php
		$file = $filedir.DS.'index.php';
		$handle = @fopen($file,"w");
		if($handle) {
			@fwrite( $handle, $content );
			@chmod($file, 0755);
			return 1;
		}
		
		return 0;
	}
	
	// Retreive the version info the index file
	function VersionIndexPage($pagename) {
	
		$file_index = JPATH_SITE.DS.$this->foldername.DS.$pagename.DS.'index.php';
		$contenu = @fread(fopen($file_index, "r"), 80); 
		$sortie = null;
		preg_match('#// Format:(.*)\n#Us', $contenu, $sortie);

		if (isset($sortie[1]))
			$version = trim($sortie[1]);
		else
			$version = 0;
	
		return $version;
	}

	// Check tne number of index page with NOT the actual version
	function CheckVersionIndexPage() {
		$nb_index_ko = -1;
		$pparams = &JComponentHelper::getParams('com_myjspace');
		$pparams->get('link_folder',1);
		if ($pparams->get('link_folder',1) == 1 ) {

			$user_page = New BSHelperUser();
			$user_page->getFoldername();
			$username_list = $user_page->loadPagename();
			
			$nb_page = count($username_list);
			$nb_index_ko = 0;
			if ($nb_page > 0) {
				for ($i = 0; $i < $nb_page; $i++) {
					if ($user_page->VersionIndexPage($username_list[$i]['pagename']) != $user_page->index_format_version)
						$nb_index_ko = $nb_index_ko + 1;
				}
			}
		}
		return $nb_index_ko;
	}
	
// FOLDERNAME

// CFG : Get foldername
	function getFoldername() {
		$pparams = &JComponentHelper::getParams('com_myjspace');
		$this->foldername = $pparams->get('foldername','myjsp');
		return $this->foldername;
	}

// FS : test if the 'real' foldername exist
	function ifExistFoldername($foldername) {
		$oldfolder = getcwd();
		@chdir(JPATH_SITE);
		$retour = @is_dir($foldername);
		@chdir($oldfolder);
		return($retour);
	}

// FS & CFG : create or update page ROOT folder name
	function updateFoldername($foldername = '', $link_folder, $keep = 0) {
	    require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'user_event.php';
	    require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'version.php';
		
		// Check
		if ( $foldername == '' || $link_folder == 0)
			return 0;

		// Rename (or create + chmod) folder or move subfolders on file system too
		if ($this->foldername != $foldername && BSHelperUser::ifExistFoldername(JPATH_SITE.DS.$foldername) && BSUserEvent::adm_rename_folders(JPATH_SITE.DS.$this->foldername, JPATH_SITE.DS.$foldername)) { // rename = move in one existing
			if ($keep == 0)
				@rmdir(JPATH_SITE.DS.$this->foldername);
		} else if ($keep == 1 && @mkdir(JPATH_SITE.DS.$foldername) && @chmod(JPATH_SITE.DS.$foldername, 0755) && BSUserEvent::adm_rename_folders(JPATH_SITE.DS.$this->foldername, JPATH_SITE.DS.$foldername)) { // Create a new one and move
			// rien :-)
		} else if ($keep == 0 && !@rename(JPATH_SITE.DS.$this->foldername, JPATH_SITE.DS.$foldername)) { // if error try to create
			if(!@mkdir(JPATH_SITE.DS.$foldername) || !@chmod(JPATH_SITE.DS.$foldername, 0755))
				return 0;
		} // => rename folder ok
		
		// If no file index.html in the forder, create it 
		$file = JPATH_SITE.DS.$foldername.DS.'index.html';
		if (!file_exists($file)) {
			$content = '<html><body></body></html>';
			$handle = @fopen($file,"w");
			if($handle) {
				@fwrite( $handle, $content );
				@chmod($file, 0755);
			}
		}

	    if ($this->foldername != $foldername) {
			$pparams = &JComponentHelper::getParams('com_myjspace');
			$pparams->set('foldername',$foldername);
			BS_Helper_version::save_parameters('com_myjspace');
		}
		return 1;
	}

// Check foldername caracteres	
	function checkFoldername($foldername, $allowed = '#^[a-zA-Z0-9/]+$#') {
		if( preg_match($allowed, $foldername) )
			return 1;
		return 0;
	}

// User IP Adresse
	function addr_ip() {
		if (isSet($_SERVER)) {
			if (isSet($_SERVER["HTTP_X_FORWARDED_FOR"])) {
				$realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
			} elseif (isSet($_SERVER["HTTP_CLIENT_IP"])) {
				$realip = $_SERVER["HTTP_CLIENT_IP"];
			} else {
				$realip = $_SERVER["REMOTE_ADDR"];
			}
		} else {
			if ( getenv( 'HTTP_X_FORWARDED_FOR' ) ) {
				$realip = getenv( 'HTTP_X_FORWARDED_FOR' );
			} elseif ( getenv( 'HTTP_CLIENT_IP' ) ) {
				$realip = getenv( 'HTTP_CLIENT_IP' );
			} else {
				$realip = getenv( 'REMOTE_ADDR' );
			}
		}
		return $realip;
	}
	
// PAGE CONTENT fct

// Substitute # tags with they contents (dadabase contents for a user page)
// Reserved words: #userid, #name, #username, #pagename, #lastupdate, #lastaccess, #createdate, #fileslist, #hits ... and a specific one #bsmyjspace :-)
// pos = 0 for page content, 1 for prefix, 2 for suffix
	function traite_prefsuf(&$atraiter, &$user, $page_increment = 0, $date_fmt = 'Y-m-d H:i:s', $chaine_files = '', $replace_inf_sup = 0, $Itemid = 0) {

		if ( $atraiter == null || $atraiter == '' )
			return '';

		// Reverved words to replace

		// CB
		$chaine_cb = '<iframe src="'.JURI::base().'index.php?option=com_comprofiler&amp;task=userProfile&amp;user='.$user->id.'&amp;tmpl=component" id="cbprofile" frameborder="0" ></iframe>';
		// Joomsocial
		$chaine_jsocial_profile = '<iframe src="'.JURI::base().'index.php?option=com_community&amp;view=profile&amp;userid='.$user->id.'&amp;tmpl=component" id="jomsocial-profile" frameborder="0" ></iframe>';
		$chaine_jsocial_photos  = '<iframe src="'.JURI::base().'index.php?option=com_community&amp;view=photos&amp;task=myphotos&amp;userid='.$user->id.'&amp;tmpl=component" id="jomsocial-photos" frameborder="0" ></iframe>';
	
		if ($Itemid != 0)
			$chaine_bsmyjspace = '<span class="bsfooter"><a href="'.Jroute::_('index.php?option=com_myjspace&amp;view=myjspace&amp;Itemid='.$Itemid).'">BS MyJspace</a></span>';
		else
			$chaine_bsmyjspace = '<span class="bsfooter"><a href="'.Jroute::_('index.php?option=com_myjspace&amp;view=myjspace').'">BS MyJspace</a></span>';
		
		$search  = array('#userid', '#name', '#username', '#pagename', '#lastupdate', '#lastaccess', '#createdate', '#description', '#bsmyjspace', '#fileslist', '#cbprofile','#jomsocial-profile','#jomsocial-photos');
		$replace = array($user->id, $user->name, $user->username, $this->pagename, date($date_fmt, strtotime($this->last_update_date)), date($date_fmt, strtotime($this->last_access_date)),date($date_fmt, strtotime($this->create_date)), $this->metakey, $chaine_bsmyjspace, $chaine_files, $chaine_cb, $chaine_jsocial_profile, $chaine_jsocial_photos);
		if ($replace_inf_sup == 1) {
			$search  = array_merge($search, array('#inf','#sup')); // because html code ot allowed any more in 1.6 & 1.7 configuration
			$replace = array_merge($replace, array('<','>'));
		}
		if ($page_increment == 1) {
			$search[] = '#hits';
			$replace[] = $this->hits;
		}
		
		// Replace
		$atraiter = str_replace($search, $replace, $atraiter);
	
		return $atraiter;
	}

	// Function to have 'API' for component & plugins
	
	// Return the user pagename if exist
	function mjsp_exist_page($uid = 0) {
   		// Personnal page info
		$user_page = New BSHelperUser(); // For simple call from outside
		$user_page->userid = $uid;
		$user_page->loadUserInfoOnly();

		return $user_page->pagename;
	}
	
	// Return the user pagename content if exist (with all tags replaced aa right check)
	function mjsp_exist_page_content($uid = 0, $pagebreak = 0) {
		$retour = '';
	
		// User & component
		$pparams = &JComponentHelper::getParams('com_myjspace');
		$user = &JFactory::getuser($uid);
		$user_actual = &JFactory::getuser();
		// Personnal page info
		$user_page = New BSHelperUser(); // For simple call from outside
		$user_page->userid = $user->id;
		$user_page->loadUserInfo();

        // Content & complete with prefix & suffix and remplacing # tags
		$page_increment = $pparams->get('page_increment',1);
		$date_fmt = $pparams->get('date_fmt','Y-m-d H:i:s');
		
        // Content
		$uploadadmin = $pparams->get('uploadadmin',1);
		$uploadimg = $pparams->get('uploadimg',1);
		$chaine_files = '';
		if ($uploadadmin == 1 && $uploadimg == 1) { // May be add optional in the futur
			require_once JPATH_ROOT.DS.'components'.DS.'com_myjspace'.DS.'helpers'.DS.'util.php';
			$forbiden_files = array('.','..','index.html','index.htm','index.php');
			$user_page->getFoldername();
			$tab_list_file = list_file_dir(JPATH_ROOT.DS.$user_page->foldername.DS.$user_page->pagename, '*', $forbiden_files, 1);
			$nb = count($tab_list_file);
			for ($i = 0 ; $i < $nb ; ++$i)
				$chaine_files .= '<a href="'.JURI::base().$user_page->foldername.'/'.$user_page->pagename.'/'.$tab_list_file[$i].'">'.$tab_list_file[$i].'</a> '; 
		}

		if ($pparams->get('allow_user_content_var',1))
			$content = &$user_page->traite_prefsuf($user_page->content, $user, $page_increment, $date_fmt, $chaine_files, 0, $Itemid);
		else
			$content = &$user_page->content;
			
		// [register]
		if ($pparams->get('editor_bbcode_register',0) == 1 && strlen($content) <= 92160) { // Allow to use the dynamic tag [register]
			$uri = JFactory::getURI();
			$return = $uri->toString();
			if ( version_compare(JVERSION,'1.6.0','ge') ) // >= Joomla 1.6
				$url = 'index.php?option=com_users&view=login';
			else
				$url = 'index.php?option=com_user&view=login';
			$url .= '&return='.base64_encode($return); // to redirect to the originaly call page
			$url = Jroute::_($url, false);
 
			if ($user_actual->id != 0)// if not registered
				$content = preg_replace('!\[register\](.+)\[/register\]!isU', '$1', $content);
			else // if registered
				$content = preg_replace('!\[register\](.+)\[/register\]!isU', JText::sprintf('COM_MYJSPACE_REGISTER', $url), $content);		
		}			

		$prefix = '';
		$suffix = '';
		
		// Force default dates
		if ($pparams->get('publish_mode',2) == 0) { // do not take into account the dates
			$user_page->publish_up = '0000-00-00 00:00:00';
			$user_page->publish_down = '0000-00-00 00:00:00';
		}
		if ($user_page->publish_down == '0000-00-00 00:00:00')
			$user_page->publish_down = date('Y-m-d 00:00:00',strtotime("+1 day"));		
				
		// Language file from com_myjspace
//		$lang = &JFactory::getLanguage();
//		$lang->load('com_myjspace', ''); 
		// Specific context
		$aujourdhui = time();
		if ( $user_page->blockView == null ) {
//			$content = JText::_('COM_MYJSPACE_PAGENOTFOUND');
			$content = '';
		} else if ( $user_page->blockView == 1 && $user_actual->id != $user_page->userid ) {
//			$content = JText::_('COM_MYJSPACE_PAGEBLOCK');
			$content = '';
		} else if ( $user_page->blockView == 2 && $user_actual->username == "" ) {
//			$content = JText::_('COM_MYJSPACE_PAGERESERVED');
			$content = '';
		} else if ( $user_page->content == null ) {
//			$content = JText::_('COM_MYJSPACE_PAGEEMPTY');
			$content = '';
		} else if ( strtotime($user_page->publish_up) > $aujourdhui || strtotime($user_page->publish_down) <= $aujourdhui ) {
//			$content = JText::_('COM_MYJSPACE_PAGEUNPLUBLISHED');
			$content = '';
		} else {
		
		// Top and bottom
			if ($pparams->get('page_prefix',''))
				$prefix = '<span class="top_myjspace">'.$user_page->traite_prefsuf($pparams->get('page_prefix',''), $user, $page_increment, $date_fmt, $chaine_files, 1, $Itemid).'</span><br />';
			if ($pparams->get('page_suffix','#bsmyjspace'))
				$suffix = '<span class="bottom_myjspace">'.$user_page->traite_prefsuf($pparams->get('page_suffix','#bsmyjspace'), $user, $page_increment, $date_fmt, $chaine_files, 1, $Itemid).'</span><br />';
		}			
		
		if ($pagebreak == 0) {
			$regex = '#<hr([^>]*?)class=(\"|\')system-pagebreak(\"|\')([^>]*?)\/*>#iU';
			$content = preg_replace( $regex, '<br />', $content );
		}
		
		if ($content)
			$retour = '<div class="myjspace-prefix">'.$prefix.'</div><div class="myjspace-content"></div>'.$content.'<div class="myjspace-suffix">'.$suffix.'</div>';
	
		return $retour;
	}
	
}
?>
