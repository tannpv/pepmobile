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

$checked = 'checked="checked"';

?>
<script language="JavaScript" type="text/javascript">

Joomla.submitbutton = function(task){	
	submitform(task);	
}

function check_latest_version(){
	document.getElementById('version_checker_target').innerHTML = document.getElementById('version_checker_spinner').innerHTML;
	ajax_url = 'index.php?option=com_redirectonlogin&task=ajax_version_checker&format=raw';
	var req = new Request.HTML({url:ajax_url, update:'version_checker_target' });	
	req.send();
}

</script>
<form action="" method="post" name="adminForm" id="adminForm">
	<?php if (!empty($this->sidebar)): ?>
		<div id="j-sidebar-container" class="span2">
			<?php echo $this->sidebar; ?>
		</div>
	<?php endif; ?>	
	<div id="j-main-container"<?php echo empty($this->sidebar) ? '' : ' class="span10"'; ?>>
		<div class="clr"> </div><!-- needed for some admin templates -->		
		<div class="fltlft">
			<h2 style="padding-left: 10px;"><?php echo JText::_('COM_REDIRECTONLOGIN_CONFIGURATION'); ?></h2>	
			<fieldset class="adminform">				
				<table class="adminlist rol_table tabletop">				
					<tr>
						<td class="rol_nowrap" style="width: 250px;">
							<label class="hasTip required"><?php echo JText::_('COM_REDIRECTONLOGIN_STATUS'); ?> Redirect-on-Login</label>
						</td>
						<td>
							<input type="radio" name="enable_redirection" id="enable_yes" value="yes" <?php if($this->controller->rol_config['enable_redirection']=='yes'){echo $checked;}?> />
							<label for="enable_yes"><?php echo JText::_('COM_REDIRECTONLOGIN_ENABLE'); ?></label>	
							<br /><br />			
							<input type="radio" name="enable_redirection" id="enable_no" value="no" <?php if($this->controller->rol_config['enable_redirection']=='no'){echo $checked;}?> />
							<label for="enable_no"><?php echo JText::_('COM_REDIRECTONLOGIN_DISABLE'); ?></label>
						</td>					
					</tr>
					<tr>
						<td>
							<?php echo JText::_('COM_REDIRECTONLOGIN_PLUGIN_STATUS'); ?>
						</td>
						<td>
							<div><?php echo JText::_('COM_REDIRECTONLOGIN_USER_PLUGIN'); ?></div>
							<?php
							$user_plugin_installed = false;
							$user_plugin_enabled = false;
							
							//check if plugin is installed and published
							$this->controller->db->setQuery("SELECT enabled "
							."FROM #__extensions "
							."WHERE element='redirectonlogin' AND folder='user' AND type='plugin' "
							."LIMIT 1"					
							);
							$rows = $this->controller->db->loadObjectList();								
							foreach($rows as $row){	
								$user_plugin_installed = true;
								$user_plugin_enabled = $row->enabled;
							}
												
							if($user_plugin_installed){
								echo '<div style="color: #5F9E30;">'.JText::_('COM_REDIRECTONLOGIN_INSTALLED').'</div>';				
							}else{
								echo '<div style="color: red;">'.JText::_('COM_REDIRECTONLOGIN_NOT_INSTALLED').'</div>';
							}
							if($user_plugin_enabled=='1'){
								echo '<div style="color: #5F9E30;">'.JText::_('COM_REDIRECTONLOGIN_PUBLISHED').'</div>';				
							}else{
								echo '<span style="color: red;">'.JText::_('COM_REDIRECTONLOGIN_NOT_PUBLISHED').'</span>';
								echo ' <a href="index.php?option=com_redirectonlogin&task=enable_plugin_user">'.JText::_('COM_REDIRECTONLOGIN_ENABLE_PLUGIN').'</a>';
							}	
							?>
						</td>					
					</tr>
					<tr>
						<td>
							<?php echo JText::_('COM_REDIRECTONLOGIN_PLUGIN_STATUS'); ?>
						</td>					
						<td>
							<div><?php echo JText::_('COM_REDIRECTONLOGIN_SYSTEM_PLUGIN'); ?></div>
							<?php
							$system_plugin_installed = false;
							$system_plugin_enabled = false;
							
							//check if plugin is installed and published
							$this->controller->db->setQuery("SELECT enabled "
							."FROM #__extensions "
							."WHERE element='redirectonlogin' AND folder='system' AND type='plugin' "
							."LIMIT 1"					
							);
							$rows = $this->controller->db->loadObjectList();					
							foreach($rows as $row){	
								$system_plugin_installed = true;
								$system_plugin_enabled = $row->enabled;
							}
												
							if($system_plugin_installed){
								echo '<div style="color: #5F9E30;">'.JText::_('COM_REDIRECTONLOGIN_INSTALLED').'</div>';				
							}else{
								echo '<div style="color: red;">'.JText::_('COM_REDIRECTONLOGIN_NOT_INSTALLED').'</div>';
							}
							if($system_plugin_enabled=='1'){
								echo '<div style="color: #5F9E30;">'.JText::_('COM_REDIRECTONLOGIN_PUBLISHED').'</div>';				
							}else{
								echo '<span style="color: red;">'.JText::_('COM_REDIRECTONLOGIN_NOT_PUBLISHED').'</span>';
								echo ' <a href="index.php?option=com_redirectonlogin&task=enable_plugin_system">'.JText::_('COM_REDIRECTONLOGIN_ENABLE_PLUGIN').'</a>';
							}	
							?>
						</td>
					</tr>				
				</table>			
				
			</fieldset>
			<a name="frontend"></a>
			<fieldset class="adminform">
				<legend class="rol_legend"><?php echo JText::_('COM_REDIRECTONLOGIN_FRONTEND'); ?></legend>
				
				<table class="adminlist rol_table tabletop">				
					<tr>
						<td class="rol_nowrap" style="width: 250px;">
							<label class="hasTip required"><?php echo JText::_('COM_REDIRECTONLOGIN_U_OR_A'); ?></label>
						</td>
						<td colspan="3">
							<input type="radio" name="frontend_u_or_a" id="frontend_a" value="a" <?php if($this->controller->rol_config['frontend_u_or_a']=='a'){echo $checked;}?> />
							<label for="frontend_a"><?php echo JText::_('COM_REDIRECTONLOGIN_ACCESSLEVELS'); ?></label>	
							<br /><br />	
							<input type="radio" name="frontend_u_or_a" id="frontend_u" value="u" <?php if($this->controller->rol_config['frontend_u_or_a']=='u'){echo $checked;}?> />
							<label for="frontend_u"><?php echo JText::_('COM_REDIRECTONLOGIN_USERGROUPS'); ?></label>	
						</td>					
					</tr>
					<tr>
						<td colspan="4">&nbsp;
							
						</td>
					</tr>
					<tr>
						<td>
							<label class="hasTip required"><?php echo JText::_('COM_REDIRECTONLOGIN_DEFAULT_REDIRECT_TYPE_LOGIN'); ?></label>
						</td>
						<td colspan="3">
							<?php echo JText::_('COM_REDIRECTONLOGIN_DEFAULT_REDIRECT_TYPE_INFO_FRONTEND'); ?>.
						</td>					
					</tr>
					<tr>
						<td>&nbsp;
							
						</td>
						<td class="rol_nowrap" style="width: 150px;">
							<label><input type="radio" name="redirect_type_frontend" value="none" <?php if($this->controller->rol_config['redirect_type_frontend']=='none'){echo $checked;}?> /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_NORMAL'); ?></label>
						</td>
						<td colspan="2">
							<?php echo JText::_('COM_REDIRECTONLOGIN_NORMAL').' Joomla '.$this->controller->rol_strtolower(JText::_('COM_REDIRECTONLOGIN_LOGIN')); ?>
						</td>
					</tr>
					<tr>
						<td>&nbsp;
							
						</td>
						<td class="rol_nowrap">
							<label><input type="radio" name="redirect_type_frontend" value="same" <?php if($this->controller->rol_config['redirect_type_frontend']=='same'){echo $checked;}?> /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_SAME_PAGE'); ?></label>
						</td>
						<td colspan="2">
							
						</td>
					</tr>
					<tr>
						<td style="text-align: right; color: red;">
							<?php 
							if($this->controller->rol_config['redirect_type_frontend']=='menuitem' && !$this->menuitem_login){							
								echo JText::_('COM_REDIRECTONLOGIN_NO_MENUITEM_SELECTED');							
							}				
							?>
						</td>
						<td class="rol_nowrap">
							<label><input type="radio" name="redirect_type_frontend" value="menuitem" <?php if($this->controller->rol_config['redirect_type_frontend']=='menuitem'){echo $checked;}?> /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_MENUITEM'); ?></label>
						</td>
						<td colspan="2">
							<?php echo $this->menuitem_login_select; ?>
						</td>
					</tr>				
					<tr>
						<td style="text-align: right; color: red;">
							<?php 
							if($this->controller->rol_config['redirect_type_frontend']=='url' && $this->controller->rol_config['redirect_url_frontend']==''){							
								echo JText::_('COM_REDIRECTONLOGIN_NO_URL');							
							}				
							?>
						</td>
						<td class="rol_nowrap">
							<label><input type="radio" name="redirect_type_frontend" value="url" <?php if($this->controller->rol_config['redirect_type_frontend']=='url'){echo $checked;}?> />			
							<?php echo JText::_('COM_REDIRECTONLOGIN_URL'); ?></label>
						</td>
						<td colspan="2">
							<input type="text" name="redirect_url_frontend" style="width: 450px;" value="<?php echo $this->controller->rol_config['redirect_url_frontend'];?>" /> <?php echo JText::_('COM_REDIRECTONLOGIN_URL_FULL'); ?>.
						</td>
					</tr>
					<tr>
						<td style="text-align: right; color: red;">
							<?php 
							if($this->controller->rol_config['redirect_type_frontend']=='dynamic' && !$this->dynamic_login){							
								echo JText::_('COM_REDIRECTONLOGIN_NO_DYNAMIC_REDIRECTS_SELECTED');							
							}				
							?>
						</td>
						<td class="rol_nowrap">
							<label><input type="radio" name="redirect_type_frontend" value="dynamic" <?php if($this->controller->rol_config['redirect_type_frontend']=='dynamic'){echo $checked;}?> /> 
							<?php echo $this->controller->rol_strtolower(JText::_('COM_REDIRECTONLOGIN_DYNAMIC_REDIRECT')); ?></label>
						</td>
						<td>
							<?php echo $this->dynamic_login_select; ?>
						</td>
						<td>
							<?php
								if($this->controller->get_version_type()=='free'){
									echo '<div style="color: red;">';
									echo JText::_('COM_REDIRECTONLOGIN_NOT_IN_FREE_VERSION');
									echo '</div>';
								}
							?>
						</td>
					</tr>
					<tr>
						<td>&nbsp;
							
						</td>
						<td class="rol_nowrap">
							<label><input type="radio" name="redirect_type_frontend" value="logout" <?php if($this->controller->rol_config['redirect_type_frontend']=='logout'){echo $checked;}?> /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_BLOCK_LOGIN'); ?></label>
						</td>
						<td colspan="2">
							<?php echo JText::_('COM_REDIRECTONLOGIN_LOGOUT_A'); ?>.						
							<br />
							<?php echo JText::_('COM_REDIRECTONLOGIN_LOGOUT_MESSAGE'); ?>:
							<table class="adminlist rol_table nopaddingleft">
								<tr>
									<td style="width: 10px;">
										<input type="radio" name="lang_type_login_front" id="lang_type_login_front_custom" value="custom" <?php if($this->controller->rol_config['lang_type_login_front']=='custom'){echo $checked;}?> />
									</td>
									<td>
										<label for="lang_type_login_front_custom">
											<input type="text" name="logout_message_frontend" style="width: 450px;" value="<?php echo str_replace('"', '&quot;', $this->controller->rol_config['logout_message_frontend']);?>" />
										</label>
									</td>
								</tr>
								<tr>
									<td>
										<input type="radio" name="lang_type_login_front" id="lang_type_login_front_langfile" value="langfile" <?php if($this->controller->rol_config['lang_type_login_front']=='langfile'){echo $checked;}?> />
									</td>
									<td>
										<label for="lang_type_login_front_langfile">
											<?php echo JText::_('COM_REDIRECTONLOGIN_FROM_LANGUAGE_FILE'); ?>:
										</label><br />
										<input type="text" style="width: 450px;" name="" value="<?php 
											$lang->load('com_redirectonlogin', JPATH_ROOT, null, false); 
											echo JText::_('COM_REDIRECTONLOGIN_YOU_CANT_LOGIN_FRONTEND');
										?>" disabled="disabled" /><br />
										<?php echo JText::_('COM_REDIRECTONLOGIN_LANGOVERRIDE'); ?>. <a href="http://www.pages-and-items.com/extensions/redirect-on-login/faqs?faqitem=config_language-overrides" target="_blank"><?php echo JText::_('COM_REDIRECTONLOGIN_READ_MORE'); ?></a>
									</td>						
								</tr>
							</table>																		
						</td>
					</tr>
					<tr>
						<td colspan="4">&nbsp;												
						</td>
					</tr>
					<tr>
						<td>
							<?php echo JText::_('COM_REDIRECTONLOGIN_AFTER_NO_ACCESS_PAGE'); ?>
						</td>
						<td class="rol_nowrap">
							<label><input type="radio" name="after_no_access_page" value="rol" <?php if($this->controller->rol_config['after_no_access_page']=='rol'){echo $checked;}?> />
							<?php echo JText::_('COM_REDIRECTONLOGIN_AS_SET_IN'); ?> Redirect-on-Login</label> 
							<br />
							<br />
							<label><input type="radio" name="after_no_access_page" value="page" <?php if($this->controller->rol_config['after_no_access_page']=='page'){echo $checked;}?> /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_PAGE'); ?></label>											
						</td>
						<td colspan="2">
							<?php echo JText::_('COM_REDIRECTONLOGIN_AFTER_NO_ACCESS_PAGE_INFO'); ?>.																									
						</td>
					</tr>					
					<tr>
						<td>&nbsp;	
						</td>
						<td><label><input type="radio" name="after_no_access_page" value="pagerolno" <?php if($this->controller->rol_config['after_no_access_page']=='pagerolno'){echo $checked;}?> /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_PAGE_ROLNO'); ?> rol=no</label>
						</td>
						<td colspan="2">
							<?php
								if($this->controller->get_version_type()=='free'){
									echo '<div style="color: red;">';
									echo JText::_('COM_REDIRECTONLOGIN_NOT_IN_FREE_VERSION');
									echo '</div>';
								}
							?>
						</td>
					</tr>
					<tr>
						<td colspan="4">&nbsp;
						</td>
					</tr>
					<tr>
						<td>
							<?php 				
								echo JText::_('COM_REDIRECTONLOGIN_NO_REDIRECT');	
							?>
						</td>					
						<td colspan="3">
							<?php
								if($this->controller->get_version_type()=='free'){
									echo '<div style="color: red;">';
									echo JText::_('COM_REDIRECTONLOGIN_NOT_IN_FREE_VERSION');
									echo '</div>';
								}
							?>
							<?php echo JText::_('COM_REDIRECTONLOGIN_NOREDIR_A').':'; ?>
							<strong>rol=no</strong>
							<br />index.php?option=com_content&amp;<strong>rol=no</strong><br />some-sef-url?<strong>rol=no</strong><br />
							<?php echo JText::_('COM_REDIRECTONLOGIN_NOREDIR_B'); ?>.							
						</td>					
					</tr>
					<tr>
						<td colspan="4">&nbsp;
							<a name="opening_site"></a>
													
						</td>
					</tr>
					<tr>
						<td class="rol_nowrap">
							<label class="hasTip required"><?php echo JText::_('COM_REDIRECTONLOGIN_WHEN_OPENING_SITE'); ?></label>
						</td>
						<td colspan="3">
							<?php 
							if($this->controller->get_version_type()=='free'){
								echo '<div style="color: red;">';
								echo JText::_('COM_REDIRECTONLOGIN_NOT_IN_FREE_VERSION');
								echo '</div>';
							}
							echo JText::_('COM_REDIRECTONLOGIN_WHEN_OPENING_SITE_INFO').' '.JText::_('COM_REDIRECTONLOGIN_SESSION'); ?>. <?php echo JText::_('COM_REDIRECTONLOGIN_UNLESS_OVERRULED_B'); ?>.
						</td>					
					</tr>
					<tr>
						<td>&nbsp;
							
						</td>
						<td class="rol_nowrap">
							<label><input type="radio" name="opening_site" value="no" <?php if($this->controller->rol_config['opening_site']=='no' || $this->controller->rol_config['opening_site']==''){echo $checked;}?> /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_NO'); ?></label>
						</td>
						<td colspan="2">
							
						</td>
					</tr>
					<tr>
						<td>&nbsp;
						</td>
						<td class="rol_nowrap">
							<label><input type="radio" name="opening_site" value="yes" <?php if($this->controller->rol_config['opening_site']=='yes'){echo $checked;}?> /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_YES'); ?></label>
						</td>
						<td colspan="2">
							<label><input type="radio" name="opening_site_type" value="loggedin" <?php if($this->controller->rol_config['opening_site_type']=='loggedin' || $this->controller->rol_config['opening_site_type']==''){echo $checked;}?> /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_ONLY_STILL_LOGGEDIN'); ?></label>					
						</td>
					</tr>
					<tr>
						<td>&nbsp;
							
						</td>
						<td>&nbsp;
													
						</td>
						<td colspan="2">					
							<label><input type="radio" name="opening_site_type" value="notloggedin" <?php if($this->controller->rol_config['opening_site_type']=='notloggedin'){echo $checked;}?> /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_ONLY_GUESTS'); ?></label>
						</td>
					</tr>	
					<tr>
						<td>&nbsp;
							
						</td>
						<td>&nbsp;
													
						</td>
						<td colspan="2">						
							<label><input type="radio" name="opening_site_type" value="all" <?php if($this->controller->rol_config['opening_site_type']=='all'){echo $checked;}?> /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_ALL_USERS_SITE_OPEN_B'); ?></label>						
						</td>
					</tr>	
					<tr>
						<td>&nbsp;
							
						</td>
						<td>&nbsp;
													
						</td>
						<td colspan="2">						
							<label><input type="checkbox" name="opening_site_home" value="1" <?php if($this->controller->rol_config['opening_site_home']){echo $checked;}?> /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_SITE_HOME'); ?></label>
						</td>
					</tr>
					<tr>
						<td>&nbsp;						
						</td>
						<td style="text-align: right; color: red;"  class="rol_nowrap">
							<?php 
							if($this->controller->rol_config['opening_site']=='yes' && !$this->controller->rol_config['menuitem_open'] && $this->controller->rol_config['opening_site_type2']=='menuitem'){							
								echo JText::_('COM_REDIRECTONLOGIN_NO_MENUITEM_SELECTED');							
							}									
							?>						
						</td>
						<td width="150">						
							<label><input type="radio" name="opening_site_type2" value="menuitem" <?php if($this->controller->rol_config['opening_site_type2']=='menuitem'){echo $checked;}?> /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_MENUITEM'); ?></label>
						</td>
						<td>						
							<?php echo $this->menuitem_open_select; ?>
						</td>
					</tr>	
					<tr>
						<td>&nbsp;						
						</td>
						<td style="text-align: right; color: red;" class="rol_nowrap">
							<?php 
							if($this->controller->rol_config['opening_site']=='yes' && $this->controller->rol_config['opening_site_url']=='' && $this->controller->rol_config['opening_site_type2']=='url'){							
								echo JText::_('COM_REDIRECTONLOGIN_NO_URL');							
							}									
							?>						
						</td>
						<td width="150">						
							<label><input type="radio" name="opening_site_type2" value="url" <?php if($this->controller->rol_config['opening_site_type2']=='url'){echo $checked;}?> /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_URL'); ?></label>
						</td>
						<td>						
							<input type="text" name="opening_site_url" style="width: 450px;" value="<?php echo $this->controller->rol_config['opening_site_url'];?>" /> <?php echo JText::_('COM_REDIRECTONLOGIN_URL_FULL'); ?>.	
						</td>
					</tr>				
					<tr>
						<td>&nbsp;						
						</td>
						<td style="text-align: right; color: red;" class="rol_nowrap">
							<?php 
							if($this->controller->rol_config['opening_site']=='yes' && !$this->controller->rol_config['dynamic_open'] && $this->controller->rol_config['opening_site_type2']=='dynamic'){							
								echo JText::_('COM_REDIRECTONLOGIN_NO_DYNAMIC_REDIRECTS_SELECTED');							
							}									
							?>						
						</td>
						<td width="150">						
							<label><input type="radio" name="opening_site_type2" value="dynamic" <?php if($this->controller->rol_config['opening_site_type2']=='dynamic'){echo $checked;}?> /> 
							<?php echo $this->controller->rol_strtolower(JText::_('COM_REDIRECTONLOGIN_DYNAMIC_REDIRECT')); ?></label>
						</td>
						<td>						
							<?php echo $this->dynamic_open_select; ?>
						</td>
					</tr>
					<tr>
						<td colspan="4">&nbsp;
													
						</td>
					</tr>
					<tr>
						<td>
							<label class="hasTip required"><?php echo JText::_('COM_REDIRECTONLOGIN_DEFAULT_REDIRECT_TYPE_LOGOUT'); ?></label>
						</td>
						<td colspan="3">
							<?php 
							if($this->controller->get_version_type()=='free'){
								echo '<div style="color: red;">';
								echo JText::_('COM_REDIRECTONLOGIN_NOT_IN_FREE_VERSION');
								echo '</div>';
							}
							echo JText::_('COM_REDIRECTONLOGIN_DEFAULT_REDIRECT_TYPE_INFO_FRONTEND_LOGOUT'); ?>.
						</td>					
					</tr>
					<tr>
						<td>&nbsp;
							
						</td>
						<td class="rol_nowrap">
							<label><input type="radio" name="redirect_type_frontend_logout" id="type_frontend_none_logout" value="none" <?php if($this->controller->rol_config['redirect_type_frontend_logout']=='none'){echo $checked;}?> /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_NORMAL'); ?></label>
						</td>
						<td colspan="2">
							<?php 
								echo JText::_('COM_REDIRECTONLOGIN_NORMAL').' Joomla '.$this->controller->rol_strtolower(JText::_('COM_REDIRECTONLOGIN_LOGOUT'));
							?>
						</td>
					</tr>
					<tr>
						<td>&nbsp;
							
						</td>
						<td class="rol_nowrap">
							<label><input type="radio" name="redirect_type_frontend_logout" id="type_frontend_same_logout" value="same" <?php if($this->controller->rol_config['redirect_type_frontend_logout']=='same'){echo $checked;}?> /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_SAME_PAGE'); ?></label>
						</td>
						<td colspan="2">						
						</td>
					</tr>
					<tr>
						<td style="text-align: right; color: red;">
							<?php 
							if($this->controller->rol_config['redirect_type_frontend_logout']=='menuitem' && !$this->controller->rol_config['menuitem_logout']){							
								echo JText::_('COM_REDIRECTONLOGIN_NO_MENUITEM_SELECTED');							
							}				
							?>
						</td>
						<td class="rol_nowrap">
							<label><input type="radio" name="redirect_type_frontend_logout" value="menuitem" <?php if($this->controller->rol_config['redirect_type_frontend_logout']=='menuitem'){echo $checked;}?> />			
							<?php echo JText::_('COM_REDIRECTONLOGIN_MENUITEM'); ?></label>
						</td>
						<td colspan="2">
							<?php echo $this->menuitem_logout_select; ?>
						</td>
					</tr>
					<tr>
						<td style="text-align: right; color: red;">
							<?php 
							if($this->controller->rol_config['redirect_type_frontend_logout']=='url' && $this->controller->rol_config['redirect_url_frontend_logout']==''){							
								echo JText::_('COM_REDIRECTONLOGIN_NO_URL');							
							}				
							?>
						</td>
						<td class="rol_nowrap">
							<label><input type="radio" name="redirect_type_frontend_logout" value="url" <?php if($this->controller->rol_config['redirect_type_frontend_logout']=='url'){echo $checked;}?> />			
							<?php echo JText::_('COM_REDIRECTONLOGIN_URL'); ?></label>
						</td>
						<td colspan="2">
							<input type="text" name="redirect_url_frontend_logout" style="width: 450px;" value="<?php echo $this->controller->rol_config['redirect_url_frontend_logout'];?>" /> <?php echo JText::_('COM_REDIRECTONLOGIN_URL_FULL'); ?>.
						</td>
					</tr>				
					<tr>
						<td style="text-align: right; color: red;">
							<?php 
							if($this->controller->rol_config['redirect_type_frontend_logout']=='dynamic' && !$this->controller->rol_config['dynamic_logout']){							
								echo JText::_('COM_REDIRECTONLOGIN_NO_DYNAMIC_REDIRECTS_SELECTED');							
							}				
							?>
						</td>
						<td class="rol_nowrap">
							<label><input type="radio" name="redirect_type_frontend_logout" value="dynamic" <?php if($this->controller->rol_config['redirect_type_frontend_logout']=='dynamic'){echo $checked;}?> />			
							<?php echo $this->controller->rol_strtolower(JText::_('COM_REDIRECTONLOGIN_DYNAMIC_REDIRECT')); ?></label>
						</td>
						<td colspan="2">
							<?php echo $this->dynamic_logout_select; ?>
						</td>
					</tr>
					<tr>
						<td colspan="4">&nbsp;	
						<a name="multilanguage"></a>											
						</td>
					</tr>
					<tr>
						<td>
							<?php 				
								echo JText::_('COM_REDIRECTONLOGIN_MULTILANG_A');	
							?>
						</td>
						<td class="rol_nowrap">
							<?php
								if($this->controller->get_version_type()=='free'){
									echo '<div style="color: red;">';
									echo JText::_('COM_REDIRECTONLOGIN_NOT_IN_FREE_VERSION');
									echo '</div>';
								}
							?>
							<label><input type="checkbox" class="checkbox" name="multilanguage_menu_association" value="true" <?php if($this->controller->rol_config['multilanguage_menu_association']){echo 'checked="checked"';} ?> /> <?php echo JText::_('COM_REDIRECTONLOGIN_MULTILANG_B'); ?></label>
						</td>
						<td colspan="2">
							<?php echo JText::_('COM_REDIRECTONLOGIN_MULTILANG_F').'.<br />'.JText::_('COM_REDIRECTONLOGIN_MULTILANG_C').'. '.JText::_('COM_REDIRECTONLOGIN_MULTILANG_G').'. '.JText::_('COM_REDIRECTONLOGIN_MULTILANG_D'); ?>.
						</td>					
					</tr>					
					<tr>
						<td colspan="4">&nbsp;
						</td>
					</tr>								
				</table>			
			</fieldset>		
			<a name="backend"></a>
			<fieldset class="adminform">
			<legend class="rol_legend"><?php echo JText::_('COM_REDIRECTONLOGIN_BACKEND'); ?></legend>		
			<table class="adminlist rol_table tabletop">				
				<tr>
					<td class="rol_nowrap" style="width: 250px;">
						<label class="hasTip required"><?php echo JText::_('COM_REDIRECTONLOGIN_DEFAULT_REDIRECT_TYPE_LOGIN'); ?></label>
					</td>
					<td colspan="2">
						<?php 
						if($this->controller->get_version_type()=='free'){
							echo '<div style="color: red;">';
							echo JText::_('COM_REDIRECTONLOGIN_NOT_IN_FREE_VERSION');
							echo '</div>';
						}
						echo JText::_('COM_REDIRECTONLOGIN_DEFAULT_REDIRECT_TYPE_INFO'); ?>.
					</td>					
				</tr>
				<tr>
					<td>&nbsp;
						
					</td>
					<td class="rol_nowrap" style="width: 150px;">
						<label><input type="radio" name="redirect_type_backend" value="none" <?php if($this->controller->rol_config['redirect_type_backend']=='none'){echo $checked;}?> /> 
						<?php echo JText::_('COM_REDIRECTONLOGIN_NORMAL'); ?></label>
					</td>
					<td>
						<?php echo JText::_('COM_REDIRECTONLOGIN_TO_CONTROL_PANEL'); ?>
					</td>
				</tr>
				<tr>
					<td style="text-align: right; color: red;">
						<?php 
						if($this->controller->rol_config['redirect_type_backend']=='url' && $this->controller->rol_config['redirect_url_backend']==''){						
							echo JText::_('COM_REDIRECTONLOGIN_NO_URL');						
						}				
						?>
					</td>
					<td class="rol_nowrap">
						<label><input type="radio" name="redirect_type_backend" value="url" <?php if($this->controller->rol_config['redirect_type_backend']=='url'){echo $checked;}?> /> 
						<?php echo JText::_('COM_REDIRECTONLOGIN_URL'); ?></label>
					</td>
					<td>
						administrator/<input type="text" name="redirect_url_backend" style="width: 450px;" value="<?php echo $this->controller->rol_config['redirect_url_backend'];?>" />
					</td>
				</tr>
				<tr>
					<td style="text-align: right; color: red;">
						<?php 
						if($this->controller->rol_config['redirect_type_backend']=='component' && $this->controller->rol_config['redirect_component_backend']=='0'){						
							echo JText::_('COM_REDIRECTONLOGIN_NO_COMPONENT_SELECTED');						
						}						
						?>
					</td>
					<td class="rol_nowrap">
						<label><input type="radio" name="redirect_type_backend" value="component" <?php if($this->controller->rol_config['redirect_type_backend']=='component'){echo $checked;}?> /> 
						<?php echo JText::_('COM_REDIRECTONLOGIN_COMPONENT'); ?>&nbsp;</label>
					</td>
					<td>
						<select name="redirect_component_backend">	
						<?php
						echo '<option value="0"> - '.JText::_('COM_REDIRECTONLOGIN_SELECT_COMPONENT').' - </option>';							
						for($n = 0; $n < count($this->components); $n++){							
							echo '<option value="'.$this->components[$n][1].'"';
							if($this->controller->rol_config['redirect_component_backend']==$this->components[$n][1]){
								echo ' selected="selected"';
							}
							echo '>';												
							echo $this->controller->rol_strtolower($this->components[$n][0]);
							echo '</option>';								
						}
						?>						
						</select> 
					</td>
				</tr>
				<tr>
					<td>&nbsp;
						
					</td>
					<td>
						<label><input type="radio" name="redirect_type_backend" value="logout" <?php if($this->controller->rol_config['redirect_type_backend']=='logout'){echo $checked;}?> /> 
						<?php echo JText::_('COM_REDIRECTONLOGIN_BLOCK_LOGIN'); ?></label>
					</td>
					<td><?php echo JText::_('COM_REDIRECTONLOGIN_LOGOUT_A'); ?>. 
						<?php echo JText::_('COM_REDIRECTONLOGIN_DONT_LOCK_YOURSELF_OUT'); ?>! 
						<?php echo JText::_('COM_REDIRECTONLOGIN_LOGOUT_C'); ?>.
						<br />
						<?php echo JText::_('COM_REDIRECTONLOGIN_LOGOUT_MESSAGE'); ?>: 					
						<table class="adminlist rol_table nopaddingleft">
							<tr>
								<td style="width: 10px;">
									<input type="radio" name="lang_type_login_back" id="lang_type_login_back_custom" value="custom" <?php if($this->controller->rol_config['lang_type_login_back']=='custom'){echo $checked;}?> />
								</td>
								<td>
									<label for="lang_type_login_back_custom">
										<input type="text" name="logout_message_backend" style="width: 450px;" value="<?php echo str_replace('"', '&quot;', $this->controller->rol_config['logout_message_backend']);?>" />
									</label>
								</td>
							</tr>
							<tr>
								<td>
									<input type="radio" name="lang_type_login_back" id="lang_type_login_back_langfile" value="langfile" <?php if($this->controller->rol_config['lang_type_login_back']=='langfile'){echo $checked;}?> />
								</td>
								<td>
									<label for="lang_type_login_back_langfile">
										<?php echo JText::_('COM_REDIRECTONLOGIN_FROM_LANGUAGE_FILE'); ?>:
									</label><br />
									<input type="text" style="width: 450px;" name="" value="<?php 									
										echo JText::_('COM_REDIRECTONLOGIN_YOU_CANT_LOGIN_BACKEND');
									?>" disabled="disabled" /><br />
									<?php echo JText::_('COM_REDIRECTONLOGIN_LANGOVERRIDE'); ?>.  <a href="http://www.pages-and-items.com/extensions/redirect-on-login/faqs?faqitem=config_language-overrides" target="_blank"><?php echo JText::_('COM_REDIRECTONLOGIN_READ_MORE'); ?></a>
								</td>						
							</tr>
						</table>
					</td>
				</tr>
			</table>
				
			</fieldset>
			<a name="redirect_order"></a>
			<fieldset class="adminform">
				<legend class="rol_legend"><?php echo JText::_('COM_REDIRECTONLOGIN_REDIRECT_ORDER'); ?></legend>
				<div class="rol_fontsize tabletop" style="background: #fff; padding: 10px;">
					<?php echo JText::_('COM_REDIRECTONLOGIN_REDIRECT_ORDER_INFO'); ?>.
					<br /><br />
					1. <?php echo JText::_('COM_REDIRECTONLOGIN_REDIRECT_ORDER1'); ?><br />
					2. <?php echo JText::_('COM_REDIRECTONLOGIN_REDIRECT_ORDER2'); ?><br />
					3. <?php echo JText::_('COM_REDIRECTONLOGIN_REDIRECT_ORDER3'); ?><br />
					4. <?php echo JText::_('COM_REDIRECTONLOGIN_REDIRECT_ORDER4'); ?>
				</div>
				
			</fieldset>
			
			<fieldset class="adminform">
				<legend class="rol_legend"><?php echo JText::_('JVERSION'); ?></legend>
				<table class="adminlist rol_table tabletop">	
					<tr>		
						<td class="rol_nowrap" style="width: 250px;">
							<?php echo $this->controller->rol_strtolower(JText::_('JVERSION')); ?>	
						</td>
						<td style="width: 150px;">
							<?php echo $this->controller->rol_version.' ('.$this->controller->get_version_type().' '.$this->controller->rol_strtolower(JText::_('JVERSION')).')'; ?>
						</td>
						<td>
							<input type="button" value="<?php echo JText::_('COM_REDIRECTONLOGIN_CHECK_LATEST_VERSION'); ?>" onclick="check_latest_version();" />					
							<div id="version_checker_target"></div>	
							<span id="version_checker_spinner"><img src="components/com_redirectonlogin/images/processing.gif" alt="processing" /></span>				
						</td>
					</tr>	
					<tr>		
						<td>
							<?php echo JText::_('COM_REDIRECTONLOGIN_VERSION_CHECKER'); ?>	
						</td>
						<td>
							<label><input type="checkbox" class="checkbox" name="version_checker" value="true" <?php if($this->controller->rol_config['version_checker']){echo 'checked="checked"';} ?> /> <?php echo $this->controller->rol_strtolower(JText::_('COM_REDIRECTONLOGIN_ENABLE')); ?></label>
						</td>
						<td>
							<?php 
								echo JText::_('COM_REDIRECTONLOGIN_VERSION_CHECKER_INFO_A').' ';
								echo 'Redirect-on-Login ';
								echo JText::_('COM_REDIRECTONLOGIN_VERSION_CHECKER_INFO_B');
							?>.				
						</td>
					</tr>			
					<tr>		
						<td colspan="3">&nbsp;
							
						</td>
					</tr>
				</table>
			</fieldset>
		</div>	
		
		<input type="hidden" name="task" value="" />	
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
