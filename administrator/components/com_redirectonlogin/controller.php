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

jimport('joomla.application.component.controller');

class redirectonloginController extends JController{	

	public $db;
	public $rol_config;
	public $rol_demo_seconds_left;
	public $rol_version = '3.1.0';
	private $rol_version_type = 'free';
	private $helper;

	function display(){	
		
		// Set a default view if none exists
		if (!JRequest::getVar('view')){			
			JRequest::setVar('view', 'configuration' );
		}
		
		//set title			
		JToolBarHelper::title('Redirect on login','rol_icon');			
		
		if(JRequest::getVar('layout', '')!='csv'){
		
			//display css
			$document = JFactory::getDocument();	
			$document->addStyleSheet('components/com_redirectonlogin/css/redirectonlogin3.css');
			
			$version = new JVersion;			
			echo '<div';
			if($version->RELEASE >= '3.0'){
				echo ' class="joomla3"';
			}
			echo '>';
			
			//display trial-version stuff
			$this->display_trial_version_stuff();
			
			//display message if not enabled
			$this->not_enabled_message();
		
			
			if($version->RELEASE >= '3.0'){
				//bootstrap selects
				JHtml::_('bootstrap.tooltip');
				JHtml::_('behavior.multiselect');
				JHtml::_('formbehavior.chosen', 'select');
			}else{	
				//make sure mootools is loaded					
				JHTML::_('behavior.mootools');
				
				// Load the submenu				
				$this->helper->addSubmenu(JRequest::getWord('view', 'redirectonlogin'));
			}		
			
		}
		
		parent::display();		
		
		//display footer
		if(JRequest::getVar('layout', '')!='csv'){
			echo '</div>';
			$this->display_footer();
		}	
	}
		
	function __construct(){	
	
		$this->db = JFactory::getDBO();	
		$this->rol_config = $this->get_config();
		$this->helper = $this->get_helper();			
							
		parent::__construct();		
	}	
	
	function usergroup_save(){
	
		// Check for request forgeries 
		JRequest::checkToken() or jexit('Invalid Token');
		
		$group_id = intval(JRequest::getVar('group_id', ''));
		
		$redirect_id = intval(JRequest::getVar('redirect_id', ''));
		
		$frontend_type = JRequest::getVar('redirect_frontend_type', '');
		$frontend_url = JRequest::getVar('frontend_url', '');	
		$frontend_type_logout = JRequest::getVar('redirect_frontend_type_logout', '');
		$frontend_url_logout = JRequest::getVar('frontend_url_logout', '');	
		$backend_type = JRequest::getVar('redirect_backend_type', '');
		$backend_url = JRequest::getVar('backend_url', '');
		$backend_component = JRequest::getVar('backend_component', '');	
		$opening_site = JRequest::getVar('opening_site', '');	
		$opening_site_url = JRequest::getVar('opening_site_url', '');	
		$opening_site_home = JRequest::getVar('opening_site_home', '');		
		$menuitem_login = JRequest::getVar('menuitem_login', 0);
		$menuitem_open = JRequest::getVar('menuitem_open', 0);
		$menuitem_logout = JRequest::getVar('menuitem_logout', 0);
		$dynamic_login = JRequest::getVar('dynamic_login', 0);
		$dynamic_open = JRequest::getVar('dynamic_open', 0);
		$dynamic_logout = JRequest::getVar('dynamic_logout', 0);
		$open_type = JRequest::getVar('open_type', 'url');
		$inherit_login = JRequest::getVar('inherit_login', 0);
		$inherit_open = JRequest::getVar('inherit_open', 0);
		$inherit_logout = JRequest::getVar('inherit_logout', 0);
		$inherit_backend = JRequest::getVar('inherit_backend', 0);
		
		$database = JFactory::getDBO();
		
		if($redirect_id){
			//update			
			$database->setQuery( "UPDATE #__redirectonlogin_groups SET group_id='$group_id', frontend_type='$frontend_type', frontend_url='$frontend_url', frontend_type_logout='$frontend_type_logout', frontend_url_logout='$frontend_url_logout', backend_type='$backend_type', backend_url='$backend_url', backend_component='$backend_component', opening_site='$opening_site', opening_site_url='$opening_site_url', opening_site_home='$opening_site_home', menuitem_login='$menuitem_login', menuitem_open='$menuitem_open', menuitem_logout='$menuitem_logout', dynamic_login='$dynamic_login', dynamic_open='$dynamic_open', dynamic_logout='$dynamic_logout', open_type='$open_type', inherit_login='$inherit_login', inherit_open='$inherit_open', inherit_logout='$inherit_logout', inherit_backend='$inherit_backend' WHERE id='$redirect_id' "	);
			$database->query();	
		}else{
			//insert
			$database->setQuery( "INSERT INTO #__redirectonlogin_groups SET group_id='$group_id',  frontend_type='$frontend_type', frontend_url='$frontend_url', frontend_type_logout='$frontend_type_logout', frontend_url_logout='$frontend_url_logout', backend_type='$backend_type', backend_url='$backend_url', backend_component='$backend_component', opening_site='$opening_site', opening_site_url='$opening_site_url', opening_site_home='$opening_site_home', menuitem_login='$menuitem_login', menuitem_open='$menuitem_open', menuitem_logout='$menuitem_logout', dynamic_login='$dynamic_login', dynamic_open='$dynamic_open', dynamic_logout='$dynamic_logout', open_type='$open_type', inherit_login='$inherit_login', inherit_open='$inherit_open', inherit_logout='$inherit_logout', inherit_backend='$inherit_backend'  ");
			$database->query();
		}
		
		//redirect
		$url = 'index.php?option=com_redirectonlogin&view=usergroups';
		if(JRequest::getVar('apply', 0)){
			$url = 'index.php?option=com_redirectonlogin&view=usergroup&group_id='.$group_id;
		}		
		$app = JFactory::getApplication();
		$app->redirect($url, JText::_('COM_REDIRECTONLOGIN_REDIRECT_SAVED'));
	}
	
