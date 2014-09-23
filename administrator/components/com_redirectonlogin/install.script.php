<?php
/**
* @package Redirect-On-Login (com_redirectonlogin)
* @version 3.1.0
* @copyright Copyright (C) 2008 - 2013 Carsten Engel. All rights reserved.
* @license GPL versions free/trial/pro
* @author http://www.pages-and-items.com
* @joomla Joomla is Free Software
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

class com_redirectonloginInstallerScript {

	function preflight($type, $parent){
	
		$db = JFactory::getDBO();
		$ds = DIRECTORY_SEPARATOR;	
		
		//if there is a leftover of a previous install, take it out.
		//http://forum.joomla.org/viewtopic.php?f=578&t=594153
		$db->setQuery("DELETE FROM #__assets WHERE name='com_redirectonlogin' AND title='com_redirectonlogin' LIMIT 1");
		$db->query(); 
		
		//if the old uninstall file is still there, delete it
		$old_uninstall_file = JPATH_ADMINISTRATOR.$ds.'components'.$ds.'com_redirectonlogin'.$ds.'uninstall.redirectonlogin.php';
		if(file_exists($old_uninstall_file)){
			JFile::delete($old_uninstall_file);
		}
	} 


	public function postflight($type, $parent){
		
		$db = JFactory::getDBO();
		$ds = DIRECTORY_SEPARATOR;
	
		$db->setQuery("CREATE TABLE IF NOT EXISTS #__redirectonlogin_config (
	  `id` int(1) NOT NULL auto_increment,
	  `config` text NOT NULL,
	  PRIMARY KEY (`id`)
	)");
		$db->query();	
		
		$db->setQuery("CREATE TABLE IF NOT EXISTS #__redirectonlogin_groups (
	  `id` int(11) NOT NULL auto_increment,
	  `group_id` int(11) NOT NULL,
	  `frontend_type` varchar(255) NOT NULL,
	  `frontend_url` varchar(255) NOT NULL,
	  `frontend_type_logout` varchar(255) NOT NULL,
	  `frontend_url_logout` varchar(255) NOT NULL,
	  `backend_type` varchar(255) NOT NULL,
	  `backend_url` varchar(255) NOT NULL,
	  `backend_component` varchar(255) NOT NULL,
	   `opening_site` VARCHAR( 20 ) NOT NULL, 
	  `opening_site_url` VARCHAR( 255 ) NOT NULL, 
	  `opening_site_home` INT( 1 ) NOT NULL,
	  `menuitem_login` int(11) NOT NULL DEFAULT '0',
	  `menuitem_open` int(11) NOT NULL DEFAULT '0',
	  `menuitem_logout` int(11) NOT NULL DEFAULT '0',
	  `dynamic_login` int(11) NOT NULL DEFAULT '0',
	  `dynamic_open` int(11) NOT NULL DEFAULT '0',
	  `dynamic_logout` int(11) NOT NULL DEFAULT '0',
	  `open_type` VARCHAR( 50 ) NOT NULL,
	  `inherit_login` INT( 11 ) NOT NULL DEFAULT '0',
		`inherit_open` INT( 11 ) NOT NULL DEFAULT '0',
		`inherit_logout` INT( 11 ) NOT NULL DEFAULT '0',
		`inherit_backend` INT( 11 ) NOT NULL DEFAULT '0',
	  PRIMARY KEY (`id`)
	)");
		$db->query();
		
			//add opening_site-stuff to usergroup table when updating
	$db->setQuery("SHOW COLUMNS FROM #__redirectonlogin_groups ");
	$columns = $db->loadColumn();			
	if(!in_array('opening_site', $columns)){
		$db->setQuery("ALTER TABLE #__redirectonlogin_groups ADD `opening_site` VARCHAR( 20 ) NOT NULL, ADD `opening_site_url` VARCHAR( 255 ) NOT NULL, ADD `opening_site_home` INT( 1 ) NOT NULL  ");			
		$db->query();		
	}	
	
		//from version 2.0.0
		//add extra columns if needed					
		if(!in_array('menuitem_open', $columns)){
			$db->setQuery("ALTER TABLE #__redirectonlogin_groups 
			ADD `menuitem_login` INT( 11 ) NOT NULL DEFAULT '0' , 
			ADD `menuitem_open` INT( 11 ) NOT NULL DEFAULT '0' ,
			ADD `menuitem_logout` INT( 11 ) NOT NULL DEFAULT '0' ,
			ADD `dynamic_login` INT( 11 ) NOT NULL DEFAULT '0' ,
			ADD `dynamic_open` INT( 11 )NOT NULL DEFAULT '0' ,
			ADD `dynamic_logout` INT( 11 ) NOT NULL DEFAULT '0',
			ADD `open_type` VARCHAR( 50 ) NOT NULL,
			ADD `inherit_login` INT( 11 ) NOT NULL DEFAULT '0',
			ADD `inherit_open` INT( 11 ) NOT NULL DEFAULT '0',
			ADD `inherit_logout` INT( 11 ) NOT NULL DEFAULT '0',
			ADD `inherit_backend` INT( 11 ) NOT NULL DEFAULT '0'
			");			
			$db->query();	
		}	
	
		$db->setQuery("CREATE TABLE IF NOT EXISTS #__redirectonlogin_levels (
	  `id` int(11) NOT NULL auto_increment,
	  `group_id` int(11) NOT NULL,
	  `frontend_type` varchar(255) NOT NULL,
	  `frontend_url` varchar(255) NOT NULL,
	  `frontend_type_logout` varchar(255) NOT NULL,
	  `frontend_url_logout` varchar(255) NOT NULL,
	    `opening_site` VARCHAR( 20 ) NOT NULL, 
	  `opening_site_url` VARCHAR( 255 ) NOT NULL, 
	  `opening_site_home` INT( 1 ) NOT NULL,
	   `menuitem_login` int(11) NOT NULL DEFAULT '0',
	  `menuitem_open` int(11) NOT NULL DEFAULT '0',
	  `menuitem_logout` int(11) NOT NULL DEFAULT '0',
	  `dynamic_login` int(11) NOT NULL DEFAULT '0',
	  `dynamic_open` int(11) NOT NULL DEFAULT '0',
	  `dynamic_logout` int(11) NOT NULL DEFAULT '0',
	  `open_type` VARCHAR( 50 ) NOT NULL,
	   `inherit_login` INT( 11 ) NOT NULL DEFAULT '0',
		`inherit_open` INT( 11 ) NOT NULL DEFAULT '0',
		`inherit_logout` INT( 11 ) NOT NULL DEFAULT '0',
	  PRIMARY KEY (`id`)
	)");
		$db->query();
		
			//add opening_site-stuff to usergroup table when updating
	$db->setQuery("SHOW COLUMNS FROM #__redirectonlogin_levels ");
	$columns = $db->loadColumn();			
	if(!in_array('opening_site', $columns)){
		$db->setQuery("ALTER TABLE #__redirectonlogin_levels ADD `opening_site` VARCHAR( 20 ) NOT NULL, ADD `opening_site_url` VARCHAR( 255 ) NOT NULL, ADD `opening_site_home` INT( 1 ) NOT NULL  ");			
		$db->query();		
	}	
	
		//from version 2.0.0
		//add extra columns if needed					
		if(!in_array('menuitem_open', $columns)){
			$db->setQuery("ALTER TABLE #__redirectonlogin_levels 
			ADD `menuitem_login` INT( 11 ) NOT NULL DEFAULT '0' , 
			ADD `menuitem_open` INT( 11 ) DEFAULT '0' ,
			ADD `menuitem_logout` INT( 11 ) DEFAULT '0' ,
			ADD `dynamic_login` INT( 11 ) DEFAULT '0' ,
			ADD `dynamic_open` INT( 11 ) DEFAULT '0' ,
			ADD `dynamic_logout` INT( 11 ) DEFAULT '0',
			ADD `open_type` VARCHAR( 50 ) NOT NULL,
			ADD `inherit_login` INT( 11 ) NOT NULL DEFAULT '0',
			ADD `inherit_open` INT( 11 ) NOT NULL DEFAULT '0',
			ADD `inherit_logout` INT( 11 ) NOT NULL DEFAULT '0'
			");			
			$db->query();	
		}
		
		$db->setQuery("CREATE TABLE IF NOT EXISTS #__redirectonlogin_map (
	  `id` int(11) NOT NULL auto_increment,
	  `group_id` int(11) NOT NULL,
	  `level_id` int(11) NOT NULL,
	  `level_title` varchar(255) NOT NULL,
	  PRIMARY KEY (`id`)
	)");
		$db->query();
		
		$db->setQuery("CREATE TABLE IF NOT EXISTS #__redirectonlogin_order_groups (
	  `id` int(11) NOT NULL auto_increment,
	  `group_id` int(11) NOT NULL,
	  `redirect_order_front` int(11) NOT NULL,
	  `redirect_order_back` int(11) NOT NULL,
	  PRIMARY KEY (`id`)
	)");
		$db->query();
		
			 
		
		//check if groups order is empty, if so insert default order for fresh install
		$db->setQuery("SELECT id FROM #__redirectonlogin_order_groups LIMIT 1 ");
		$rol_group_orders = $db -> loadObjectList();
		$group_orders = 0;
		foreach($rol_group_orders as $rol_group_order){
			$group_orders = 1;
		}
		
		//if no groups orders in table, insert default orders for fresh install
		if(!$group_orders){
			$db->setQuery("INSERT INTO #__redirectonlogin_order_groups (`id`, `group_id`, `redirect_order_front`, `redirect_order_back`) VALUES
			(1, 1, 100, 100),
			(2, 6, 30, 30),
			(3, 7, 20, 20),
			(4, 8, 10, 10),
			(5, 2, 90, 90),
			(6, 3, 80, 80),
			(7, 4, 60, 60),
			(8, 5, 40, 40),
			(9, 10, 50, 50),
			(10, 12, 70, 70)
			");
			$db->query();
		}
		
		$db->setQuery("CREATE TABLE IF NOT EXISTS #__redirectonlogin_order_levels (
	  `id` int(11) NOT NULL auto_increment,
	  `level_id` int(11) NOT NULL,
	  `redirect_order` int(11) NOT NULL,
	  PRIMARY KEY (`id`)
	)");
		$db->query();
		
		//check if levels order is empty, if so insert default order for fresh install
		$db->setQuery("SELECT id FROM #__redirectonlogin_order_levels LIMIT 1 ");
		$rol_level_orders = $db -> loadObjectList();
		$level_orders = 0;
		foreach($rol_level_orders as $rol_level_order){
			$level_orders = 1;
		}
		
		//if no level orders in table, insert default orders for fresh install
		if(!$level_orders){
			$db->setQuery("INSERT INTO #__redirectonlogin_order_levels (`id`, `level_id`, `redirect_order`) VALUES
			(1, 4, 20),
			(2, 1, 40),
			(3, 2, 30),
			(4, 3, 10)
			");
			$db->query();
		}
		
		$db->setQuery("CREATE TABLE IF NOT EXISTS #__redirectonlogin_users (
	  `id` int(11) NOT NULL auto_increment,
	  `user_id` int(11) NOT NULL,
	  `frontend_type` varchar(255) NOT NULL,
	  `frontend_url` varchar(255) NOT NULL,
	  `frontend_type_logout` varchar(255) NOT NULL,
	  `frontend_url_logout` varchar(255) NOT NULL,
	  `backend_type` varchar(255) NOT NULL,
	  `backend_url` varchar(255) NOT NULL,
	  `backend_component` varchar(255) NOT NULL,
	  `opening_site` VARCHAR( 20 ) NOT NULL, 
	  `opening_site_url` VARCHAR( 255 ) NOT NULL, 
	  `opening_site_home` INT( 1 ) NOT NULL,
	   `menuitem_login` int(11) NOT NULL DEFAULT '0',
	  `menuitem_open` int(11) NOT NULL DEFAULT '0',
	  `menuitem_logout` int(11) NOT NULL DEFAULT '0',
	  `dynamic_login` int(11) NOT NULL DEFAULT '0',
	  `dynamic_open` int(11) NOT NULL DEFAULT '0',
	  `dynamic_logout` int(11) NOT NULL DEFAULT '0',
	  `open_type` VARCHAR( 50 ) NOT NULL,	  
	  `open_front_logout` INT NOT NULL,
	  `open_back_logout` INT NOT NULL,
	  PRIMARY KEY (`id`)
	)");
		$db->query();	
		
		//add opening_site-stuff to user table when updating
	$db->setQuery("SHOW COLUMNS FROM #__redirectonlogin_users ");
	$columns = $db->loadColumn();			
	if(!in_array('opening_site', $columns)){
		$db->setQuery("ALTER TABLE #__redirectonlogin_users ADD `opening_site` VARCHAR( 20 ) NOT NULL, ADD `opening_site_url` VARCHAR( 255 ) NOT NULL, ADD `opening_site_home` INT( 1 ) NOT NULL  ");			
		$db->query();		
	}	
	
	//from version 2.0.0
		//add extra columns if needed					
		if(!in_array('menuitem_open', $columns)){
			$db->setQuery("ALTER TABLE #__redirectonlogin_users 
			ADD `menuitem_login` INT( 11 ) NOT NULL DEFAULT '0' , 
			ADD `menuitem_open` INT( 11 ) DEFAULT '0' ,
			ADD `menuitem_logout` INT( 11 ) DEFAULT '0' ,
			ADD `dynamic_login` INT( 11 ) DEFAULT '0' ,
			ADD `dynamic_open` INT( 11 ) DEFAULT '0' ,
			ADD `dynamic_logout` INT( 11 ) DEFAULT '0',
			ADD `open_type` VARCHAR( 50 ) NOT NULL,
			ADD `open_front_logout` INT NOT NULL,
			ADD `open_back_logout` INT NOT NULL
			");			
			$db->query();	
		}
	  
		//dynamic redirects table
		$db->setQuery("CREATE TABLE IF NOT EXISTS #__redirectonlogin_dynamics (
		  `id` int(11) NOT NULL auto_increment,
		  `name` varchar(255) NOT NULL,
		  `value` text NOT NULL,
		  `type` varchar(100) NOT NULL,
		  `ordering` int(11) NOT NULL,
		  PRIMARY KEY (`id`)
		)");
		$db->query();
		
		//sessions table
		$db->setQuery("CREATE TABLE IF NOT EXISTS #__redirectonlogin_sessions (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`session_id` varchar(200) NOT NULL,
		`url` varchar(500) NOT NULL,
		`message` varchar(500) NOT NULL,		
		`message_type` VARCHAR( 100 ) NOT NULL,		
		`unixtime` varchar(14) NOT NULL,
		`opening_site` int(1) NOT NULL,
		`ip` varchar(100) NOT NULL,
		`opening_site_home` int(1) NOT NULL,
		`logout` int(1) NOT NULL,
		`silent` int(1) NOT NULL,		
		PRIMARY KEY (`id`)
		)");
		$db->query();			
	
		//check if config is empty, if so insert default config
		$rol_config = '';
		$db->setQuery("SELECT * FROM #__redirectonlogin_config WHERE id='1' LIMIT 1 ");
		$rows = $db -> loadObjectList();		
		foreach($rows as $row){
			$rol_config = $row->config;			
		}
		
		if($rol_config==''){		
			$configuration = 'enable_redirection=no
redirect_type_backend=none
redirect_component_backend=0
redirect_url_backend=
frontend_u_or_a=u
redirect_type_frontend=none
redirect_url_frontend=
redirect_type_frontend_logout=none
redirect_url_frontend_logout=
version_checker=true
logout_message_frontend=COM_REDIRECTONLOGIN_YOU_CANT_LOGIN
logout_message_backend=COM_REDIRECTONLOGIN_YOU_CANT_LOGIN
opening_site=no
opening_site_url=
opening_site_type=loggedin
opening_site_home=true
menuitem_login=
menuitem_open=
menuitem_logout=
dynamic_login=
dynamic_open=
dynamic_logout=
opening_site_type2=menuitem
after_no_access_page=rol
multilanguage_menu_association=true
lang_type_login_front=langfile
lang_type_login_back=langfile
';
	
			//insert fresh config
			$db->setQuery( "INSERT INTO #__redirectonlogin_config SET id='1', config='$configuration'");
			$db->query();
		
		}else{
			//there is a config
			//see if it needs updating
			
			$updated_config = $rol_config;
			$config_needs_updating = 0;	
			
			//added in version 1.1.0
			if(!strpos($rol_config, 'logout_message_frontend=')){
				$updated_config .= 'logout_message_frontend=COM_REDIRECTONLOGIN_YOU_CANT_LOGIN
logout_message_backend=COM_REDIRECTONLOGIN_YOU_CANT_LOGIN
';
				$config_needs_updating = 1;
			}
			
			//added in version 1.2.0
			if(!strpos($rol_config, 'opening_site=')){
				$updated_config .= 'opening_site=no
opening_site_url=
opening_site_type=loggedin
opening_site_home=true
';
				$config_needs_updating = 1;
			}	
			
			//added in version 2.0.0
			if(!strpos($rol_config, 'menuitem_login=')){
				$updated_config .= 'menuitem_login=
menuitem_open=
menuitem_logout=
dynamic_login=
dynamic_open=
dynamic_logout=
opening_site_type2=menuitem
';
				$config_needs_updating = 1;
			}	
			
			//added in version 2.1.0
			if(!strpos($rol_config, 'after_no_access_page=')){
				$updated_config .= 'after_no_access_page=rol
';
				$config_needs_updating = 1;
			}
			
			//added in version 2.2.0
			if(!strpos($rol_config, 'multilanguage_menu_association=')){
				$updated_config .= 'multilanguage_menu_association=true
lang_type_login_front=custom
lang_type_login_back=custom
';
				$config_needs_updating = 1;
			}			
			
			if($config_needs_updating){
				$updated_config = addslashes($updated_config);
				$db->setQuery( "UPDATE #__redirectonlogin_config SET config='$updated_config' WHERE id='1' ");
				$db->query();
			}	
		}		
			
		//install system plugin
		$plgSrc = JPATH_ADMINISTRATOR.$ds.'components'.$ds.'com_redirectonlogin'.$ds.'plugin_system'.$ds;
		$plgDst = JPATH_ROOT.$ds.'plugins'.$ds.'system'.$ds.'redirectonlogin'.$ds;
		if(!file_exists($plgDst)){
			mkdir($plgDst);	
		}
		$system_plugin_success = 0;
		$system_plugin_success = JFile::copy($plgSrc.'redirectonlogin.php', $plgDst.'redirectonlogin.php');
		JFile::copy($plgSrc.'redirectonlogin.xml', $plgDst.'redirectonlogin.xml');
		JFile::copy($plgSrc.'index.html', $plgDst.'index.html');
		
		if($system_plugin_success){
			echo '<p style="color: #5F9E30;">system plugin installed</p>';		
			//enable plugin
			$db->setQuery("SELECT extension_id, enabled FROM #__extensions WHERE type='plugin' AND element='redirectonlogin' AND folder='system' LIMIT 1 ");
			$rows = $db->loadObjectList();
			$system_plugin_id = 0;
			$system_plugin_enabled = 0;
			foreach($rows as $row){	
				$system_plugin_id = $row->extension_id;
				$system_plugin_enabled = $row->enabled;
			}
			if($system_plugin_id){
				//plugin is already installed
				//if(!$system_plugin_enabled){
					//publish plugin and set access
					$db->setQuery( "UPDATE #__extensions SET enabled='1', access='1' WHERE extension_id='$system_plugin_id' ");
					$db->query();
				//}
			}else{
				//insert plugin and enable it
				$manifest_cache = '{"legacy":false,"name":"System - Redirect On Login","type":"plugin","creationDate":"march 2013","author":"Carsten Engel","copyright":"Copyright (C) 2010-2013 Carsten Engel, pages-and-items. All rights reserved.","authorEmail":"-","authorUrl":"www.pages-and-items.com","version":"3.0.0","description":"Redirects users on login \/ logout \/ opening site. Per usergroup \/ accesslevel \/ user \/ all. Backend and frontend. System plugin of component Redirect-on-Login.","group":""}';
				$manifest_cache = addslashes($manifest_cache);
				$db->setQuery( "INSERT INTO #__extensions SET name='System - Redirect on Login', type='plugin', element='redirectonlogin', folder='system', enabled='1', access='1', manifest_cache='$manifest_cache' ");
				$db->query();
			}
			echo '<p style="color: #5F9E30;">system plugin enabled</p>';		
		}else{
			echo '<p style="color: red;">system plugin not installed</p><p><a href="http://www.pages-and-items.com/extensions/redirect-on-login/installation" target="_blank">download the system plugin</a> and install with the Joomla installer.</p>';
		}
		
		
		//install user plugin	
		$plgSrc = JPATH_ADMINISTRATOR.$ds.'components'.$ds.'com_redirectonlogin'.$ds.'plugin_user'.$ds;
		$plgDst = JPATH_ROOT.$ds.'plugins'.$ds.'user'.$ds.'redirectonlogin'.$ds;
		if(!file_exists($plgDst)){
			mkdir($plgDst);	
		}
		$user_plugin_success = 0;
		$user_plugin_success = JFile::copy($plgSrc.'redirectonlogin.php', $plgDst.'redirectonlogin.php');
		JFile::copy($plgSrc.'redirectonlogin.xml', $plgDst.'redirectonlogin.xml');
		JFile::copy($plgSrc.'index.html', $plgDst.'index.html');
		
		if($user_plugin_success){
			echo '<p style="color: #5F9E30;">user plugin installed</p>';		
			//enable plugin
			$db->setQuery("SELECT extension_id, enabled FROM #__extensions WHERE type='plugin' AND element='redirectonlogin' AND folder='user' LIMIT 1 ");
			$rows = $db->loadObjectList();
			$user_plugin_id = 0;
			$user_plugin_enabled = 0;
			foreach($rows as $row){	
				$user_plugin_id = $row->extension_id;
				$user_plugin_enabled = $row->enabled;
			}
			if($user_plugin_id){
				//plugin is already installed
				//if(!$user_plugin_enabled){
					//publish plugin and set access
					$db->setQuery( "UPDATE #__extensions SET enabled='1', access='1' WHERE extension_id='$user_plugin_id' ");
					$db->query();
				//}
			}else{
				//insert plugin and enable it
				$manifest_cache = '{"legacy":false,"name":"User - Redirect On Login","type":"plugin","creationDate":"march 2013","author":"Carsten Engel","copyright":"Copyright (C) 2010-2013 Carsten Engel, pages-and-items. All rights reserved.","authorEmail":"-","authorUrl":"www.pages-and-items.com","version":"3.0.0","description":"Redirects users on login \/ logout \/ opening site. Per usergroup \/ accesslevel \/ user \/ all. Backend and frontend. User plugin of component Redirect-on-Login.","group":""}';
				$manifest_cache = addslashes($manifest_cache);
				$db->setQuery( "INSERT INTO #__extensions SET name='User - Redirect on Login', type='plugin', element='redirectonlogin', folder='user', enabled='1', access='1', manifest_cache='$manifest_cache' ");
				$db->query();
			}
			echo '<p style="color: #5F9E30;">user plugin enabled</p>';		
		}else{
			echo '<p style="color: red;">user plugin not installed</p><p><a href="http://www.pages-and-items.com/extensions/redirect-on-login/installation" target="_blank">download the user plugin</a> and install with the Joomla installer.</p>';
		}
		
		//reset version checker session var
		$app = &JFactory::getApplication();
		$app->setUserState( "com_redirectonlogin.latest_version_message", '' );
		
		//delete deprecated xml file
		$logoutxml = JPATH_ROOT.$ds.'components'.$ds.'com_redirectonlogin'.$ds.'views'.$ds.'logout'.$ds.'tmpl'.$ds.'logout.xml';
		if(file_exists($logoutxml)){
			JFile::delete($logoutxml);
		}	
		
		$this->display_install_page();			
	}		
	
	public function uninstall($installer){
	
		
		$db = JFactory::getDBO();
		$ds = DIRECTORY_SEPARATOR;			
		
		//delete system plugin
		$plugin_php = JPATH_PLUGINS.$ds.'system'.$ds.'redirectonlogin'.$ds.'redirectonlogin.php';
		$plugin_xml = JPATH_PLUGINS.$ds.'system'.$ds.'redirectonlogin'.$ds.'redirectonlogin.xml';
		$system_plugin_success = 0;
		if(file_exists($plugin_php) && file_exists($plugin_xml)){
			$system_plugin_success = JFile::delete($plugin_php);
			JFile::delete($plugin_xml);
		}		
		if($system_plugin_success){
			echo '<p style="color: #5F9E30;">system plugin succesfully uninstalled</p>';
			JFolder::delete(JPATH_PLUGINS.$ds.'system'.$ds.'redirectonlogin');		
		}else{
			echo '<p style="color: red;">could not uninstall system plugin</p>';
		}	
		$db->setQuery("DELETE FROM #__extensions WHERE type='plugin' AND folder='system' AND element='redirectonlogin' LIMIT 1");
		$db->query(); 
		
		//delete user plugin
		$plugin_php = JPATH_PLUGINS.$ds.'user'.$ds.'redirectonlogin'.$ds.'redirectonlogin.php';
		$plugin_xml = JPATH_PLUGINS.$ds.'user'.$ds.'redirectonlogin'.$ds.'redirectonlogin.xml';
		$user_plugin_success = 0;
		if(file_exists($plugin_php) && file_exists($plugin_xml)){
			$user_plugin_success = JFile::delete($plugin_php);
			JFile::delete($plugin_xml);
		}	
		if($user_plugin_success){
			echo '<p style="color: #5F9E30;">user plugin succesfully uninstalled</p>';	
			JFolder::delete(JPATH_PLUGINS.$ds.'user'.$ds.'redirectonlogin');
		}else{
			echo '<p style="color: red;">could not uninstall user plugin</p>';
		}	
		$db->setQuery("DELETE FROM #__extensions WHERE type='plugin' AND folder='user' AND element='redirectonlogin' LIMIT 1");
		$db->query();
		
		//delete tables
		$tables_to_drop = array();
		$tables_to_drop[] = '#__redirectonlogin_config';
		$tables_to_drop[] = '#__redirectonlogin_dynamics';
		$tables_to_drop[] = '#__redirectonlogin_groups';
		$tables_to_drop[] = '#__redirectonlogin_levels';
		$tables_to_drop[] = '#__redirectonlogin_map';
		$tables_to_drop[] = '#__redirectonlogin_order_groups';
		$tables_to_drop[] = '#__redirectonlogin_order_levels';
		$tables_to_drop[] = '#__redirectonlogin_sessions';
		$tables_to_drop[] = '#__redirectonlogin_users';
		for($n = 0; $n < count($tables_to_drop); $n++){
			$query = $db->getQuery(true);
			$query = 'DROP TABLE IF EXISTS '.$db->quoteName($tables_to_drop[$n]);
			$db->setQuery((string)$query);
			$db->query();
		}
		
		//delete deprecated files
		$path_models = JPATH_ROOT.$ds.'components'.$ds.'com_redirectonlogin'.$ds.'models'.$ds;
		$models_to_delete = array();
		$models_to_delete[] = 'accesslevel';
		$models_to_delete[] = 'dynamicredirect';
		$models_to_delete[] = 'usergroup';
		$models_to_delete[] = 'user';
		for($n = 0; $n < count($models_to_delete); $n++){
			JFile::delete($path_models.$models_to_delete[$n].'.php');			
		}
		
		$this->display_uninstall_page();
		
    }
	
	function display_install_page(){
		?>
<div style="width: 1000px; text-align: left; background: url(components/com_redirectonlogin/images/icon.png) 10px 0 no-repeat;">
	<h2 style="padding: 10px 0 10px 70px;">Redirect on Login</h2>	
	<div style="width: 1000px; overflow: hidden;">
		<div style="width: 270px; float: left;">
			<p>
				Thank you for using Redirect-on-Login.		
			</p>
			<p>
				<input type="button" value="Go to Redirect-on-Login configuration" onclick="document.location.href='index.php?option=com_redirectonlogin';" />				
			</p>
		</div>
		<div style="width: 380px; float: left;">
			<p>
				With Redirect-on-Login you can set a redirect on actions:
				<ul>
					<li>login</li>
					<li>opening site (new browser session)</li>
					<li>logout</li>				
				</ul>
			</p>
			<p>
				for:
				<ul>
					<li>all users</li>
					<li>users per usergroup</li>
					<li>users per accesslevel (frontend only)</li>
					<li>specific users</li>			
				</ul>
			</p>
			<p>
				at:
				<ul>
					<li>frontend</li>			
					<li>backend</li>				
				</ul>
			</p>
		</div>
		<div style="width: 330px; float: left;">
			<p>
				Check <a href="http://www.pages-and-items.com" target="_blank">www.pages-and-items.com</a> for:
			<ul>
				<li><a href="http://www.pages-and-items.com/extensions/redirect-on-login" target="_blank">updates</a></li>
				<li><a href="http://www.pages-and-items.com/extensions/redirect-on-login/faqs" target="_blank">FAQs</a></li>	
				<li><a href="http://www.pages-and-items.com/forum/38-redirect-on-login" target="_blank">support forum</a></li>	
				<li><a href="http://www.pages-and-items.com/component/comprofiler/registers" target="_blank">email notification service for updates and new extensions</a></li>	
				<li><a href="http://www.pages-and-items.com/extensions/redirect-on-login/update-notifications-for-redirect-on-login" target="_blank">subscribe to RSS feed update notifications</a></li>	
			</ul>
			</p>
			<p>
				Follow us on <a href="http://twitter.com/PagesAndItems" target="_blank">twitter</a> (only update notifications).		
			</p>
		</div>
	</div>	
</div>
		<?php
	}
	
	function display_uninstall_page(){
		?>
<div style="width: 500px; text-align: left;">
	<h2 style="padding-left: 10px;">Redirect-on-Login</h2>	
	<p>
		Thank you for having used Redirect-on-Login.
	</p>
	<p>
		Why did you uninstall Redirect-on-Login? Missing any features? <a href="http://www.pages-and-items.com/" target="_blank">Let us know</a>.		
	</p>	
	<p>
		Check <a href="http://www.pages-and-items.com/" target="_blank">www.pages-and-items.com</a> for:
		<ul>
			<li><a href="http://www.pages-and-items.com/extensions/redirect-on-login" target="_blank">updates</a></li>
			<li><a href="http://www.pages-and-items.com/extensions/redirect-on-login/faqs" target="_blank">FAQs</a></li>	
			<li><a href="http://www.pages-and-items.com/forum/38-redirect-on-login" target="_blank">support forum</a></li>	
			<li><a href="http://www.pages-and-items.com/my-account/email-update-notifications" target="_blank">email notification service for updates and new extensions</a></li>	
			<li><a href="http://www.pages-and-items.com/extensions/redirect-on-login/update-notifications-for-redirect-on-login" target="_blank">subscribe to RSS feed update notifications</a></li>			
		</ul>
	</p>	
</div>
		<?php
	}
	
	
}

?>
