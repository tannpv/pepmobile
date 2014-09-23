<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.event.plugin' );

/**
 * Joomla! Core Login Redirect
 * Version 1.7.2
 * @author		River Media
 * @package		Joomla
 * @subpackage	System
 */
class  plgSystemCore_Login_Redirect extends JPlugin
{

	/**
	 * Object Constructor.
	 *
	 * @access	public
	 * @param	object	The object to observe -- event dispatcher.
	 * @param	object	The configuration object for the plugin.
	 * @return	void
	 * @since	1.0
	 */
	function __construct(&$subject, $config)
	{
		parent::__construct($subject, $config);
	}

	function onAfterRoute() {

		$app					= JFactory::getApplication();
		$option					= JRequest::getVar('option');

		if(!$app->isSite()){
			return false;
		}elseif($option=='com_users' || $option=='com_comprofiler' || $option=='com_community' || $option=='com_awdwall'){

			$user					= JFactory::getUser();
			$params					= $this->params;
			$task					= JRequest::getVar('task');
			$view					= JRequest::getVar('view');
			$layout					= JRequest::getVar('layout');
	
			$custom_register		= $params->get('custom_register', 'cb');
			$custom_login			= $params->get('custom_login', 'cb');
			$custom_profile			= $params->get('custom_profile', 'cb');
			$custom_password		= $params->get('custom_password', 'cb');
			$custom_username		= $params->get('custom_username', 'cb');
			$devMode				= $params->get('dev_mode', 0);

			$ckeckRegister 			= ($task=='register' || $view=='registration' || $view=='register');
			$ckeckProfile 			= ($task!='user.logout' && $task != 'user.login');

			switch(true){
// REGISTRATION:
				// redirect FROM joomla registration TO community builder registration
				case $option=='com_users' && $ckeckRegister && $custom_register == 'cb':
					$masterRedirect = "index.php?option=com_comprofiler&task=registers";
					break;
				// redirect FROM joomla registration TO jomsocial registeration
				case $option=='com_users' && $ckeckRegister && $custom_register == 'js':
					$masterRedirect = "index.php?option=com_community&view=register";	
					break;		  
				// redirect FROM joomla registration TO jomwall registration
					// not sure if this will be able to be used since it appears that JomWall doesn't have a direct URL to a registration page
/*
				case $option=='com_users' && $ckeckRegister && $custom_register == 'jw':
					//http://j25_dev/index.php?option=com_awdwall&task=login&Itemid=590#awdregisterfrm
					$masterRedirect = "index.php?option=com_awdwall&task=login";
					break;
*/
				// redirect FROM joomla registration TO custom registration
				case $option=='com_users' && $ckeckRegister && $custom_register == 'custom':
					$masterRedirect = $this->checkCustomURL('custom_register');
					break;
				// redirect FROM community builder registration TO custom registration
				case $option=='com_comprofiler' && $task=='registers' && $custom_register == 'custom':
					$masterRedirect = $this->checkCustomURL('custom_register');
					break;
				// redirect FROM jomsocial registration TO custom registration
				case $option=='com_community' && $task=='register' && $custom_register == 'custom':
					$masterRedirect = $this->checkCustomURL('custom_register');
					break;
				// redirect FROM jomwall registration TO custom registration
					// not sure if this will be able to be used since it appears that JomWall doesn't have a direct URL to a registration page
/*
				case $option=='com_awdwall' && $task=='register' && $custom_register == 'custom':
					$masterRedirect = $this->checkCustomURL('custom_register');
					break;
*/
// LOGIN:
				// redirect FROM joomla login TO custom login
				case $option=='com_users' && $view=='login' && $custom_login=='custom':
					$masterRedirect = $this->checkCustomURL('custom_login');
					break;
				// redirect FROM community builder login TO custom login
				case $option=='com_comprofiler' && $view=='login' && $custom_login=='custom':
					$masterRedirect = $this->checkCustomURL('custom_login');
					break;
				// redirect FROM jomsocial login TO custom login
				case $option=='com_users' && $view=='frontpage' && $custom_login=='custom':
					$masterRedirect = $this->checkCustomURL('custom_login');
					break;
				// redirect FROM jomwall login TO custom login
				case $option=='com_awdwall' && $task=='login' && $custom_login=='custom':
					$masterRedirect = $this->checkCustomURL('custom_login');
					break;
				// redirect FROM joomla login TO community builder login
				case $option=='com_users' && $view=='login' && $custom_login=='cb':
					$masterRedirect = "index.php?option=com_comprofiler&task=login";
					break;
				// redirect FROM joomla login TO jomsocial login
				case $option=='com_users' && $view=='login' && $custom_login == 'js':
					$app->redirect(JRoute::_("index.php?option=com_community&view=frontpage",false));	
					break;		  
				// redirect FROM joomla login TO jomwall login
				case $option=='com_users' && $view=='login' && $custom_login=='jw':
					$masterRedirect = "index.php?option=com_awdwall&task=login";
					break;
				// redirect FROM community builder login TO joomla login
				case $option=='com_comprofiler' && $task=='login' && $custom_login == 'joomla':
					$masterRedirect = "index.php?option=com_users&view=login";	
					break;		  
				// redirect FROM jomsocial login TO joomla login
				case $option=='com_community' && $view== 'frontpage' && $custom_login == 'joomla':
					$masterRedirect = "index.php?option=com_users&view=login";	
					break;		  
				// redirect FROM jomwall login TO joomla login
				case $option=='com_awdwall' && $task=='login' && $custom_login=='joomla':
					$masterRedirect = "index.php?option=com_users&view=login";	
					break;
// PROFILE:				
				// redirect FROM joomla profile TO community builder profile
				case $option=='com_users' && $view=='profile' && $custom_profile == 'cb':
					$masterRedirect = "index.php?option=com_comprofiler&view=profile";
					break;
				// redirect FROM joomla profile TO jomsocial profile
				case $option=='com_users' && $ckeckProfile && !$user->guest && $custom_profile == 'js':
					$masterRedirect = "index.php?option=com_community&view=profile";	
					break;		  
				// redirect FROM joomla profile TO jomwall profile
				case $option=='com_users' && $ckeckProfile && !$user->guest && $custom_profile == 'jw':
					//http://j25_dev/index.php?option=com_awdwall&view=awdwall&layout=mywall&Itemid=
					$masterRedirect = "index.php?option=com_awdwall&view=awdwall&layout=mywall";	
					break;		  
				// redirect FROM community builder profile TO joomla profile
				case $option=='com_comprofiler' && $view=='profile' && $custom_profile == 'joomla':
					$masterRedirect = "index.php?option=com_users&view=profile";
					break;
				// redirect FROM jomsocial profile TO joomla profile
				case $option=='com_community' && $view=='profile' && $custom_profile == 'joomla':
					$masterRedirect = "index.php?option=com_users&view=profile";
					break;
				// redirect FROM jomwall profile TO joomla profile
				case $option=='com_awdwall' && $view=='awdwall' && $layout=='mywall' && $custom_profile == 'joomla':
					$masterRedirect = "index.php?option=com_users&view=profile";
					break;
				// redirect FROM community builder profile or joomla or jomsocial or jomwall TO custom profile
				case ($option=='com_comprofiler' || $option=='com_users' || $option == 'com_community' || $option=='com_awdwall') && ($view=='profile' || $view=='awdwall') && $custom_profile=='custom':
					$masterRedirect = $this->checkCustomURL('custom_profile');
					break;
// PASSWORD:
				// redirect FROM joomla core TO community builder forgot password
				case $option=='com_users' && $view=='reset' && $custom_password=='cb':
					$masterRedirect = "index.php?option=com_comprofiler&task=lostPassword";
					break;
				// redirect FROM joomla password TO custom password
				case $option=='com_users' && $view=='reset' && $custom_password=='custom':
					$masterRedirect = $this->checkCustomURL('custom_password');
					break;
				// redirect FROM community builder TO joomla password
				case $option=='com_comprofiler' && $task=='lostpassword' && ($custom_password=='joomla' || $custom_username=='joomla'):
					$masterRedirect = 'index.php?option=com_users&view=reset';
					break;
				// redirect FROM community builder TO custom password
				case $option=='com_comprofiler' && $task=='lostpassword' && ($custom_password=='custom' || $custom_username=='custom'):
					$masterRedirect = $this->checkCustomURL('custom_password');
					break;
// USERNAME:
				// FYI, there isn't a seperate call for community builder username reminder
				// redirect FROM joomla core TO community builder forgot username
				case $option=='com_users' && $view=='remind' && $custom_username=='cb':
					$masterRedirect = "index.php?option=com_comprofiler&task=lostPassword";
					break;
				// redirect FROM joomla core TO custom username
				case $option=='com_users' && $view=='remind' && $custom_username=='custom':
					$masterRedirect = $this->checkCustomURL('custom_profile');
					break;
				default:
					$masterRedirect = null;
			}

$devMessage='';
if($devMode){
	$html = '<pre>';
	$html.= time().'<br>';
	$html.= 'OPTION: '.$option.'<br>';
	$html.= 'TASK: '.$task.'<br>';
	$html.= 'VIEW: '.$view.'<br>';
	$html.= $custom_register.'<br>';
	$html.= $custom_login.'<br>';
	$html.= $custom_profile.'<br>';
	$html.= $custom_password.'<br>';
	$html.= $custom_username.'<br>';
	$html.= $masterRedirect.'<br>';
	$html.= '</pre>';
#$_SESSION['devLog'].= $html;
#	die('DevMode Enabled for \'Core Login Redirect\'.');
	$devMessage = $html.'<strong>'.$masterRedirect.'</strong>';
}

			if($masterRedirect)
				$app->redirect(JRoute::_($masterRedirect,false),$devMessage);
		}
	}
	
	function checkCustomURL($type=''){
		$app			= JFactory::getApplication();
		$params			= $this->params;
		$custom_menu	= $params->get($type.'_menu');
		$menu = 'index.php?Itemid='.$custom_menu;
		if($type=='custom_login' && $custom_menu > 0){
			$custom_url		=  $menu;
		}elseif($custom_menu > 0){
			$custom_url = $menu;
		}elseif($type!='custom_login'){
			$custom_url = $params->get($type.'_url');
		}else{
			$custom_url = '';
		}



		// Check for valid URL.
		if (empty($custom_url)) 
		{
			$app->redirect('index.php','Could Not Redirect! You didn\'t specify a Menu Item or URL in the \''.strtoupper(str_replace('custom_','',$type)).' HANDLER\' settings!');
			return false;
		}
		
		return $custom_url;
	}
}