	function accesslevel_save(){
	
		// Check for request forgeries 
		JRequest::checkToken() or jexit('Invalid Token');
		
		$redirect_id = intval(JRequest::getVar('redirect_id', ''));
		$group_id = intval(JRequest::getVar('group_id', ''));
		$frontend_type  = JRequest::getVar('redirect_type', 'none');
		$frontend_url  = JRequest::getVar('frontend_url', '');	
		$frontend_type_logout  = JRequest::getVar('redirect_type_logout', 'none');
		$frontend_url_logout  = JRequest::getVar('frontend_url_logout', '');
		$opening_site = JRequest::getVar('opening_site', '');	
		$opening_site_url = JRequest::getVar('opening_site_url', '');	
		$opening_site_home = JRequest::getVar('opening_site_home', '');	
		$menuitem_login = JRequest::getVar('menuitem_login', 0);
		$menuitem_open = JRequest::getVar('menuitem_open', 0);
		$menuitem_logout = JRequest::getVar('menuitem_logout', 0);
		$dynamic_login = JRequest::getVar('dynamic_login', 0);
		$dynamic_open = JRequest::getVar('dynamic_open', 0);
		$dynamic_logout = JRequest::getVar('dynamic_logout', 0);
		$open_type = JRequest::getVar('open_type', 'url');	
		$inherit_login = JRequest::getVar('inherit_login', 0);
		$inherit_open = JRequest::getVar('inherit_open', 0);
		$inherit_logout = JRequest::getVar('inherit_logout', 0);	
		
		$database = JFactory::getDBO();
		if($redirect_id){
			//update				
			$database->setQuery( "UPDATE #__redirectonlogin_levels SET frontend_type='$frontend_type', frontend_url='$frontend_url', frontend_type_logout='$frontend_type_logout', frontend_url_logout='$frontend_url_logout', opening_site='$opening_site', opening_site_url='$opening_site_url', opening_site_home='$opening_site_home', menuitem_login='$menuitem_login', menuitem_open='$menuitem_open', menuitem_logout='$menuitem_logout', dynamic_login='$dynamic_login', dynamic_open='$dynamic_open', dynamic_logout='$dynamic_logout', open_type='$open_type', inherit_login='$inherit_login', inherit_open='$inherit_open', inherit_logout='$inherit_logout' WHERE id='$redirect_id' ");
			$database->query();
		}else{
			//insert
			$database->setQuery( "INSERT INTO #__redirectonlogin_levels SET group_id='$group_id', frontend_type='$frontend_type', frontend_url='$frontend_url', frontend_type_logout='$frontend_type_logout', frontend_url_logout='$frontend_url_logout', opening_site='$opening_site', opening_site_url='$opening_site_url', opening_site_home='$opening_site_home', menuitem_login='$menuitem_login', menuitem_open='$menuitem_open', menuitem_logout='$menuitem_logout', dynamic_login='$dynamic_login', dynamic_open='$dynamic_open', dynamic_logout='$dynamic_logout', open_type='$open_type', inherit_login='$inherit_login', inherit_open='$inherit_open', inherit_logout='$inherit_logout' ");
			$database->query();
		}
			
		//redirect
		$url = 'index.php?option=com_redirectonlogin&view=accesslevels';
		if(JRequest::getVar('apply', 0)){
			$url = 'index.php?option=com_redirectonlogin&view=accesslevel&group_id='.$group_id;
		}		
		$app = JFactory::getApplication();
		$app->redirect($url, JText::_('COM_REDIRECTONLOGIN_REDIRECT_SAVED'));
	}
	
