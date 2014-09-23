<?php
/**
* @version $Id: version.php $ 
* @version		15/02/2012
* @package		BS
* @author       Bernard Saulmé
* @copyright	Copyright (C) 2010-2011-2012 Bernard Saulmé
* @license      GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

// Pas d'accès direct
defined( '_JEXEC' ) or die( 'Restricted access' );

// Component Helper
jimport('joomla.application.component.helper');
//jimport( 'joomla.installer.installer' );

class BS_Helper_version
{
	// Info sur la version
	function get_version($droits = null) {
		// Nom du fichier de configuration et extraction des infos xml
		$option_tmp = JRequest::getCmd( 'option' );
		$retour = null;
		if ($option_tmp) {
			$my_componant = substr($option_tmp,4, strlen($option_tmp)-4);
			
			if (!file_exists(JPATH_COMPONENT_ADMINISTRATOR.DS. $my_componant .'.xml')) // Nécessaire, due à l'astuce d'install 1.5 & 1.6 commune, selon le mode d'installation
				$data = JApplicationHelper::parseXMLInstallFile(JPATH_COMPONENT_ADMINISTRATOR.DS. '_'.$my_componant .'.xml');
			else
				$data = JApplicationHelper::parseXMLInstallFile(JPATH_COMPONENT_ADMINISTRATOR.DS. $my_componant .'.xml');

			$authorUrl_tab = explode(' ',$data['authorUrl']); // To allow multiple url ...
			$authorUrl = '';
			foreach ($authorUrl_tab as &$value) {
				$authorUrl .= '<a href="'.Jroute::_($value).'">'.Jroute::_($value).'</a> ';
			}
		
			$retour .= $data['name'].' | '.$data['author'].' | '.$authorUrl.'<br />'. $data['copyright'].'<br />';
			
			$version = new JVersion();
			$currVer = (int) substr(str_replace('.','', $version->getShortVersion()),0,2);

			$user = &JFactory::getUser();

			// Pour admin seulement
			if ( $currVer >= 16 ) { // Joomla 1.6
				if ($user->authorise($droits))
					$retour .= $data['version'].' | '.$data['creationDate'].'<br />';
			} else {
				if ($user->gid == 25 || $user->gid == 24)
					$retour .= $data['version'].' | '.$data['creationdate'].'<br />';
			}

		}
		return $retour;
	}
	
	// Get a specific item : authorUrl, build
	function get_xml_item($component_tmp = null, $item = null, $multiple = false) {
		// Nom du fichier de configuration et extraction des infos xml
		$option_tmp = JRequest::getCmd( 'option' );
		$retour = '-2';
		$split_string = ' ';
		
		if ($option_tmp || $component_tmp) {
			if ($component_tmp)
				$my_componant = substr($component_tmp,4, strlen($component_tmp)-4);
			else
				$my_componant = substr($option_tmp,4, strlen($option_tmp)-4);
	
			$path = JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_'.$my_componant;
			if (!file_exists($path.DS.$my_componant.'.xml')) // Nécessaire, du à l'astuce d'install 1.5 & 1.6 commune
				$file = $path.DS.'_'.$my_componant.'.xml';
			else
				$file = $path.DS.$my_componant.'.xml';
				
			// Read the file to see if it's a valid component XML file
			$xml = & JFactory::getXMLParser('Simple');
			
			if (!$xml->loadFile($file)) {
				unset($xml);
                return '-4';
			}
 
			// Check for a valid XML root tag.
			// Should be 'install', but for backward compatability we will accept 'mosinstall'.
//			if ( !is_object($xml->document) || ($xml->document->name() != 'install' && $xml->document->name() != 'mosinstall')) {
//                unset($xml);
//                return '-5';
//			}

			$element = & $xml->document->{$item}[0];
			$element = $element ? $element->data() : '-1';

			if ($multiple == true) { // get the last for multiple
				$authorUrl_tab = explode($split_string, $element);
				$element = array_pop($authorUrl_tab);
			}

			$retour = $element;
		}
		
		return $retour;	
	}

	// Check if new version and get version info '' = no new version
	function get_newversion($component_tmp = null, $type_tmp = 'component') {
	
		if ($component_tmp == null)
			$component_tmp = JRequest::getCmd( 'option' );

		// Si pas de test
		$pparams = &JComponentHelper::getParams($component_tmp);
		if ($pparams->get('allowcheckversion',1) == 0)
			return '';
		
		// Données de la version actuelle
		$xml = & JFactory::getXMLParser('Simple');
		$xml->loadFile(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_myjspace'.DS.'myjspace.xml');

		$version = & $xml->document->version[0];
		$build = & $xml->document->build[0];
		$creationDate = & $xml->document->creationDate[0];	

		$updateservers	= & $xml->document->updateservers[0];
		if($updateservers) {
			$children = $updateservers->children();
		} else {
			$children = array();
		}
		if (count($children)) {
			foreach ($children as $child) {
				$attrs = $child->attributes();
// 				$data = $attrs['name'].' '.$attrs['type'].' '.$child->data();
				$datalink = $child->data();
			}
		} else {
			$datalink = (string)$updateservers;
		}
		$actual_version = $version->data();
		$actual_build = $build->data();
		$max_version = $version->data();

		// Recherche de la derniere version
		
		// Voir si pas dejà en cache
		$check_lastdate = $pparams->get('check_lastdate',0);	
		$check_version = $pparams->get('check_version','');	
		$check_period = $pparams->get('check_period',864000);

		if (abs($check_lastdate - time()) < $check_period) { // If use dada in cache
			if (version_compare($check_version,$actual_version,'gt'))
				return $check_version;
			else
				return '';		
		}
		
		// Recup du fichier de maj.
		if ($datalink) { // Si lien de maj.

			$mon_serveur = JURI::root();		
			$datalink = $datalink."&type=".$type_tmp."&name=".$component_tmp."&version=".$actual_version.'b'.$actual_build."&joomla=".JVERSION."&server=".$mon_serveur;

			$contents = null;
			if (function_exists('curl_init')) 
				$contents = BS_Helper_version::getCURL($datalink); // First method
			else { // Second method
				$inputHandle = @fopen($datalink, "r");
				if (!$inputHandle) {
					// Set the config in memory & save in DB en return 
					$pparams->set('check_lastdate',time());	
					$pparams->set('check_version',$max_version);	
					BS_Helper_version::save_parameters($component_tmp);
					return '';
				}
				$contents = '';
				while (!feof($inputHandle)) {
					$contents .= fread($inputHandle, 4096);
					if ($contents === false) {
						// Set the config in memory & save in DB en return 
						$pparams->set('check_lastdate',time());	
						$pparams->set('check_version',$max_version);	
						BS_Helper_version::save_parameters($component_tmp);
						return '';
					}
				}
				fclose($inputHandle);			
			}

			if (!$contents) {
				// Set the config in memory & save in DB en return 
				$pparams->set('check_lastdate',time());	
				$pparams->set('check_version',$max_version);	
				BS_Helper_version::save_parameters($component_tmp);
				return '';
			}
				
			// Test la validé du xml du recu !
			$xml_test = @simplexml_load_string($contents);
			if($xml_test===FALSE) {
				// Set the config in memory & save in DB en return 
				$pparams->set('check_lastdate',time());	
				$pparams->set('check_version',$max_version);	
				BS_Helper_version::save_parameters($component_tmp);
				return '';
			}

			// Traitement du fichier pour recherche la derniere version
			$xml = & JFactory::getXMLParser('Simple');
			$xml->loadString($contents);
		
			if (!isset($xml->document->update)) {
				// Set the config in memory & save in DB en return 
				$pparams->set('check_lastdate',time());	
				$pparams->set('check_version',$max_version);	
				BS_Helper_version::save_parameters($component_tmp);
				return ''; // Ne peut checker
			}
			
			foreach( $xml->document->update as $update ) {
				$element = $update->getElementByPath('element');
				$type = $update->getElementByPath('type');
				if ($element->data() == $component_tmp && $type->data() == $type_tmp ) {
					$version = $update->getElementByPath('version');
					if (version_compare($version->data(),$max_version,'gt'))
						$max_version = $version->data();
				}
			}

			// Set the config in memory & save in DB
			$pparams->set('check_lastdate',time());	
			$pparams->set('check_version',$max_version);	
			BS_Helper_version::save_parameters($component_tmp);

			// Return version if new one
			if ($actual_version != $max_version)
				return $max_version;
		}
		
		return '';
	}
	
	// Save de paramaters for memory to DB
	function save_parameters($component_tmp = null) {
			// Save the new config
			$db	=& JFactory::getDBO();
			$pparams = &JComponentHelper::getParams($component_tmp);
			
			if( version_compare(JVERSION,'1.6.0','ge') ) {		
				$data = $pparams->toString('JSON');
				$db->setQuery('UPDATE `#__extensions` SET `params` = '.$db->Quote($data).' WHERE '.
					"`element` = ".$db->Quote($component_tmp)." AND `type` = 'component'");
			} else {		
				$data = $pparams->toString('INI');
				$db->setQuery('UPDATE `#__components` SET `params` = '.$db->Quote($data).' WHERE '.
					"`option` = ".$db->Quote($component_tmp)." AND `parent` = 0 AND `menuid` = 0");
			}
			$db->query();	
	}

	// Get data from url with curl_ functions
	function &getCURL($url, $fp = null, $nofollow = false)
	{
		$result = false;
		
		$ch = curl_init($url);
		
		if( !@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1) && !$nofollow ) {
			// Safe Mode is enabled. We have to fetch the headers and
			// parse any redirections present in there.
			curl_setopt($ch, CURLOPT_AUTOREFERER, true);
			curl_setopt($ch, CURLOPT_FAILONERROR, true);
			curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);

			// Get the headers
			$data = curl_exec($ch);
			curl_close($ch);
			
			// Init
			$newURL = $url;
			
			// Parse the headers
			$lines = explode("\n", $data);
			foreach($lines as $line) {
				if(substr($line, 0, 9) == "Location:") {
					$newURL = trim(substr($line,9));
				}
			}

			// Download from the new URL
			if($url != $newURL) {
				return self::getCURL($newURL, $fp);
			} else {
				return self::getCURL($newURL, $fp, true);
			}
		} else {
			@curl_setopt($ch, CURLOPT_MAXREDIRS, 20);
		}

		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		// Pretend we are IE7, so that webservers play nice with us
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)');
		
		if(is_resource($fp)) {
			curl_setopt($ch, CURLOPT_FILE, $fp);
		}

		$result = curl_exec($ch);
		curl_close($ch);
	
		return $result;
	}	
	
}
?>