	function get_config(){	
			
		$database = JFactory::getDBO();			
		
		$database->setQuery("SELECT config "
		."FROM #__redirectonlogin_config "
		."WHERE id='1' "
		."LIMIT 1"
		);		
		$raw = $database->loadResult();		
		
		$params = explode( "\n", $raw);
		
		for($n = 0; $n < count($params); $n++){		
			$temp = explode('=',$params[$n]);
			$var = $temp[0];
			$value = '';
			if(count($temp)==2){
				$value = trim($temp[1]);
				/*
				if($value=='false'){
					$value = false;
				}
				if($value=='true'){
					$value = true;
				}
				*/
			}							
			$config[$var] = $value;	
		}	
		
		//reformat redirect urls		
		$config['redirect_url_backend'] = str_replace('[equal]','=',$config['redirect_url_backend']);	
		$config['redirect_component_backend'] = str_replace('[equal]','=',$config['redirect_component_backend']);
		$config['redirect_url_frontend'] = str_replace('[equal]','=',$config['redirect_url_frontend']);
		$config['redirect_url_frontend_logout'] = str_replace('[equal]','=',$config['redirect_url_frontend_logout']);
		$config['opening_site_url'] = str_replace('[equal]','=',$config['opening_site_url']);
		
		//get default message
		if($config['logout_message_frontend']=='COM_REDIRECTONLOGIN_YOU_CANT_LOGIN'){
			$config['logout_message_frontend'] = JText::_('COM_REDIRECTONLOGIN_YOU_CANT_LOGIN');
		}	
		if($config['logout_message_backend']=='COM_REDIRECTONLOGIN_YOU_CANT_LOGIN'){
			$config['logout_message_backend'] = JText::_('COM_REDIRECTONLOGIN_YOU_CANT_LOGIN');
		}	
				
		return $config;			
	}
	
	function config_save(){
		// Check for request forgeries 
		JRequest::checkToken() or jexit('Invalid Token');		
		
		$redirect_url_backend = JRequest::getVar('redirect_url_backend', '', 'post');
		$redirect_url_backend = str_replace('=','[equal]',$redirect_url_backend);
		$redirect_url_backend = addslashes($redirect_url_backend);
		$redirect_url_frontend = JRequest::getVar('redirect_url_frontend', '', 'post');
		$redirect_url_frontend = str_replace('=','[equal]',$redirect_url_frontend);	
		$redirect_url_frontend = addslashes($redirect_url_frontend);
		$redirect_url_frontend_logout = JRequest::getVar('redirect_url_frontend_logout', '', 'post');
		$redirect_url_frontend_logout = str_replace('=','[equal]',$redirect_url_frontend_logout);
		$redirect_url_frontend_logout = addslashes($redirect_url_frontend_logout);
		$redirect_component_backend = JRequest::getVar('redirect_component_backend', '', 'post');
		$redirect_component_backend = str_replace('=','[equal]',$redirect_component_backend);
		$opening_site_url = JRequest::getVar('opening_site_url', '', 'post');
		$opening_site_url = str_replace('=','[equal]',$opening_site_url);	
		$opening_site_url = addslashes($opening_site_url);		
		
		$config = 'enable_redirection='.JRequest::getVar('enable_redirection', '', 'post').'
redirect_type_backend='.JRequest::getVar('redirect_type_backend', 'none', 'post').'
redirect_component_backend='.$redirect_component_backend.'
redirect_url_backend='.$redirect_url_backend.'
frontend_u_or_a='.JRequest::getVar('frontend_u_or_a', '', 'post').'
redirect_type_frontend='.JRequest::getVar('redirect_type_frontend', 'none', 'post').'
redirect_url_frontend='.$redirect_url_frontend.'
redirect_type_frontend_logout='.JRequest::getVar('redirect_type_frontend_logout', 'none', 'post').'
redirect_url_frontend_logout='.$redirect_url_frontend_logout.'
version_checker='.JRequest::getVar('version_checker', '', 'post').'
logout_message_frontend='.addslashes(JRequest::getVar('logout_message_frontend', '', 'post')).'
logout_message_backend='.addslashes(JRequest::getVar('logout_message_backend', '', 'post')).'
opening_site='.JRequest::getVar('opening_site', '', 'post').'
opening_site_url='.$opening_site_url.'
opening_site_type='.JRequest::getVar('opening_site_type', '', 'post').'
opening_site_home='.JRequest::getVar('opening_site_home', '', 'post').'
menuitem_login='.JRequest::getVar('menuitem_login', '', 'post').'
menuitem_open='.JRequest::getVar('menuitem_open', '', 'post').'
menuitem_logout='.JRequest::getVar('menuitem_logout', '', 'post').'
dynamic_login='.JRequest::getVar('dynamic_login', '', 'post').'
dynamic_open='.JRequest::getVar('dynamic_open', '', 'post').'
dynamic_logout='.JRequest::getVar('dynamic_logout', '', 'post').'
opening_site_type2='.JRequest::getVar('opening_site_type2', '', 'post').'
after_no_access_page='.JRequest::getVar('after_no_access_page', '', 'post').'
multilanguage_menu_association='.JRequest::getVar('multilanguage_menu_association', '', 'post').'
lang_type_login_front='.JRequest::getVar('lang_type_login_front', '', 'post').'
lang_type_login_back='.JRequest::getVar('lang_type_login_back', '', 'post').'
';
		//update config
		$this->db->setQuery( "UPDATE #__redirectonlogin_config SET config='$config' WHERE id='1' ");
		$this->db->query();	
		
		$app = JFactory::getApplication();
		$app->redirect('index.php?option=com_redirectonlogin&view=configuration', JText::_('COM_REDIRECTONLOGIN_CONFIGURATION_SAVED'));		
	}
	
	function save_order_accesslevels(){
		$levels_order = JRequest::getVar('order', array(), 'post', 'array');
		$levels_id = JRequest::getVar('level_id', array(), 'post', 'array');
		$order_ids = JRequest::getVar('order_id', array(), 'post', 'array');		
		for($n = 0; $n < count($levels_id); $n++){		
			$level_order = $levels_order[$n];
			$level_id = $levels_id[$n];
			$order_id = $order_ids[$n];				
			if($order_id){
				//update order				
				$this->db->setQuery( "UPDATE #__redirectonlogin_order_levels SET redirect_order='$level_order' WHERE id='$order_id' ");
				$this->db->query();
			}else{
				//insert order				
				$this->db->setQuery( "INSERT INTO #__redirectonlogin_order_levels SET level_id='$level_id', redirect_order='$level_order' ");
				$this->db->query();	
			}			
		}	
		$app = JFactory::getApplication();
		$app->redirect('index.php?option=com_redirectonlogin&view=accesslevels', JText::_('COM_REDIRECTONLOGIN_ACCESSLEVEL_ORDER_SAVED'));
	}
	
	function save_order_groups_front(){
		$orders_front = JRequest::getVar('order_front', array(), 'post', 'array');
		$group_ids = JRequest::getVar('group_id', array(), 'post', 'array');
		$order_ids = JRequest::getVar('order_id', array(), 'post', 'array');			
		for($n = 0; $n < count($group_ids); $n++){		
			$order = $orders_front[$n];
			$group_id = $group_ids[$n];
			$order_id = $order_ids[$n];					
			if($order_id){
				//update order						
				$this->db->setQuery( "UPDATE #__redirectonlogin_order_groups SET redirect_order_front='$order' WHERE id='$order_id' ");
				$this->db->query();
			}else{
				//insert order							
				$this->db->setQuery( "INSERT INTO #__redirectonlogin_order_groups SET group_id='$group_id', redirect_order_front='$order' ");
				$this->db->query();	
			}					
		}		
		$app = JFactory::getApplication();
		$app->redirect('index.php?option=com_redirectonlogin&view=usergroups', JText::_('COM_REDIRECTONLOGIN_USERGROUP_ORDER_SAVED_FRONTEND'));
	}
	
	function save_order_groups_back(){
		$orders_back = JRequest::getVar('order_back', array(), 'post', 'array');
		$group_ids = JRequest::getVar('group_id', array(), 'post', 'array');
		$order_ids = JRequest::getVar('order_id', array(), 'post', 'array');			
		for($n = 0; $n < count($group_ids); $n++){		
			$order = $orders_back[$n];
			$group_id = $group_ids[$n];
			$order_id = $order_ids[$n];					
			if($order_id){
				//update order						
				$this->db->setQuery( "UPDATE #__redirectonlogin_order_groups SET redirect_order_back='$order' WHERE id='$order_id' ");
				$this->db->query();
			}else{
				//insert order							
				$this->db->setQuery( "INSERT INTO #__redirectonlogin_order_groups SET group_id='$group_id', redirect_order_back='$order' ");
				$this->db->query();	
			}					
		}		
		$app = JFactory::getApplication();
		$app->redirect('index.php?option=com_redirectonlogin&view=usergroups', JText::_('COM_REDIRECTONLOGIN_USERGROUP_ORDER_SAVED_BACKEND'));
	}
	
	function user_save(){
	
		// Check for request forgeries 
		JRequest::checkToken() or jexit('Invalid Token');
		
		$user_id = intval(JRequest::getVar('user_id', ''));
		
		$redirect_id = intval(JRequest::getVar('redirect_id', ''));
		
		$frontend_type = JRequest::getVar('redirect_frontend_type', '');
		$frontend_url = addslashes(JRequest::getVar('frontend_url', ''));
		$frontend_type_logout = JRequest::getVar('redirect_frontend_type_logout', '');
		$frontend_url_logout = addslashes(JRequest::getVar('frontend_url_logout', ''));	
		$backend_type = JRequest::getVar('redirect_backend_type', '');
		$backend_url = addslashes(JRequest::getVar('backend_url', ''));
		$backend_component = JRequest::getVar('backend_component', '');	
		$opening_site = JRequest::getVar('opening_site', '');	
		$opening_site_url = addslashes(JRequest::getVar('opening_site_url', ''));	
		$opening_site_home = JRequest::getVar('opening_site_home', '');	
		$menuitem_login = JRequest::getVar('menuitem_login', 0);
		$menuitem_open = JRequest::getVar('menuitem_open', 0);
		$menuitem_logout = JRequest::getVar('menuitem_logout', 0);
		$dynamic_login = JRequest::getVar('dynamic_login', 0);
		$dynamic_open = JRequest::getVar('dynamic_open', 0);
		$dynamic_logout = JRequest::getVar('dynamic_logout', 0);
		$open_type = JRequest::getVar('open_type', 'url');
		
		$database = JFactory::getDBO();
		
		if($redirect_id){
			//update
			$database->setQuery( "UPDATE #__redirectonlogin_users SET user_id='$user_id', frontend_type='$frontend_type', frontend_url='$frontend_url', frontend_type_logout='$frontend_type_logout', frontend_url_logout='$frontend_url_logout', backend_type='$backend_type', backend_url='$backend_url', backend_component='$backend_component', opening_site='$opening_site', opening_site_url='$opening_site_url', opening_site_home='$opening_site_home', menuitem_login='$menuitem_login', menuitem_open='$menuitem_open', menuitem_logout='$menuitem_logout', dynamic_login='$dynamic_login', dynamic_open='$dynamic_open', dynamic_logout='$dynamic_logout', open_type='$open_type' WHERE id='$redirect_id'"	);
			$database->query();
		}else{
			//insert
			$database->setQuery( "INSERT INTO #__redirectonlogin_users SET user_id='$user_id',  frontend_type='$frontend_type', frontend_url='$frontend_url', frontend_type_logout='$frontend_type_logout', frontend_url_logout='$frontend_url_logout', backend_type='$backend_type', backend_url='$backend_url', backend_component='$backend_component', opening_site='$opening_site', opening_site_url='$opening_site_url', opening_site_home='$opening_site_home', menuitem_login='$menuitem_login', menuitem_open='$menuitem_open', menuitem_logout='$menuitem_logout', dynamic_login='$dynamic_login', dynamic_open='$dynamic_open', dynamic_logout='$dynamic_logout', open_type='$open_type' ");
			$database->query();
		}
		
		//redirect
		$url = 'index.php?option=com_redirectonlogin&view=users';
		if(JRequest::getVar('apply', 0)){
			$url = 'index.php?option=com_redirectonlogin&view=user&user_id='.$user_id;
		}		
		$app = JFactory::getApplication();
		$app->redirect($url, JText::_('COM_REDIRECTONLOGIN_REDIRECT_SAVED'));
	}
	
	function enable_plugin_user(){
		$database = JFactory::getDBO();
		$database->setQuery( "UPDATE #__extensions SET enabled='1' WHERE element='redirectonlogin' AND folder='user' AND type='plugin' "	);
		$database->query();
		$app = JFactory::getApplication();
		$url = 'index.php?option=com_redirectonlogin&view=configuration';
		$message = JText::_('COM_REDIRECTONLOGIN_PLUGIN_ENABLED');
		if(!file_exists(dirname(__FILE__).'/../../../plugins/user/redirectonlogin/redirectonlogin.php')){
			$message = JText::_('COM_REDIRECTONLOGIN_NOT_INSTALLED').' '.JText::_('COM_REDIRECTONLOGIN_NOT_PUBLISHED');
		}
		$app->redirect($url, $message);
	}
	
	function enable_plugin_system(){
		$database = JFactory::getDBO();
		$database->setQuery( "UPDATE #__extensions SET enabled='1' WHERE element='redirectonlogin' AND folder='system' AND type='plugin' "	);
		$database->query();
		$app = JFactory::getApplication();
		$url = 'index.php?option=com_redirectonlogin&view=configuration';
		$message = JText::_('COM_REDIRECTONLOGIN_PLUGIN_ENABLED');
		if(!file_exists(dirname(__FILE__).'/../../../plugins/system/redirectonlogin/redirectonlogin.php')){
			$message = JText::_('COM_REDIRECTONLOGIN_NOT_INSTALLED').' '.JText::_('COM_REDIRECTONLOGIN_NOT_PUBLISHED');
		}
		$app->redirect($url, $message);
	}	
	
	function get_usergroups($user_id){
		$database = JFactory::getDBO();
		$database->setQuery("SELECT m.group_id "
		."FROM #__user_usergroup_map AS m "	
		."WHERE m.user_id='$user_id' "		
		);
		$rows = $database->loadObjectList();		
		$group_ids = array();
		foreach($rows as $row){	
			$group_ids[] = $row->group_id;	
		}
		return $group_ids;
	}	
	
	function get_first_usergroup($user_id, $front_back){
		$database = JFactory::getDBO();					
		$database->setQuery("SELECT m.group_id "
		."FROM #__user_usergroup_map AS m "			
		."LEFT JOIN #__redirectonlogin_order_groups AS o "
		."ON o.group_id=m.group_id "			
		."WHERE m.user_id='$user_id' "
		."ORDER BY o.redirect_order_".$front_back." ASC "
		."LIMIT 1"
		);
		$usergroup = $database->loadResult();		
		return $usergroup;
	}
	
	function display_footer(){				
		echo '<div class="smallgrey" id="rol_footer">';		
		echo '<table>';
		echo '<tr>';
		echo '<td class="text_right">';
		echo '<a href="http://www.pages-and-items.com" target="_blank">Redirect-On-Login</a>';
		echo '</td>';
		echo '<td class="five_pix">';
		echo '&copy;';
		echo '</td>';
		echo '<td>';
		echo '2010 - 2012 Carsten Engel';		
		echo '</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td class="text_right">';
		echo $this->rol_strtolower(JText::_('JVERSION'));
		echo '</td>';
		echo '<td class="five_pix">';
		echo '=';
		echo '</td>';
		echo '<td>';
		echo $this->rol_version.' ('.$this->rol_version_type.' '.$this->rol_strtolower(JText::_('JVERSION')).')';
		if($this->rol_version_type!='trial'){
			echo ' <a href="http://www.gnu.org/licenses/gpl-2.0.html" target="blank">GNU/GPL License</a>';
		}
		echo '</td>';
		echo '</tr>';
		//version checker
		if($this->rol_config['version_checker']){
			echo '<tr>';
			echo '<td class="text_right">';
			echo JText::_('COM_REDIRECTONLOGIN_LATEST_VERSION');
			echo '</td>';
			echo '<td class="five_pix">';
			echo '=';
			echo '</td>';
			echo '<td>';
			$app = JFactory::getApplication();
			$latest_version_message = $app->getUserState( "com_redirectonlogin.latest_version_message", '');
			if($latest_version_message==''){
				$latest_version_message = JText::_('COM_REDIRECTONLOGIN_VERSION_CHECKER_NOT_AVAILABLE');
				$url = 'http://www.pages-and-items.com/latest_version.php?extension=redirectonlogin';		
				$file_object = @fopen($url, "r");		
				if($file_object == TRUE){
					$version = fread($file_object, 1000);
					$latest_version_message = $version;
					if($this->rol_version!=$version){
						$latest_version_message .= ' <span style="color: red;">'.JText::_('COM_REDIRECTONLOGIN_NEWER_VERSION').'</span>';
						if($this->rol_version_type=='pro'){
							$download_url = 'http://www.pages-and-items.com/my-extensions';
						}else{
							$download_url = 'http://www.pages-and-items.com/extensions/redirect-on-login';
						}
						$latest_version_message .= ' <a href="'.$download_url.'" target="_blank">'.JText::_('COM_REDIRECTONLOGIN_DOWNLOAD').'</a>';
					}else{
						$latest_version_message .= ' <span style="color: #5F9E30;">'.JText::_('COM_REDIRECTONLOGIN_IS_LATEST_VERSION').'</span>';
					}
					fclose($file_object);
				}				
				$app->setUserState( "com_redirectonlogin.latest_version_message", $latest_version_message );
			}
			echo $latest_version_message;
			echo '</td>';
			echo '</tr>';
		}	
		echo '<tr>';
		echo '<td class="text_right" colspan="2">';
		echo $this->rol_strtolower(JText::_('COM_REDIRECTONLOGIN_REVIEW_B')); 
		echo '</td>';
		echo '<td>';
		if($this->rol_version_type=='pro'){
			$url_jed = '22806';
		}else{
			$url_jed = '15257';
		}		
		echo '<a href="http://extensions.joomla.org/extensions/access-a-security/site-access/login-redirect/'.$url_jed.'" target="_blank">';
		echo 'Joomla! Extensions Directory</a>';
		echo '</td>';
		echo '</tr>';		
		echo '</table>';		
		echo '</div>';	
	}
	
	function display_trial_version_stuff(){
		if($this->rol_version_type=='trial'){			
			echo '<div style="text-align: center;">';
			echo '<div style="color: red;">';
			echo JText::_('COM_REDIRECTONLOGIN_DEMO_DAYS_LEFT');
			echo ': ';
			if(round((($this->rol_demo_seconds_left/60)/60)/24)<=0){
				echo '0';
			}else{
				echo round((($this->rol_demo_seconds_left/60)/60)/24);
			}
			echo '</div>';
			echo JText::_('COM_REDIRECTONLOGIN_DEMO_DAYS_LEFT_TIP');			
			echo '<br /><a href="http://www.pages-and-items.com/index.php?page=shop.browse&category_id=6&option=com_virtuemart&Itemid=71&vmcchk=1&Itemid=71" target="_blank">';
			echo ucfirst(JText::_('COM_REDIRECTONLOGIN_BUY_THE_PRO'));
			echo '</a>';		
			echo '</div>';
		}
	}
	
	function trial_expired(){
		echo '<div style="text-align: left; width: 350px; margin: 100px auto;">';
		echo '<h2>trialversion has expired.</h2>';
		echo JText::_('COM_REDIRECTONLOGIN_DEMO_DAYS_LEFT_TIP');
		echo '<br /><br /><a href="http://www.pages-and-items.com/" target="_blank">purchase Redirect-On-Login</a>.';		
		echo '</div>';		
	}	

	function get_components_array(){			
		
		//get components from menu items		
		$this->db->setQuery("SELECT path, link as adminlink "
		."FROM #__menu "
		."WHERE menutype='_adminmenu' AND type='component' "	
		);	
		$components_menuitems = $this->db->loadObjectList();		
		$components_array = array();
		$links_array = array();
		foreach ($components_menuitems as $components_menuitem){
			$name = strtolower($components_menuitem->path);
			$link = $components_menuitem->adminlink;
			if(!in_array($link, $links_array)){
				//prevent double links				
				$links_array[] = $link;
				$components_array[] = array($name, $link);				
			}			
		}
		
		//get installed extensions
		$this->db->setQuery("SELECT name, element "
		."FROM #__extensions "
		."WHERE enabled='1' AND type='component' AND element<>'com_admin' AND element<>'com_login' "		
		);
		$components_extensions = $this->db->loadObjectList();		
		foreach ($components_extensions as $components_extension){
			$name = $components_extension->name;
			$link = 'index.php?option='.$components_extension->element;
			if(substr($name, 0, 4)=='com_'){
				$name = substr($name, 4);								
			}				
			if(!in_array($link, $links_array)){
				//prevent double links				
				$links_array[] = $link;
				$components_array[] = array($name, $link);
			}
		}
		
		//reorder on name
		foreach ($components_array as $key => $row) {
			$order[$key]  = $row[0];    
		}
		$sort_order = SORT_ASC;//workaround for ioncube
		array_multisort($order, $sort_order, $components_array);
		
		return $components_array;
	}	
	
	function ajax_version_checker(){
		$message = JText::_('COM_REDIRECTONLOGIN_VERSION_CHECKER_NOT_AVAILABLE');	
		$url = 'http://www.pages-and-items.com/latest_version.php?extension=redirectonlogin';		
		$file_object = @fopen($url, "r");		
		if($file_object == TRUE){
			$version = fread($file_object, 1000);
			$message = JText::_('COM_REDIRECTONLOGIN_LATEST_VERSION').' = '.$version;
			if($this->rol_version!=$version){
				$message .= '<div><span style="color: red;">'.JText::_('COM_REDIRECTONLOGIN_NEWER_VERSION').'</span>.</div>';
				if($this->rol_version_type=='pro'){
					$download_url = 'http://www.pages-and-items.com/my-extensions';
				}else{
					$download_url = 'http://www.pages-and-items.com/extensions/redirect-on-login';
				}
				$message .= '<div><a href="'.$download_url.'" target="_blank">'.JText::_('COM_REDIRECTONLOGIN_DOWNLOAD').'</a></div>';
			}else{
				$message .= '<div><span style="color: #5F9E30;">'.JText::_('COM_REDIRECTONLOGIN_IS_LATEST_VERSION').'</span>.</div>';
			}
			fclose($file_object);
		}		
		echo $message;
		exit;
	}
	
	function rol_strtolower($string){
		if(function_exists('mb_strtolower')){			
			$string = mb_strtolower($string, 'UTF-8');
		}
		return $string;
	}
	
	function not_enabled_message(){
		if($this->rol_config['enable_redirection']=='no'){
			echo '<p style="color: red;">'.JText::_('COM_REDIRECTONLOGIN_IS_NOT_ENABLED').'. '.JText::_('COM_REDIRECTONLOGIN_ENABLE_THIS_IN').' <a href="index.php?option=com_redirectonlogin&view=configuration">'.$this->rol_strtolower(JText::_('COM_REDIRECTONLOGIN_CONFIGURATION')).'</a>.</p>';
		}
	}
	
	function dynamicredirect_save(){
	
		$database = JFactory::getDBO();		
	
		// Check for request forgeries 
		JRequest::checkToken() or jexit('Invalid Token');
		
		$redirect_id = intval(JRequest::getVar('redirect_id', ''));		
		$redirect_name = addslashes(JRequest::getVar('redirect_name', ''));	
		$value = JRequest::getVar('redirect_code','','post','string', JREQUEST_ALLOWRAW);	
		$value = str_replace('=','[equal]',$value);
		$new_line = '
';
		$value = str_replace($new_line,'[newline]',$value);
		$value = addslashes($value);
		$redirect_type = JRequest::getVar('redirect_type', '');	

		
		if($redirect_id){
			//update
			$database->setQuery( "UPDATE #__redirectonlogin_dynamics SET name='$redirect_name', value='$value', type='$redirect_type' WHERE id='$redirect_id'"	);
			$database->query();
		}else{
			//insert
			$database->setQuery( "INSERT INTO #__redirectonlogin_dynamics SET name='$redirect_name', value='$value', type='$redirect_type' ");
			$database->query();
			
			//get new id
			$redirect_id = $database->insertid(); 
		}
		
		//redirect
		$url = 'index.php?option=com_redirectonlogin&view=dynamicredirects';
		if(JRequest::getVar('apply', 0)){
			$url = 'index.php?option=com_redirectonlogin&view=dynamicredirect&id='.$redirect_id;
		}
		$this->setRedirect($url, JText::_('COM_REDIRECTONLOGIN_REDIRECT_SAVED'));
	}
	
	function save_order_dynamic_redirects(){
	
		$database = JFactory::getDBO();	
		
		$dynamic_redirect_order = JRequest::getVar('order', array(), 'post', 'array');
		$dynamic_redirect_id = JRequest::getVar('dynamic_redirect_id', array(), 'post', 'array');
		$order_ids = JRequest::getVar('order_id', array(), 'post', 'array');		
		for($n = 0; $n < count($dynamic_redirect_id); $n++){		
			$redirect_order = $dynamic_redirect_order[$n];
			$redirect_id = $dynamic_redirect_id[$n];
			$order_id = $order_ids[$n];				
			
			//update order				
			$database->setQuery( "UPDATE #__redirectonlogin_dynamics SET ordering='$redirect_order' WHERE id='$redirect_id' ");
			$database->query();				
		}	
		$url = 'index.php?option=com_redirectonlogin&view=dynamicredirects';
		$this->setRedirect($url, JText::_('COM_REDIRECTONLOGIN_ORDER_SAVED'));
	}	
	
	function dynamicredirect_delete(){	
	
		$database = JFactory::getDBO();	
		
		// Check for request forgeries 
		JRequest::checkToken() or jexit('Invalid Token');			
		
		$cid = JRequest::getVar('cid', null, 'post', 'array');		
		
		if (!is_array($cid) || count($cid) < 1) {
			echo JText::_('COM_REDIRECTONLOGIN_NO_DYNAMIC_REDIRECTS_SELECTED');
			exit();
		}
		
		if (count($cid)){
			$ids = implode(',', $cid);	
			
			//delete dynamic redirects
			$database->setQuery("DELETE FROM #__redirectonlogin_dynamics WHERE id IN ($ids)");
			$database->query();
		}
		
		$this->setRedirect("index.php?option=com_redirectonlogin&view=dynamicredirects", JText::_('COM_REDIRECTONLOGIN_REDIRECTS_DELETED'));
	}
	
	function get_version_type(){
		//so that private var is available for templates
		return $this->rol_version_type;
	}
	
	function get_helper(){
		$ds = DIRECTORY_SEPARATOR;
		require_once(JPATH_ROOT.$ds.'administrator'.$ds.'components'.$ds.'com_redirectonlogin'.$ds.'helpers'.$ds.'redirectonlogin.php');
		$helper = new redirectonloginHelper();
		return $helper;
	}
	
	function add_submenu($vName = 'redirectonlogin'){	
	
		$vName = JFactory::getApplication()->input->get('view');
		JHtmlSidebar::addEntry(
			JText::_('COM_REDIRECTONLOGIN_CONFIGURATION'),
			'index.php?option=com_redirectonlogin&view=configuration',
			$vName == 'configuration'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_REDIRECTONLOGIN_USERGROUPS'),
			'index.php?option=com_redirectonlogin&view=usergroups',
			$vName == 'usergroups' || $vName == 'usergroup'
		);		
		JHtmlSidebar::addEntry(
			JText::_('COM_REDIRECTONLOGIN_ACCESSLEVELS'),
			'index.php?option=com_redirectonlogin&view=accesslevels',
			$vName == 'accesslevels' || $vName == 'accesslevel'
		);			
		JHtmlSidebar::addEntry(
			JText::_('COM_REDIRECTONLOGIN_USERS'),
			'index.php?option=com_redirectonlogin&view=users',
			$vName == 'users' || $vName == 'user'
		);	
		JHtmlSidebar::addEntry(
			JText::_('COM_REDIRECTONLOGIN_DYNAMIC_REDIRECTS'),
			'index.php?option=com_redirectonlogin&view=dynamicredirects',
			$vName == 'dynamicredirects' || $vName == 'dynamicredirect'
		);	
		JHtmlSidebar::addEntry(
			JText::_('COM_REDIRECTONLOGIN_SUPPORT'),
			'index.php?option=com_redirectonlogin&view=support',
			$vName == 'support'
		);		
	}
	
	
	

}
?>